<template>
  <div class="table-container">
    <div class="table-header">
      <h2 class="text-h5 font-weight-bold mb-4">Project Members</h2>

      <div class="filters">
        <v-text-field
          v-model="searchName"
          density="compact"
          placeholder="Search name..."
          hide-details
        />
        <v-text-field
          v-model="searchRole"
          density="compact"
          placeholder="Search role..."
          hide-details
        />
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
          <td class="cell-center">{{ member.user.id }}</td>
          <td class="cell-center">{{ member.user.name }}</td>
          <td class="cell-center">{{ member.user.email }}</td>
          <td class="cell-center">
            <span class="status-badge" :class="getRoleClass(member.role)">
              {{ member.role }}
            </span>
          </td>
          <td class="cell-center">{{ member.user.member_id }}</td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button @click="prevPage" :disabled="page === 1">Previous</button>
      <span>Page {{ page }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="page === totalPages">Next</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
  projectId: { type: Number, required: true }
})

const members = ref([])
const searchName = ref('')
const searchRole = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

const fetchMembers = async () => {
  try {
    const res = await axios.get(`http://localhost:8000/api/projects/${props.projectId}/members`)
    members.value = res.data
  } catch (err) {
    console.error('Failed to fetch members', err)
    members.value = []
  }
}

onMounted(fetchMembers)

const filteredMembers = computed(() =>
  members.value.filter(m =>
    (!searchName.value || m.user.name.toLowerCase().includes(searchName.value.toLowerCase())) &&
    (!searchRole.value || m.role.toLowerCase().includes(searchRole.value.toLowerCase()))
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

const getRoleClass = role => {
  const map = { member: 'pending', admin: 'approved', manager: 'in-use' }
  return map[role] || 'pending'
}
</script>

<style scoped>
.table-container {
  background: white;
  border-radius: 0.75rem;
  overflow: hidden;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.booking-table {
  width: 100%;
  border-collapse: collapse;
}

.booking-table th {
  padding: 1rem 5px; /* added extra 5px padding to the right */
  text-align: center; /* align to middle */
  font-size: 0.75rem;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e5e7eb;
  background: #f9fafb;
}

.booking-table td {
  padding: 1rem 5px; /* extra padding right */
  border-bottom: 1px solid #e5e7eb;
  text-align: center; /* align cell content to center */
}

.booking-table tbody tr:hover {
  background: #f9fafb;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
  font-weight: 500;
  border-radius: 9999px;
}

.status-badge.pending { background: #fef3c7; color: #92400e; }
.status-badge.approved { background: #d1fae5; color: #065f46; }
.status-badge.in-use { background: #dbeafe; color: #1e40af; }

.pagination {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 1rem;
  margin-top: 1rem;
}
</style>
