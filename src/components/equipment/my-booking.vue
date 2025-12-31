<template>
  <div class="my-booking-page">
    <template v-if="currentView === 'list'">
      <h1>My Booking</h1>

      <div class="table-wrapper">
        <table class="booking-table">
          <thead>
            <tr>
              <th>Equipment name</th>
              <th>Equipment ID</th>
              <th>Booking Date</th>
              <th>Return Date</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="item in bookings" :key="item.id">
              <td>{{ item.name }}</td>
              <td>{{ item.code }}</td>
              <td>{{ item.bookingDate }}</td>
              <td>{{ item.returnDate }}</td>
              <td>
                <span
                  class="status-pill"
                  :class="item.status.toLowerCase()"
                >
                  {{ item.status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Booking Image -->
      <div class="booking-image-wrapper">
        <img
          src="@/assets/equipment/booking.png"
          alt="Booking info"
        />
      </div>

      <h4 class="section-title">Recommended items</h4>

      <div class="equipment-grid">
        <EquipmentCard
          v-for="item in recommended"
          :key="item.id"
          :name="item.name"
          :specification="item.spec"
          :image="item.image"
          :status="item.status"
          @view-detail="openDetail(item)"
        />
      </div>
    </template>

    <EquipmentDetail
      v-if="currentView === 'detail'"
      :equipment="selectedEquipment"
      :source="images"
      color="green"
      @close="backToList"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import EquipmentCard from '@/components/equipment/EquipmentCard.vue'
import EquipmentDetail from '@/components/equipment/equipment-detail.vue'

const currentView = ref('list') // list | detail

const bookings = [
  { id: 1, name: 'Raspberry Pi 5', code: '001', bookingDate: '11-12-2025', returnDate: '12-12-2025', status: 'Pending' },
  { id: 2, name: 'Raspberry Pi Compute Model 5', code: '002', bookingDate: '11-12-2025', returnDate: '12-12-2025', status: 'In_use' },
  { id: 3, name: 'Raspberry Pi 2', code: '003', bookingDate: '11-12-2025', returnDate: '12-12-2025', status: 'Overdue' },
  { id: 4, name: 'Raspberry Pi Compute Model 5', code: '004', bookingDate: '11-12-2025', returnDate: '12-12-2025', status: 'Approved' },
  { id: 5, name: 'Raspberry Pi 2', code: '005', bookingDate: '11-12-2025', returnDate: '12-12-2025', status: 'Returned' },
  { id: 6, name: 'Raspberry Pi Compute Model 5', code: '006', bookingDate: '11-12-2025', returnDate: '12-12-2025', status: 'Rejected' }
]

const recommended = [
  {
    id: 1,
    name: 'Raspberry Pi Compute Model 5',
    spec: '16GB RAM, M.2 SSD',
    image: '/src/assets/equipment/compute5.png',
    status: 'Booked'
  },
  {
    id: 2,
    name: 'Raspberry Pi 5',
    spec: '16GB RAM, M.2 SSD',
    image: '/src/assets/equipment/pi5.png',
    status: 'Available'
  },
  {
    id: 3,
    name: 'Raspberry Pi Compute Model 5',
    spec: '16GB RAM, M.2 SSD',
    image: '/src/assets/equipment/compute5.png',
    status: 'Booked'
  }
]

const selectedEquipment = ref(null)

const openDetail = (item) => {
  selectedEquipment.value = {
    name: item.name,
    thumbnail: item.image,
    status: item.status,
    condition: 'New',
    description: item.spec,
    htmlContent: `
      <p>
        ${item.name} with ${item.spec}.<br />
        Current status: <b>${item.status}</b>
      </p>
    `
  }
  currentView.value = 'detail'
}

const backToList = () => {
  selectedEquipment.value = null
  currentView.value = 'list'
}

const images = ref([
  '/src/assets/equipment/rsbrpi.png',
  '/src/assets/equipment/rsbrpi.png',
  '/src/assets/equipment/rsbrpi.png'
])
</script>

<style scoped>
.my-booking-page {
  padding: 40px 250px 120px;
  text-align: left;
  margin-bottom: 10px;
}

.my-booking-page h1 {
  margin-bottom: 32px;
}

.section-title {
  margin: 60px 20px 24px;
}

.table-wrapper {
  background: var(--color-bg);
  border-radius: 1px;
  overflow: hidden;
}

.booking-table {
  width: 100%;
}

.booking-table thead {
  background: var(--color-primary);
  color: var(--color-bg);
}

.booking-table th,
.booking-table td {
  padding: 16px;
  text-align: center;
}

.booking-table tbody tr {
  border-bottom: 1px solid var(--color-secondary);
}

.booking-table tbody tr:nth-child(even) {
  background: rgba(0, 0, 0, 0.02);
}

.status-pill {
  padding: 6px 14px;
  border-radius: 100px;
  font-size: 13px;
  font-weight: 500;
}

.pending {
  background: var(--color-warning);
  color: var(--color-bg);
}

.in_use {
  background: var(--color-primary);
  color: var(--color-bg);
}

.overdue {
  background: var(--color-error);
  color: var(--color-bg);
}

.approved {
  background: var(--color-secondary);
  color: var(--color-primary);
}

.returned {
  background: var(--color-success);
  color: var(--color-bg);
}

.rejected {
  background: #e0e0e0;
  color: var(--color-text);
}

.booking-image-wrapper {
  margin: 60px 0;
  width: 100%;
}

.booking-image-wrapper img {
  width: 100%;
  display: block;
}

.equipment-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 50px 25px;
  justify-content: flex-start;
}
</style>
