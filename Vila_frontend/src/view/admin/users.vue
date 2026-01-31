<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <!-- Sidebar -->
    <Sidebar :activeTab="'Users'" @tab-change="handleTabChange" />

    <!-- Main content -->
    <main class="main-content">
      <!-- Top Navigation -->
      <TopNav :user="user" @toggle-theme="toggleTheme" />

      <!-- Page content -->
      <div class="dashboard-content">
        <UsersTable />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/admin/sidebar.vue'
import TopNav from '@/components/admin/topnav.vue'
import UsersTable from '@/components/admin/usersTables.vue'

// Dark mode state
const darkMode = ref(false)

// Logged-in user info
const user = ref({
  name: 'Admin User',
  email: 'admin@vilalab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

// Sidebar tab management
const handleTabChange = (tab) => {
  console.log('Tab changed to:', tab)
}

// Toggle dark mode
const toggleTheme = () => darkMode.value = !darkMode.value
</script>

<style scoped>
.app-container {
  display: flex;
  min-height: 100vh;
  background-color: #f8fafc;
  transition: 0.3s;
}

.app-container.dark-mode {
  background-color: #1a1a1a;
  color: #e5e7eb;
}

.main-content {
  flex: 1;
  margin-left: 250px; /* matches sidebar width */
  overflow-x: hidden;
  overflow-y: auto;
  min-height: 100vh;
}

.dashboard-content {
  padding: 2rem;
}
</style>
