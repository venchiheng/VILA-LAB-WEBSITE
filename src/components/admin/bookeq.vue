<template>
  <div class="table-container">
    <!-- Header with Search -->
    <div class="table-header">
      <h2 class="text-h5 font-weight-bold mb-4">Equipment Booking List</h2>

      <div class="filters">
        <v-text-field
          v-model="searchName"
          density="compact"
          placeholder="Search by member or equipment..."
          hide-details
        />
      </div>
    </div>

    <!-- Table -->
    <table class="booking-table">
      <thead>
        <tr>
          <th>Member Name</th>
          <th>Equipment</th>
          <th>Purpose</th>
          <th>Quantity</th>
          <th>Status</th>
          <th>Booking Date</th>
          <th>Return Date</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="booking in paginatedItems" :key="booking.id">
          <td class="cell-center">{{ booking.full_name }}</td>
          <td class="cell-center">{{ booking.equipment?.name }}</td>
          <td class="cell-center">{{ booking.purpose }}</td>
          <td class="cell-center">{{ booking.quantity }}</td>
          <td class="cell-center">
            <span class="status-badge" :class="getStatusClass(booking.status)">
              {{ booking.status }}
            </span>
          </td>
          <td class="cell-center">{{ booking.booking_date }}</td>
          <td class="cell-center">{{ booking.return_date }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
      <button @click="prevPage" :disabled="page === 1" class="prev-btn">Previous</button>
      <span>Page {{ page }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="page === totalPages" class="next-btn">Next</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { api } from '@/lib/api.js'

const bookings = ref([])
const searchName = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

// Fetch data from protected route using API lib
const fetchBookings = async () => {
  try {
    const res = await api.get('/equipment-bookings')
    bookings.value = res.data.data
  } catch (err) {
    console.error('Failed to fetch bookings', err)
    bookings.value = []
  }
}

onMounted(fetchBookings)

// Filter and paginate
const filteredItems = computed(() =>
  bookings.value.filter(b =>
    !searchName.value || 
    b.full_name.toLowerCase().includes(searchName.value.toLowerCase()) ||
    b.equipment?.name.toLowerCase().includes(searchName.value.toLowerCase())
  )
)

const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage.value))
const paginatedItems = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredItems.value.slice(start, end)
})

const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

const getStatusClass = status => {
  const map = { approved: 'approved', rejected: 'overdue', pending: 'pending' }
  return map[status] || ''
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
  text-align: center;
}

.booking-table th {
  padding: 1rem 10px;
  font-size: 0.75rem;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e5e7eb;
  background: #f9fafb;
}

.booking-table td {
  padding: 0.75rem 10px;
  border-bottom: 1px solid #e5e7eb;
}

.booking-table tbody tr:hover {
  background: #f3f4f6;
  cursor: pointer;
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
.status-badge.overdue { background: #fee2e2; color: #991b1b; }

.pagination {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 1rem;
  margin-top: 1rem;
}

.prev-btn {
  background-color: #f87171;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
}

.next-btn {
  background-color: #34d399;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
}

.prev-btn:disabled,
.next-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.cell-center {
  text-align: center;
}
</style>
