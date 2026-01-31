<template>
  <div class="table-container">
    <div class="table-header">
      <h2 class="text-h5 font-weight-bold mb-4">Users List</h2>

      <div class="filters">
        <v-text-field
          v-model="searchText"
          density="compact"
          placeholder="Search by name, email, or role..."
          hide-details
        />
      </div>
    </div>

    <table class="booking-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Member ID</th>
          <th>Created At</th>
          <!-- <th>Actions</th> -->
        </tr>
      </thead>

      <tbody>
        <tr v-for="user in paginatedItems" :key="user.id">
          <td class="cell-center">{{ user.name }}</td>
          <td class="cell-center">{{ user.email }}</td>
          <td class="cell-center">
            <span class="status-badge" :class="getRoleClass(user.role)">
              {{ user.role }}
            </span>
          </td>
          <td class="cell-center">{{ user.member_id || '-' }}</td>
          <td class="cell-center">{{ user.created_at }}</td>
          <!-- <td class="cell-center">
            <button class="edit-btn" @click="openEditModal(user)">Publish / Edit</button>
          </td> -->
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button class="btn-prev" @click="prevPage" :disabled="page === 1">Previous</button>
      <span>Page {{ page }} of {{ totalPages }}</span>
      <button class="btn-next" @click="nextPage" :disabled="page === totalPages">Next</button>
    </div>
  </div>
  <!-- Modal -->
<div v-if="showModal" class="modal-backdrop">
  <div class="modal">
    <h3>Edit User: {{ selectedUser.name }}</h3>

    <div class="modal-body">
      <label>Name:</label>
      <input type="text" v-model="updatedName" />

      <label>Description:</label>
      <textarea v-model="updatedDescription" rows="3"></textarea>

      <label>Profile Image:</label>
      <input type="file" @change="handleFileChange" />
    </div>

    <div class="modal-actions">
      <button @click="saveChanges">Publish</button>
      <button @click="closeModal">Cancel</button>
    </div>
  </div>
</div>

</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { api } from '@/lib/api.js'

const users = ref([])
const searchText = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

const fetchUsers = async () => {
  try {
    const res = await api.get('/users')
    users.value = res.data.data
  } catch (err) {
    console.error('Failed to fetch users', err)
    users.value = []
  }
}

onMounted(fetchUsers)

// Filter users
const filteredItems = computed(() =>
  users.value.filter(user =>
    !searchText.value ||
    user.name.toLowerCase().includes(searchText.value.toLowerCase()) ||
    user.email.toLowerCase().includes(searchText.value.toLowerCase()) ||
    user.role.toLowerCase().includes(searchText.value.toLowerCase())
  )
)

// Pagination
const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage.value))
const paginatedItems = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredItems.value.slice(start, end)
})

const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

const getRoleClass = role => {
  const map = { admin: 'approved', member: 'pending' }
  return map[role] || ''
}
// Users
// const users = ref([])
// const searchText = ref('')
// const page = ref(1)
// const itemsPerPage = ref(5)

// Modal state
const showModal = ref(false)
const selectedUser = ref(null)
const updatedName = ref('')
const updatedDescription = ref('')
const updatedImage = ref(null)

// Open modal function
const openEditModal = (user) => {
  selectedUser.value = user
  updatedName.value = user.name
  updatedDescription.value = user.description || ''
  updatedImage.value = null
  showModal.value = true
}

// Close modal
const closeModal = () => showModal.value = false

// Handle image selection
const handleFileChange = (e) => {
  updatedImage.value = e.target.files[0]
}

// Save changes
const saveChanges = async () => {
  try {
    const formData = new FormData()
    formData.append('description', updatedDescription.value)

    if (updatedImage.value) {
      formData.append('thumbnail', updatedImage.value)
    }

    const res = await api.put(
      `/project-members/${selectedUser.value.user_id}`,
      formData
    )

    // update local list
    const index = users.value.findIndex(
      u => u.id === selectedUser.value.id
    )
    if (index !== -1) users.value[index] = res.data
    alert('Member updated successfully!')
    closeModal()
  } catch (err) {
    console.error(err)
    alert('Failed to update member')
  }
}
</script>

<style scoped>
.table-container {
  background: white;
  border-radius: 0.75rem;
  overflow: hidden;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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
  padding: 1rem 5px;
  text-align: center;
  font-size: 0.75rem;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  border-bottom: 1px solid #e5e7eb;
  background: #f9fafb;
}

.booking-table td {
  padding: 1rem 5px;
  border-bottom: 1px solid #e5e7eb;
  text-align: center;
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

.pagination {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 1rem;
  margin-top: 1rem;
}

.btn-prev, .btn-next {
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  border: none;
  color: white;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-prev { background-color: #ef4444; } 
.btn-prev:disabled { background-color: #fca5a5; cursor: not-allowed; }

.btn-next { background-color: #22c55e; } 
.btn-next:disabled { background-color: #86efac; cursor: not-allowed; }
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 50;
}

.modal {
  background: white;
  padding: 1.5rem;
  border-radius: 0.5rem;
  width: 400px;
}

.modal-body label {
  display: block;
  margin-top: 1rem;
  font-weight: 500;
}

.modal-body input,
.modal-body textarea {
  width: 100%;
  margin-top: 0.25rem;
  padding: 0.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
}

.modal-actions {
  margin-top: 1rem;
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
}

.modal-actions button {
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  border: none;
  cursor: pointer;
}

.modal-actions button:first-child {
  background-color: #22c55e;
  color: white;
}

.modal-actions button:last-child {
  background-color: #ef4444;
  color: white;
}

</style>
