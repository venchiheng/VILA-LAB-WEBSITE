<template>
  <div class="table-container">
    <div class="table-header">
      <h2 class="text-h5 font-weight-bold mb-4">Equipment List</h2>

      <div class="filters">
        <v-text-field
          v-model="searchName"
          density="compact"
          placeholder="Search equipment..."
          hide-details
        />
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
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in paginatedItems" :key="item.id">
          <td class="cell-center">{{ item.name }}</td>
          <td class="cell-center">{{ item.description }}</td>
          <td class="cell-center">
            <span class="status-badge" :class="getAvailabilityClass(item.availability)">
              {{ item.availability }}
            </span>
          </td>
          <td class="cell-center">{{ item.condition }}</td>
          <td class="cell-center">{{ item.stock }}</td>
          <td class="cell-center">{{ item.created_at }}</td>
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
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
// import { api } from '@/lib/api.js'
import api from '../../services/api'

const items = ref([])
const searchName = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

const fetchEquipment = async () => {
  try {
    const res = await api.get('/equipment')
    items.value = res.data.data
  } catch (err) {
    console.error('Failed to fetch equipment', err)
    items.value = []
  }
}

onMounted(fetchEquipment)

// Filtering
const filteredItems = computed(() =>
  items.value.filter(item =>
    !searchName.value || item.name.toLowerCase().includes(searchName.value.toLowerCase())
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

const getAvailabilityClass = availability => {
  const map = { available: 'approved', booked: 'pending' }
  return map[availability] || ''
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
</style>
