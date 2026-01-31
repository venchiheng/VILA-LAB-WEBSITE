<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
   
    <Sidebar
      :activeTab="activeTab"
      @tab-change="handleTabChange"
    />


    <main class="main-content">

      <TopNav
        :user="user"
        @toggle-theme="toggleTheme"
      />

   
      <div class="dashboard-content">
        <div class="dashboard-header">
          <h1>My Booking</h1>
          <p class="subtitle">Manage and track all your equipment bookings</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
          <StatCard
            title="Total Bookings"
            value="24"
            change="+12%"
            changeType="positive"
            from="last month"
          />
          <StatCard
            title="Active Equipment"
            value="18"
            change="+8%"
            changeType="positive"
            from="last month"
          />
          <StatCard
            title="Completed"
            value="156"
            change="+23%"
            changeType="positive"
            from="last month"
          />
          <StatCard
            title="Pending"
            value="3"
            change="-5%"
            changeType="negative"
            from="last month"
          />
        </div>

        <!-- Search and Actions -->
        <div class="action-bar">
          <SearchBar @search="handleSearch" />
          <div class="action-buttons">
            
          </div>
        </div>

        <!-- Booking Table -->
        <BookingTable
          :bookings="filteredBookings"
          @status-change="handleStatusChange"
        />

        
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import Sidebar from '@/components/admin/sidebar.vue'
import TopNav from '@/components/admin/topnav.vue'
import StatCard from '@/components/admin/statcard.vue'
import SearchBar from '@/components/admin/searchbar.vue'
import BookingTable from '@/components/admin/bookingtable.vue'
import { onMounted } from 'vue'
import { useEquipmentBookingStore } from '../../stores/equipementBooking'

const equipmentBookingStore = useEquipmentBookingStore()

// Reactive state
const darkMode = ref(false)
const activeTab = ref('My Bookings')
const searchQuery = ref('')
const user = ref({
  name: 'Admin User',
  email: 'admin@vilalab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

// Fetch bookings on mount
onMounted(() => {
  equipmentBookingStore.fetchBookings()
})
// Computed property for filtered bookings
// const filteredBookings = computed(() => {
//   if (!searchQuery.value) return bookings.value
//   return bookings.value.filter(booking =>
//     booking.equipmentName.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
//     booking.equipmentId.includes(searchQuery.value) ||
//     booking.status.toLowerCase().includes(searchQuery.value.toLowerCase())
//   )
// })
const filteredBookings = computed(() => {
  const data = equipmentBookingStore.bookings.map(b => ({
    id: b.id,
    equipmentName: b.equipment?.name,
    equipmentId: b.equipment?.id,
    bookingDate: b.booking_date,
    returnDate: b.return_date,
    status: b.status,
  }));

  if (!searchQuery.value) return data;

  return data.filter(b =>
    b.equipmentName?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    String(b.equipmentId).includes(searchQuery.value) ||
    b.status?.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});


// Methods
const toggleTheme = () => {
  darkMode.value = !darkMode.value
}

const handleTabChange = (tab) => {
  activeTab.value = tab
}

const handleSearch = (query) => {
  searchQuery.value = query
}

const handleFilter = () => {
  // Implement filter logic here
  console.log('Filter clicked')
}

const handleExport = () => {
  // Implement export logic here
  console.log('Export clicked')
}

// const handleStatusChange = (bookingId, newStatus) => {
//   const booking = bookings.value.find(b => b.id === bookingId)
//   if (booking) {
//     booking.status = newStatus
//   }
// }
const handleStatusChange = async (bookingId, action) => {
  try {
    if (action === "approved") {
      await equipmentBookingStore.approveBooking(bookingId);
    }

    if (action === "rejected") {
      await equipmentBookingStore.rejectBooking(bookingId);
    }

    if (action === "returned") {
      await equipmentBookingStore.returnBooking(bookingId);
    }

    if (action === "overdue") {
      await equipmentBookingStore.overdueBooking(bookingId);
    }

    if (action === "in_use") {
      await equipmentBookingStore.inuseBooking(bookingId);
    }
  } catch (e) {
    console.error("Status update failed", e);
  }
};

</script>

<style scoped>
.app-container {
  display: flex;
  min-height: 100vh;
  background-color: #f8fafc;
  transition: background-color 0.3s ease;
}

.app-container.dark-mode {
  background-color: #1a1a1a;
  color: #e5e7eb;
}

.main-content {
  flex: 1;
  margin-left: 250px; /* Sidebar width */
}

.dashboard-content {
  padding: 2rem;
}

.dashboard-header {
  margin-bottom: 2rem;
}

.dashboard-header h1 {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.dark-mode .dashboard-header h1 {
  color: #f9fafb;
}

.subtitle {
  color: #6b7280;
  font-size: 0.875rem;
}

.dark-mode .subtitle {
  color: #9ca3af;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.action-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  padding: 1rem;
  background: white;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.dark-mode .action-bar {
  background: #2d3748;
}

.action-buttons {
  display: flex;
  gap: 0.75rem;
}

.btn {
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  border: 1px solid #e5e7eb;
  background: white;
}

.btn:hover {
  transform: translateY(-1px);
}

.btn-outline {
  border: 1px solid #d1d5db;
  background: transparent;
}

.btn-primary {
  background: #4f46e5;
  color: white;
  border: none;
}

.dark-mode .btn {
  background: #374151;
  color: #e5e7eb;
  border-color: #4b5563;
}

.icon {
  font-size: 1rem;
}
</style>