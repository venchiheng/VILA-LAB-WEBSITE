<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <!-- Sidebar -->
    <Sidebar :activeTab="'Projects'" @tab-change="handleTabChange" />

    <!-- Main content -->
    <main class="main-content">
      <TopNav :user="user" @toggle-theme="toggleTheme" />

      <div class="dashboard-content">
        <!-- Projects Table -->
        <div class="table-container">
          <div class="table-header">
            <h2 class="table-title">All Projects</h2>
            <div class="search-add-wrapper">
              <v-text-field
                v-model="searchProject"
                placeholder="Search project..."
                hide-details
                density="compact"
                class="search-bar"
              />
              <button class="btn-create" @click="openModal">New Project</button>
            </div>
          </div>

          <table class="booking-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Members</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="project in filteredProjects" :key="project.id" @click="selectProject(project)" class="project-row">
                <td>{{ project.title }}</td>
                <td>{{ project.category.name }}</td>
                <td>
                  <span class="status-badge" :class="getStatusClass(project.status)">
                    {{ project.status }}
                  </span>
                </td>
                <td>{{ project.members.length }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Project Modal -->
        <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
          <div class="modal-card">
            <h3>{{ editingProject ? 'Update Project' : 'Create Project' }}</h3>
            <form @submit.prevent="saveProject">
              <label>Thumbnail:<input type="file" @change="onFileChange" required /></label>
              <label>Title:<input v-model="form.title" required /></label>
              <label>Description:<textarea v-model="form.description" required></textarea></label>
              <label>Status:
                <select v-model="form.status" required>
                  <option value="ongoing">Ongoing</option>
                  <option value="completed">Completed</option>
                  <option value="on-hold">On Hold</option>
                </select>
              </label>
              <div class="modal-actions">
                <button type="button" class="btn-cancel" @click="closeModal">Cancel</button>
                <button type="submit" class="btn-submit">{{ editingProject ? 'Update' : 'Create' }}</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Members Table -->
        <div v-if="selectedProject" class="table-container">
          <div class="table-header">
            <h2 class="table-title">Members of "{{ selectedProject.title }}"</h2>
            <div class="search-add-wrapper">
              <v-text-field
                v-model="searchMember"
                placeholder="Search member..."
                hide-details
                density="compact"
                class="search-bar"
              />
              <button class="btn-create" @click="openAddMemberModal">New Member</button>
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
              </tr>
            </thead>
            <tbody>
              <tr v-for="member in paginatedMembers" :key="member.id">
                <td>{{ member.user.id }}</td>
                <td>{{ member.user.name }}</td>
                <td>{{ member.user.email }}</td>
                <td>
                  <span class="status-badge" :class="getRoleClass(member.role)">{{ member.role }}</span>
                </td>
                <td>{{ member.user.member_id }}</td>
              </tr>
            </tbody>
          </table>

          <div class="pagination">
            <button class="btn-prev" @click="prevPage" :disabled="page === 1">Previous</button>
            <span>Page {{ page }} of {{ totalPages }}</span>
            <button class="btn-next" @click="nextPage" :disabled="page === totalPages">Next</button>
          </div>
        </div>

        <!-- Add Member Modal -->
        <div v-if="showAddMemberModal" class="modal-overlay" @click.self="closeAddMemberModal">
          <div class="modal-card">
            <h3>Add Member to "{{ selectedProject.title }}"</h3>
            <v-text-field
              v-model="searchMemberId"
              placeholder="Search by Member ID..."
              hide-details
              density="compact"
              class="search-bar"
              @input="fetchUsersByMemberId"
            />
            <div class="user-list">
              <div v-for="user in filteredUsers" :key="user.id" class="user-item"
                   @click="selectUser(user)"
                   :class="{ selected: selectedUser && selectedUser.id === user.id }">
                {{ user.member_id }} - {{ user.name }} - {{ user.email }}
              </div>
            </div>
            <div class="modal-actions">
              <button class="btn-cancel" @click="closeAddMemberModal">Cancel</button>
              <button class="btn-submit" @click="confirmAddMember" :disabled="!selectedUser">Confirm</button>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Sidebar from '@/components/admin/sidebar.vue'
import TopNav from '@/components/admin/topnav.vue'
// import { api } from '@/lib/api.js'
import api from '../../services/api'

const darkMode = ref(false)
const user = ref({
  name: 'Admin User',
  email: 'admin@vilalab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

// Projects
const projects = ref([])
const selectedProject = ref(null)
const searchProject = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

// Project Modal
const showModal = ref(false)
const editingProject = ref(null)
const form = ref({})

// Members
const members = ref([])
const searchMember = ref('')

const selectedFile = ref(null)

// Add Member Modal
const showAddMemberModal = ref(false)
const searchMemberId = ref('')
const users = ref([])
const selectedUser = ref(null)

// --- FETCH PROJECTS ---
const fetchProjects = async () => {
  try {
    const res = await api.get('/projects')
    projects.value = res.data.data
  } catch (err) {
    console.error(err)
  }
}

const selectProject = (project) => {
  selectedProject.value = project
  fetchMembers(project.id)
}

const filteredProjects = computed(() =>
  projects.value.filter(p => p.title.toLowerCase().includes(searchProject.value.toLowerCase()))
)

// --- FETCH MEMBERS ---
const fetchMembers = async (projectId) => {
  try {
    const res = await api.get(`/projects/${projectId}/members`)
    members.value = res.data
    page.value = 1
  } catch (err) {
    console.error(err)
    members.value = []
  }
}

const filteredMembers = computed(() =>
  members.value.filter(
    m =>
      (!searchMember.value || m.user.name.toLowerCase().includes(searchMember.value.toLowerCase())) ||
      (!searchMember.value || m.role.toLowerCase().includes(searchMember.value.toLowerCase()))
  )
)

const totalPages = computed(() => Math.ceil(filteredMembers.value.length / itemsPerPage.value))
const paginatedMembers = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredMembers.value.slice(start, end)
})
const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

// --- BADGES ---
const getRoleClass = role => ({ member: 'pending', admin: 'approved', manager: 'in-use' }[role] || 'pending')
const getStatusClass = status => ({ ongoing: 'in-use', completed: 'completed', 'on-hold': 'pending' }[status] || 'pending')

const onFileChange = (event) => {
  const file = event.target.files[0]
  if (file) selectedFile.value = file
}

// --- PROJECT MODAL ---
const openModal = () => {
  editingProject.value = null
  form.value = { title: '', description: '', status: 'ongoing', category_id: 1 }
  selectedFile.value = null
  showModal.value = true
}
const closeModal = () => { showModal.value = false; editingProject.value = null }
const saveProject = async () => {
  try {
    const formDataToSend = new FormData()

    formDataToSend.append('title', form.value.title)
    formDataToSend.append('description', form.value.description)
    formDataToSend.append('status', form.value.status)
    formDataToSend.append('category_id', form.value.category_id || 1) // fallback
    formDataToSend.append(
      'is_featured',
      form.value.is_featured !== undefined ? form.value.is_featured : 0
    )

    if (selectedFile.value) {
      formDataToSend.append('banner_image', selectedFile.value)
    }

    if (editingProject.value) {
      await api.put(`/projects/${editingProject.value.id}`, formDataToSend, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
      alert('Project updated successfully!')
    } else {
      await api.post('/projects', formDataToSend, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
      alert('Project created successfully!')
    }

    closeModal()
    fetchProjects()
    selectedFile.value = null
  } catch (err) {
    console.error(err)
    alert('Failed to save project')
  }
}

const editProject = (project) => {
  editingProject.value = project
  form.value = { ...project }
  showModal.value = true
}

// --- ADD MEMBER MODAL ---
const openAddMemberModal = () => {
  if (!selectedProject.value) return alert('Select a project first')
  searchMemberId.value = ''
  selectedUser.value = null
  users.value = []
  showAddMemberModal.value = true
}
const closeAddMemberModal = () => {
  showAddMemberModal.value = false
  searchMemberId.value = ''
  selectedUser.value = null
}

const fetchUsersByMemberId = async () => {
  if (!searchMemberId.value) { users.value = []; return }
  try {
    const res = await api.get(`/users?member_id=${searchMemberId.value}`)
    users.value = res.data.data || []
  } catch (err) {
    console.error(err)
    users.value = []
  }
}

const selectUser = (user) => { selectedUser.value = user }

const confirmAddMember = async () => {
  if (!selectedProject.value || !selectedUser.value) return
  try {
    await api.post(`/projects/${selectedProject.value.id}/members`, { user_id: selectedUser.value.id, role: 'member' })
    closeAddMemberModal()
    fetchMembers(selectedProject.value.id)
  } catch (err) {
    console.error(err)
    alert('Failed to add member')
  }
}

const filteredUsers = computed(() => users.value)

// --- MISC ---
onMounted(fetchProjects)
const handleTabChange = (tab) => console.log('Tab changed to:', tab)
const toggleTheme = () => darkMode.value = !darkMode.value
</script>



<style scoped>
.app-container { 
  display: flex; 
  min-height: 100vh; 
  background: #f8fafc; 
  transition: 0.3s; 
}

.main-content { 
  flex: 1; 
  margin-left: 250px; 
  overflow-x: hidden; 
  overflow-y: auto; 
  min-height: 100vh; 
}

.dashboard-content { 
  padding: 2rem; 
}

.table-container { 
  background: white; 
  border-radius: 12px; 
  padding: 1.5rem; 
  margin-bottom: 2rem; 
  box-shadow: 0 1px 5px rgba(0,0,0,.1); 
}

.table-header { 
  display: flex; 
  justify-content: space-between; 
  align-items: center; 
  flex-wrap: wrap; 
  margin-bottom: 1rem; 
}

.table-title { 
  font-size: 1.25rem; 
  font-weight: 600; 
  margin: 0; 
}

.search-add-wrapper {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

/* FIXED WIDTH SEARCH BAR */
.search-bar {
  width: 150px;
  min-width: 150px; 
  max-width: 150px;
}

.booking-table { 
  width: 100%; 
  border-collapse: collapse; 
}

.booking-table th, .booking-table td { 
  padding: .75rem .5rem; 
  text-align: center; 
  border-bottom: 1px solid #e5e7eb; 
}

.booking-table th { 
  font-size: .75rem; 
  font-weight: 600; 
  text-transform: uppercase; 
  color: #6b7280; 
  background: #f9fafb; 
}

.project-row:hover { 
  background: #f3f4f6; 
  cursor: pointer; 
}

.status-badge { 
  display: inline-block; 
  padding: .25rem .75rem; 
  font-size: .75rem; 
  font-weight: 500; 
  border-radius: 9999px; 
}

.status-badge.pending { background: #fef3c7; color: #92400e; }
.status-badge.approved { background: #d1fae5; color: #065f46; }
.status-badge.in-use { background: #dbeafe; color: #1e40af; }
.status-badge.completed { background: #f3e8ff; color: #5b21b6; }

.pagination { 
  display: flex; 
  justify-content: flex-end; 
  align-items: center; 
  gap: 1rem; 
  margin-top: 1rem; 
}

.pagination button { 
  padding: .5rem 1rem; 
  border-radius: .375rem; 
  font-weight: 500; 
  cursor: pointer; 
  border: none; 
  color: white; 
  transition: all .2s; 
}

.btn-prev { background: #ef4444; } 
.btn-prev:disabled { background: #fca5a5; cursor: not-allowed; }
.btn-next { background: #22c55e; } 
.btn-next:disabled { background: #86efac; cursor: not-allowed; }

.btn-create { 
  background: #3b82f6; 
  color: white; 
  padding: .5rem 1rem; 
  border-radius: .375rem; 
  border: none; 
  cursor: pointer; 
  transition: .2s; 
}

.btn-create:hover { background: #2563eb; }

.btn-submit { 
  background: #22c55e; 
  color: white; 
  padding: .5rem 1rem; 
  border-radius: .375rem; 
  border: none; 
  cursor: pointer; 
  transition: .2s; 
}

.btn-submit:hover { background: #16a34a; }

.btn-cancel { 
  background: #ef4444; 
  color: white; 
  padding: .5rem 1rem; 
  border-radius: .375rem; 
  border: none; 
  cursor: pointer; 
  transition: .2s; 
}

.btn-cancel:hover { background: #dc2626; }

.modal-overlay { 
  position: fixed; 
  inset: 0; 
  background: rgba(0,0,0,0.4); 
  display: flex; 
  justify-content: center; 
  align-items: center; 
  z-index: 1000; 
}

.modal-card { 
  background: white; 
  padding: 2rem; 
  width: 400px; 
  border-radius: 12px; 
  display: flex; 
  flex-direction: column; 
  gap: 1rem; 
}

.modal-card input, .modal-card select, .modal-card textarea, .search-bar { 
  width: 100%; 
  padding: .5rem; 
  border-radius: 6px; 
  border: 1px solid #d1d5db; 
  margin-top: .25rem; 
}

textarea { min-height: 80px; resize: vertical; }

.modal-actions { 
  display: flex; 
  justify-content: flex-end; 
  gap: .75rem; 
}

.user-list { 
  max-height: 200px; 
  overflow-y: auto; 
  border: 1px solid #d1d5db; 
  border-radius: 6px; 
  margin-top: .5rem; 
}

.user-item { 
  padding: .5rem; 
  cursor: pointer; 
  transition: background .2s; 
}

.user-item:hover { background: #f3f4f6; }
.user-item.selected { background: #3b82f6; color: white; }

</style>
