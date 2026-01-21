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

// Reactive state
const darkMode = ref(false)
const activeTab = ref('My Bookings')
const searchQuery = ref('')
const user = ref({
  name: 'Admin User',
  email: 'admin@viliab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

// Sample booking data
const bookings = ref([
  {
    id: 1,
    equipmentName: 'Raspberry Pi 5',
    equipmentId: '001',
    bookingDate: '11-12-2025',
    returnDate: '12-12-2025',
    status: 'Pending'
  },
  {
    id: 2,
    equipmentName: 'Raspberry Pi Complete Model 5',
    equipmentId: '002',
    bookingDate: '11-12-2025',
    returnDate: '12-12-2024',
    status: 'In Use'
  },
  {
    id: 3,
    equipmentName: 'Raspberry Pi 3',
    equipmentId: '003',
    bookingDate: '11-12-2025',
    returnDate: '12-12-2024',
    status: 'Overdue'
  },
  {
    id: 4,
    equipmentName: 'Raspberry Pi Complete Model 5',
    equipmentId: '002',
    bookingDate: '11-12-2025',
    returnDate: '12-12-2024',
    status: 'Approved'
  },
  {
    id: 5,
    equipmentName: 'Raspberry Pi 2',
    equipmentId: '007',
    bookingDate: '11-12-2025',
    returnDate: '12-12-2024',
    status: 'Completed'
  }
])

// Computed property for filtered bookings
const filteredBookings = computed(() => {
  if (!searchQuery.value) return bookings.value
  return bookings.value.filter(booking =>
    booking.equipmentName.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    booking.equipmentId.includes(searchQuery.value) ||
    booking.status.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

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

const handleStatusChange = (bookingId, newStatus) => {
  const booking = bookings.value.find(b => b.id === bookingId)
  if (booking) {
    booking.status = newStatus
  }
}
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