<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <!-- Sidebar -->
    <Sidebar
      :activeTab="activeTab"
      @tab-change="handleTabChange"
    />

    <!-- Main Content -->
    <main class="main-content">
      <!-- Top Navigation -->
      <TopNav
        :user="user"
        @toggle-theme="toggleTheme"
      />

      <div class="dashboard-content">
        <!-- Header -->
        <div class="dashboard-header">
          <h1>Achievements & Publications</h1>
          <p class="subtitle">
            Manage academic achievements and research publications
          </p>
        </div>

        <!-- Tabs -->
        <div class="tabs">
          <button
            class="tab-btn"
            :class="{ active: currentTab === 'achievements' }"
            @click="currentTab = 'achievements'"
          >
            Achievements
          </button>
          <button
            class="tab-btn"
            :class="{ active: currentTab === 'publications' }"
            @click="currentTab = 'publications'"
          >
            Publications
          </button>
        </div>

        <!-- Content -->
        <div class="content-section">
          <Achievement v-if="currentTab === 'achievements'" />

          <Publication v-if="currentTab === 'publications'" />
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'

import Sidebar from '@/components/admin/sidebar.vue'
import TopNav from '@/components/admin/topnav.vue'
import Achievement from '@/components/admin/achievement.vue'
import Publication from '@/components/admin/publication.vue'

/* State */
const darkMode = ref(false)
const activeTab = ref('Achievements & Publications')
const currentTab = ref('achievements')

const user = ref({
  name: 'Admin User',
  email: 'admin@viliab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff',
})

/* Methods */
const toggleTheme = () => {
  darkMode.value = !darkMode.value
}

const handleTabChange = (tab) => {
  activeTab.value = tab
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
  margin-left: 250px;
}

.dashboard-content {
  padding: 2rem;
}

.dashboard-header {
  margin-bottom: 1.5rem;
}

.dashboard-header h1 {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
}

.dark-mode .dashboard-header h1 {
  color: #f9fafb;
}

.subtitle {
  font-size: 0.9rem;
  color: #6b7280;
}

.dark-mode .subtitle {
  color: #9ca3af;
}

/* Tabs */
.tabs {
  display: flex;
  gap: 8px;
  margin-bottom: 1.5rem;
}

.tab-btn {
  padding: 10px 18px;
  border-radius: 6px;
  border: 1px solid #d1d5db;
  background: white;
  color: #1f2937;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.tab-btn.active {
  background: #4f46e5;
  color: white;
  border-color: #4f46e5;
}

.dark-mode .tab-btn {
  background: #374151;
  color: #e5e7eb;
  border-color: #4b5563;
}

.dark-mode .tab-btn.active {
  background: #6366f1;
}

.content-section {
  background: transparent;
}
</style>