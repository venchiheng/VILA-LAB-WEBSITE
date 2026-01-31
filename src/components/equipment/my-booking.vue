<template>
  <div class="my-booking-page">
    <!-- Booking List -->
    <template v-if="currentView === 'list'">
      <h1>My Booking</h1>

      <!-- Booking Table -->
      <div class="table-wrapper">
        <table class="booking-table">
          <thead>
            <tr>
              <th>Equipment</th>
              <th>Equipment ID</th>
              <th>Booking Date</th>
              <th>Return Date</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            <tr 
              v-for="item in bookings" 
              :key="item.id" 
              @click="$router.push({ name: 'EquipmentDetail', params: { id: item.code } })"
              style="cursor: pointer;"
            >
              <td>{{ item.name }}</td>
              <td>{{ item.code }}</td>
              <td>{{ item.booking_date }}</td>
              <td>{{ item.return_date }}</td>
              <td>
                <span class="status-pill" :class="item.status.toLowerCase()">
                  {{ item.status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Booking Image -->
      <div class="booking-image-wrapper">
        <img src="@/assets/equipment/booking.png" alt="Booking info" />
      </div>

      <!-- Recommended Items -->
      <h4 class="section-title">Recommended Items</h4>
      <div class="equipment-grid">
        <EquipmentCard
          v-for="item in recommended"
          :key="item.id"
          :name="item.name"
          :specification="item.spec"
          :image="item.image"
          :status="item.availability"
          @view-detail="$router.push({ name: 'EquipmentDetail', params: { id: item.code } })"
        />
      </div>
    </template>

    <!-- Equipment Detail -->
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
import { ref, onMounted } from 'vue'
import { useEquipmentBookingStore } from '../../stores/equipementBooking'
import EquipmentCard from '@/components/equipment/EquipmentCard.vue'
import EquipmentDetail from '@/components/equipment/equipment-detail.vue'

// Views
const currentView = ref('list') // list | detail
const selectedEquipment = ref(null)

// Pinia store
const equipmentStore = useEquipmentBookingStore()
const bookings = ref([])
const recommended = ref([]) // Could also fetch dynamically

// Fetch bookings from backend
onMounted(async () => {
  await equipmentStore.fetchBookings()

  // Map bookings for table
  bookings.value = equipmentStore.bookings.map(booking => ({
    id: booking.id,
    name: booking.equipment.name,
    code: booking.equipment.id,
    booking_date: booking.booking_date,
    return_date: booking.return_date,
    status: booking.status,
    availability: booking.equipment.availability,
    description: booking.equipment.condition || '',
    image: booking.equipment.image
      ? `https://52.87.185.116:8000/storage/${booking.equipment.image}`
      : '/src/assets/equipment/default.png'
  }))

  // Recommended: only available items
  recommended.value = bookings.value.filter(
    item => item.availability.toLowerCase() === 'available'
  )
})

// Back to list
const backToList = () => {
  selectedEquipment.value = null
  currentView.value = 'list'
}
</script>

<style scoped>
.my-booking-page {
  padding: 40px 156px;
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
  border-collapse: collapse;
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

.pending { background: var(--color-warning); color: var(--color-bg); }
.in_use { background: var(--color-primary); color: var(--color-bg); }
.overdue { background: var(--color-error); color: var(--color-bg); }
.approved { background: var(--color-secondary); color: var(--color-primary); }
.returned { background: var(--color-success); color: var(--color-bg); }
.rejected { background: #e0e0e0; color: var(--color-text); }

.booking-image-wrapper {
  margin: 60px 0;
  width: 100vw;
  margin-left: calc(-156px);
  position: relative;
}

.booking-image-wrapper img {
  width: 100%;
  display: block;
  object-fit: cover;
}

.equipment-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 50px 55px;
  justify-content: flex-start;
}

.equipment-thumb {
  margin-right: 8px;
  vertical-align: middle;
  border-radius: 4px;
  width: 40px;
  height: 40px;
  object-fit: cover;
}
</style>
