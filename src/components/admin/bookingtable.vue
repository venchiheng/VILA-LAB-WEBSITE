<template>
  <div class="table-container">
    <table class="booking-table">
      <thead>
        <tr>
          <th v-for="header in headers" :key="header.key">
            {{ header.label }}
          </th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="booking in bookings" :key="booking.id">
          <td>{{ booking.equipmentName }}</td>
          <td>
            <span class="badge badge-id">{{ booking.equipmentId }}</span>
          </td>
          <td>{{ booking.bookingDate }}</td>
          <td>{{ booking.returnDate }}</td>
          <td>
            <span class="status-badge" :class="getStatusClass(booking.status)">
              {{ booking.status }}
            </span>
          </td>
          <td>
            <div class="action-buttons">
              <button class="btn-action" @click="editBooking(booking.id)">
                ✏️
              </button>
              <select 
                class="status-select"
                :value="booking.status"
                @change="updateStatus(booking.id, $event.target.value)"
              >
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="In Use">In Use</option>
                <option value="Completed">Completed</option>
                <option value="Overdue">Overdue</option>
              </select>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
const props = defineProps({
  bookings: Array
})

const emit = defineEmits(['status-change'])

const headers = [
  { key: 'equipmentName', label: 'Equipment name' },
  { key: 'equipmentId', label: 'Equipment ID' },
  { key: 'bookingDate', label: 'Booking Date' },
  { key: 'returnDate', label: 'Return Date' },
  { key: 'status', label: 'Status' }
]

const getStatusClass = (status) => {
  const statusMap = {
    'Pending': 'pending',
    'Approved': 'approved',
    'In Use': 'in-use',
    'Completed': 'completed',
    'Overdue': 'overdue'
  }
  return statusMap[status] || ''
}

const editBooking = (id) => {
  console.log('Edit booking:', id)
}

const updateStatus = (id, newStatus) => {
  emit('status-change', id, newStatus)
}
</script>

<style scoped>
.table-container {
  background: white;
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.dark-mode .table-container {
  background: #2d3748;
}

.booking-table {
  width: 100%;
  border-collapse: collapse;
}

.booking-table th {
  padding: 1rem;
  text-align: left;
  font-size: 0.75rem;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e5e7eb;
  background: #f9fafb;
}

.dark-mode .booking-table th {
  color: #9ca3af;
  border-color: #374151;
  background: #374151;
}

.booking-table td {
  padding: 1rem;
  border-bottom: 1px solid #e5e7eb;
}

.dark-mode .booking-table td {
  border-color: #374151;
}

.booking-table tbody tr:hover {
  background: #f9fafb;
}

.dark-mode .booking-table tbody tr:hover {
  background: #374151;
}

.badge {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  font-weight: 500;
  border-radius: 0.375rem;
}

.badge-id {
  background: #e0e7ff;
  color: #3730a3;
}

.dark-mode .badge-id {
  background: #3730a3;
  color: #e0e7ff;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
  font-weight: 500;
  border-radius: 9999px;
}

.status-badge.pending {
  background: #fef3c7;
  color: #92400e;
}

.status-badge.approved {
  background: #d1fae5;
  color: #065f46;
}

.status-badge.in-use {
  background: #dbeafe;
  color: #1e40af;
}

.status-badge.completed {
  background: #f3e8ff;
  color: #5b21b6;
}

.status-badge.overdue {
  background: #fee2e2;
  color: #991b1b;
}

.dark-mode .status-badge.pending {
  background: #92400e;
  color: #fef3c7;
}

.dark-mode .status-badge.approved {
  background: #065f46;
  color: #d1fae5;
}

.dark-mode .status-badge.in-use {
  background: #1e40af;
  color: #dbeafe;
}

.dark-mode .status-badge.completed {
  background: #5b21b6;
  color: #f3e8ff;
}

.dark-mode .status-badge.overdue {
  background: #991b1b;
  color: #fee2e2;
}

.action-buttons {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.btn-action {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.25rem;
  border-radius: 0.25rem;
  transition: background 0.2s;
}

.btn-action:hover {
  background: #f3f4f6;
}

.dark-mode .btn-action:hover {
  background: #4b5563;
}

.status-select {
  padding: 0.25rem 0.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  font-size: 0.75rem;
  background: white;
  cursor: pointer;
}

.dark-mode .status-select {
  background: #374151;
  border-color: #4b5563;
  color: #e5e7eb;
}
</style>