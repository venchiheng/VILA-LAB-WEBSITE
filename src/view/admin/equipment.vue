<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <!-- Sidebar -->
    <Sidebar :activeTab="'Equipment'" @tab-change="handleTabChange" />

    <!-- Main content -->
    <main class="main-content">
      <TopNav :user="user" @toggle-theme="toggleTheme" />

      <div class="dashboard-content">
        <!-- Equipment Table -->
        <div class="table-container mb-6">
          <div class="table-header flex-row">
            <h2 class="text-h5 font-weight-bold mb-4">All Equipment</h2>
            <div class="search-add-wrapper">
              <v-text-field
                v-model="searchEquipment"
                density="compact"
                placeholder="Search equipment..."
                hide-details
                class="search-bar"
              />
              <button class="btn-create" @click="openModal()">Add Equipment</button>
            </div>
          </div>

          <table class="booking-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Availability</th>
                <th>Condition</th>
                <th>Stock</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="item in filteredEquipment"
                :key="item.id"
                class="equipment-row"
              >
                <td class="cell-center">{{ item.name }}</td>
                <td class="cell-center">{{ item.description }}</td>
                <td class="cell-center">
                  <span class="status-badge" :class="getAvailabilityClass(item.availability)">
                    {{ item.availability }}
                  </span>
                </td>
                <td class="cell-center">{{ item.condition }}</td>
                <td class="cell-center">{{ item.stock }}</td>
                <td class="cell-center">
                  <button class="btn-edit" @click="editEquipment(item)">Edit</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Equipment Booking Table -->
        <div v-if="selectedEquipment" class="table-container">
          <div class="table-header">
            <h2 class="text-h5 font-weight-bold mb-4">
              Bookings for "{{ selectedEquipment.name }}"
            </h2>
            <v-text-field
              v-model="searchBooking"
              density="compact"
              placeholder="Search by member or purpose..."
              hide-details
            />
          </div>

          <table class="booking-table">
            <thead>
              <tr>
                <th>Member Name</th>
                <th>Purpose</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Booking Date</th>
                <th>Return Date</th>
                <th v-if="isAdmin">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="booking in paginatedBookings" :key="booking.id">
                <td class="cell-center">{{ booking.full_name }}</td>
                <td class="cell-center">{{ booking.purpose }}</td>
                <td class="cell-center">{{ booking.quantity }}</td>
                <td class="cell-center">
                  <span class="status-badge" :class="getStatusClass(booking.status)">
                    {{ booking.status }}
                  </span>
                </td>
                <td class="cell-center">{{ booking.booking_date }}</td>
                <td class="cell-center">{{ booking.return_date }}</td>
                <td v-if="isAdmin" class="cell-center">
                  <button
                    v-if="booking.status === 'pending'"
                    class="btn-approve"
                    @click="approveBooking(booking.id)"
                  >
                    Approve
                  </button>
                  <button
                    v-if="booking.status === 'pending'"
                    class="btn-reject"
                    @click="rejectBooking(booking.id)"
                  >
                    Reject
                  </button>
                  <button
                    v-if="booking.status === 'approved'"
                    class="btn-return"
                    @click="returnBooking(booking.id)"
                  >
                    Return
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="pagination">
            <button class="btn-prev" @click="prevPage" :disabled="page === 1">
              Previous
            </button>
            <span>Page {{ page }} of {{ totalPages }}</span>
            <button class="btn-next" @click="nextPage" :disabled="page === totalPages">
              Next
            </button>
          </div>
        </div>
      </div>

      <!-- Equipment Modal -->
      <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
          <h3>{{ editingEquipment ? 'Update Equipment' : 'Add New Equipment' }}</h3>
          <form @submit.prevent="saveEquipment">
            <label v-if="!editingEquipment">
              Thumbnail:
              <input type="file" @change="handleFileChange" />
            </label>
            <img
              v-if="previewUrl"
              :src="previewUrl"
              alt="Thumbnail preview"
              width="120"
            />
            <label>
              Name:
              <input v-model="form.name" required />
            </label>
            <label>
              Description:
              <input v-model="form.description" required />
            </label>
            <label>
              Availability:
              <select v-model="form.availability" required>
                <option value="available">Available</option>
                <option value="booked">Booked</option>
              </select>
            </label>
            <label>
              Condition:
              <input v-model="form.condition" required />
            </label>
            <label>
              Stock:
              <input type="number" v-model.number="form.stock" min="0" required />
            </label>

            <div class="modal-actions">
              <button type="submit" class="btn-submit">
                {{ editingEquipment ? 'Update' : 'Create' }}
              </button>
              <button type="button" class="btn-cancel" @click="closeModal">Cancel</button>
            </div>
          </form>
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
const isAdmin = true

// Equipment
const equipmentList = ref([])
const searchEquipment = ref('')
const selectedEquipment = ref(null)

// Bookings
const bookings = ref([])
const searchBooking = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

// Modal & Form
const showModal = ref(false)
const editingEquipment = ref(null)
const form = ref({ name: '', description: '', availability: 'available', condition: '', stock: 0 })

// Fetch Equipment
const fetchEquipment = async () => {
  try {
    const res = await api.get('/equipment')
    equipmentList.value = res.data.data
  } catch (err) {
    console.error(err)
  }
}

// Fetch Bookings
const fetchBookings = async (equipmentId) => {
  try {
    const res = await api.get('/equipment-bookings')
    bookings.value = res.data.data.filter(b => b.equipment?.id === equipmentId)
    page.value = 1
  } catch (err) {
    console.error(err)
    bookings.value = []
  }
}
const previewUrl = ref(null)

function handleFileChange(event) {
  const file = event.target.files[0]
  if (!file) return
  form.value.thumbnail = file
  previewUrl.value = URL.createObjectURL(file)
}

// Select Equipment
const selectEquipment = (equipment) => {
  selectedEquipment.value = equipment
  fetchBookings(equipment.id)
}

// Filtered
const filteredEquipment = computed(() =>
  equipmentList.value.filter(e =>
    e.name.toLowerCase().includes(searchEquipment.value.toLowerCase())
  )
)
const filteredBookings = computed(() =>
  bookings.value.filter(b =>
    (!searchBooking.value || b.full_name.toLowerCase().includes(searchBooking.value.toLowerCase())) ||
    (!searchBooking.value || b.purpose.toLowerCase().includes(searchBooking.value.toLowerCase()))
  )
)

// Pagination
const totalPages = computed(() => Math.ceil(filteredBookings.value.length / itemsPerPage.value))
const paginatedBookings = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredBookings.value.slice(start, end)
})
const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

// Badges
const getAvailabilityClass = availability => {
  const map = { available: 'approved', booked: 'pending' }
  return map[availability] || ''
}
const getStatusClass = status => {
  const map = { approved: 'approved', rejected: 'overdue', pending: 'pending' }
  return map[status] || ''
}

// Booking Actions
const approveBooking = async (id) => { try { await api.put(`/equipment-bookings/${id}/approve`); fetchBookings(selectedEquipment.value.id) } catch(err){console.error(err)} }
const rejectBooking = async (id) => { try { await api.put(`/equipment-bookings/${id}/reject`); fetchBookings(selectedEquipment.value.id) } catch(err){console.error(err)} }
const returnBooking = async (id) => { try { await api.put(`/equipment-bookings/${id}/return`); fetchBookings(selectedEquipment.value.id) } catch(err){console.error(err)} }

// Modal
const openModal = () => {
  editingEquipment.value = null
  form.value = { name: '', description: '', availability: 'available', condition: '', stock: 0 }
  showModal.value = true
}
const closeModal = () => { showModal.value = false; editingEquipment.value = null }
const editEquipment = (equipment) => {
  editingEquipment.value = equipment
  form.value = {
    name: equipment.name,
    description: equipment.description,
    availability: equipment.availability,
    condition: equipment.condition,
    stock: equipment.stock
  }
  showModal.value = true
}


const createEquipment = async () => {
  try {
    const formData = new FormData()
    formData.append('name', form.value.name)
    formData.append('description', form.value.description)
    formData.append('availability', form.value.availability)
    formData.append('condition', form.value.condition)
    formData.append('stock', form.value.stock)
    
    if (form.value.thumbnail instanceof File) {
      formData.append('image', form.value.thumbnail)
    }

    await api.post('/equipment', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    alert('Equipment created successfully!')
    fetchEquipment()
    closeModal()
  } catch (err) {
    console.error(err.response || err)
    alert('Failed to create equipment')
  }
}

const updateEquipment = async () => {
  try {
    const payload = {
      name: form.value.name,
      description: form.value.description,
      availability: form.value.availability,
      condition: form.value.condition,
      stock: form.value.stock
    }

    if (form.value.thumbnail) {
      payload.thumbnail = form.value.thumbnail
    }

    await api.patch(`/equipment/${editingEquipment.value.id}`, payload)
    alert('Equipment updated successfully!')
    fetchEquipment()
    closeModal()
  } catch (err) {
    console.error(err.response || err)
    alert('Failed to update equipment')
  }
}

// Unified save handler
const saveEquipment = () => {
  if (editingEquipment.value) {
    updateEquipment()
  } else {
    createEquipment()
  }
}

onMounted(fetchEquipment)
const handleTabChange = (tab) => console.log('Tab changed to:', tab)
const toggleTheme = () => darkMode.value = !darkMode.value
</script>

<style scoped>
.app-container { display: flex; min-height: 100vh; background-color: #f8fafc; transition: 0.3s; }
.app-container.dark-mode { color: #e5e7eb; }
.main-content { flex: 1; margin-left: 250px; overflow-x: hidden; overflow-y: auto; min-height: 100vh; }
.dashboard-content { padding: 2rem; }

.table-container { background: white; border-radius: 0.75rem; overflow: hidden; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
.booking-table { width: 100%; border-collapse: collapse; }
.booking-table th { padding: 1rem 5px; text-align: center; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
.booking-table td { padding: 1rem 5px; text-align: center; border-bottom: 1px solid #e5e7eb; }
.booking-table tbody tr:hover { background: #f9fafb; cursor: pointer; }

.status-badge { display: inline-block; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; border-radius: 9999px; }
.status-badge.pending { background: #fef3c7; color: #92400e; }
.status-badge.approved { background: #d1fae5; color: #065f46; }
.status-badge.overdue { background: #fee2e2; color: #991b1b; }

.table-header.flex-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 1rem;
}

.search-add-wrapper {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-left: auto;
}

.search-add-wrapper .search-bar {
  width: 250px;
}

.pagination { display: flex; justify-content: flex-end; align-items: center; gap: 1rem; margin-top: 1rem; }
.pagination button { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; color: white; }
.btn-prev { background-color: #ef4444; } .btn-prev:disabled { background-color: #fca5a5; cursor: not-allowed; }
.btn-next { background-color: #22c55e; } .btn-next:disabled { background-color: #86efac; cursor: not-allowed; }

.btn-create { background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; }
.btn-edit { background-color: #fbbf24; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; border: none; cursor: pointer; }
.btn-approve { background-color: #22c55e; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; margin-right: 0.25rem; }
.btn-reject { background-color: #ef4444; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; margin-right: 0.25rem; }
.btn-return { background-color: #3b82f6; color: white; padding: 0.25rem 0.75rem; border-radius: 0.375rem; }

.cell-center { text-align: center; }

.modal-overlay {
  position: fixed; top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;
  z-index: 1000;
}
.modal-content {
  background: white; padding: 2rem; border-radius: 0.5rem; width: 400px;
}
.modal-content h3 { margin-bottom: 1rem; }
.modal-content label { display: block; margin-bottom: 0.5rem; }
.modal-content input, .modal-content select {
  width: 100%; padding: 0.5rem; margin-top: 0.25rem; margin-bottom: 1rem; border-radius: 0.25rem; border: 1px solid #ccc;
}
.modal-actions { display: flex; justify-content: flex-end; gap: 0.5rem; }
.btn-submit { background-color: #22c55e; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; }
.btn-cancel { background-color: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; }
</style>
