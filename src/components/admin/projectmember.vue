<template>
  <div v-if="project" class="table-container">
    <div class="table-header">
      <h2 class="text-h5 font-weight-bold mb-4">Members of "{{ project.title }}"</h2>
      <div style="display:flex; gap:12px; margin-bottom:1rem;">
        <v-text-field v-model="searchName" density="compact" placeholder="Search name..." hide-details />
        <v-text-field v-model="searchRole" density="compact" placeholder="Search role..." hide-details />
        <button class="btn-primary" @click="openAddMember">+ Add Member</button>
      </div>
    </div>

    <table class="booking-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Member ID</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="member in paginatedMembers" :key="member.id">
          <td class="cell-center">{{ member.user.id }}</td>
          <td class="cell-center">{{ member.user.name }}</td>
          <td class="cell-center">{{ member.user.email }}</td>
          <td class="cell-center">
            <span class="status-badge" :class="getRoleClass(member.role)">
              {{ member.role }}
            </span>
          </td>
          <td class="cell-center">{{ member.user.member_id }}</td>
          <td class="cell-center">
            <button class="btn-secondary" @click="openEditMember(member)">Edit</button>
            <button class="btn-danger" @click="deleteMember(member.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button class="btn-prev" @click="prevPage" :disabled="page === 1">Previous</button>
      <span>Page {{ page }} of {{ totalPages }}</span>
      <button class="btn-next" @click="nextPage" :disabled="page === totalPages">Next</button>
    </div>

    <!-- Member Modal -->
    <div v-if="showMemberModal" class="modal-overlay">
      <div class="modal-card">
        <h3>{{ isEditMember ? 'Edit Member' : 'Add Member' }}</h3>

        <select v-model="memberForm.user_id" :disabled="isEditMember">
          <option v-for="user in allUsers" :key="user.id" :value="user.id">
            {{ user.name }} ({{ user.email }})
          </option>
        </select>

        <select v-model="memberForm.role">
          <option value="member">Member</option>
          <option value="admin">Admin</option>
          <option value="manager">Manager</option>
        </select>

        <div class="modal-actions">
          <button class="btn-secondary" @click="closeMemberModal">Cancel</button>
          <button class="btn-primary" @click="submitMemberForm">{{ isEditMember ? 'Update' : 'Add' }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({ project: Object })
const emit = defineEmits(['member-updated'])

const members = ref([])
const searchName = ref('')
const searchRole = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

const showMemberModal = ref(false)
const isEditMember = ref(false)
const memberForm = ref({ user_id: null, role: 'member' })
const allUsers = ref([])

const fetchMembers = async () => {
  if (!props.project) return
  try {
    const res = await axios.get(`https://52.87.185.116:8000/api/projects/${props.project.id}/members`)
    members.value = res.data
    page.value = 1
  } catch (err) {
    console.error(err)
    members.value = []
  }
}

const fetchAllUsers = async () => {
  try {
    const res = await axios.get('https://52.87.185.116:8000/api/users')
    allUsers.value = res.data.data
  } catch (err) {
    console.error(err)
  }
}

watch(() => props.project, fetchMembers, { immediate: true })

const filteredMembers = computed(() =>
  members.value.filter(
    m =>
      (!searchName.value || m.user.name.toLowerCase().includes(searchName.value.toLowerCase())) &&
      (!searchRole.value || m.role.toLowerCase().includes(searchRole.value.toLowerCase()))
  )
)

const totalPages = computed(() => Math.ceil(filteredMembers.value.length / itemsPerPage.value))
const paginatedMembers = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  return filteredMembers.value.slice(start, start + itemsPerPage.value)
})

const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

const getRoleClass = role => ({ member: 'pending', admin: 'approved', manager: 'in-use' }[role] || 'pending')

const openAddMember = () => { isEditMember.value = false; memberForm.value = { user_id: null, role: 'member' }; showMemberModal.value = true; fetchAllUsers() }
const openEditMember = member => { isEditMember.value = true; memberForm.value = { ...member }; showMemberModal.value = true }
const closeMemberModal = () => { showMemberModal.value = false; memberForm.value = {} }

const submitMemberForm = async () => {
  try {
    if (!props.project) return
    if (isEditMember.value) {
      await axios.put(`https://52.87.185.116:8000/api/project-members/${memberForm.value.id}`, memberForm.value)
    } else {
      await axios.post(`https://52.87.185.116:8000/api/projects/${props.project.id}/members`, memberForm.value)
    }
    closeMemberModal()
    fetchMembers()
    emit('member-updated')
  } catch (err) { console.error(err); alert('Error saving member') }
}

const deleteMember = async id => {
  if (!confirm('Are you sure?')) return
  try {
    await axios.delete(`https://52.87.185.116:8000/api/project-members/${id}`)
    fetchMembers()
    emit('member-updated')
  } catch (err) { console.error(err); alert('Error deleting member') }
}
</script>
