<template>
  <aside class="sidebar">
    <div class="sidebar-header">
      <h2 class="logo">Admin VilaLab</h2>
    </div>

    <nav class="sidebar-nav">
      <ul>
        <li
          v-for="tab in tabs"
          :key="tab.name"
          :class="{ active: isActive(tab.path) }"
          @click="navigate(tab.path)"
        >
          <span class="nav-icon">{{ tab.icon }}</span>
          <span class="nav-text">{{ tab.label }}</span>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

// Define your sidebar items with their route paths
const tabs = [
  { label: 'Home', path: '/admin/home', icon: '' },
//   { label: 'Dashboard', path: '/admin/dashboard', icon: '' },
  { label: 'Applications', path: '/admin/application', icon: '' },
  { label: 'Equipment', path: '/admin/equipment', icon: '' },
  { label: 'Users', path: '/admin/users', icon: '' },
  { label: 'Projects', path: '/admin/project', icon: '' },
]

// Navigate programmatically
function navigate(path) {
  if (route.path !== path) {
    router.push(path)
  }
}

// Check if the tab is active based on current route
function isActive(path) {
  return route.path === path
}
</script>

<style scoped>
.sidebar {
  width: 250px;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  background: white;
  border-right: 1px solid #e5e7eb;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
}

.dark-mode .sidebar {
  background: #1f2937;
  border-color: #374151;
}

.sidebar-header {
  margin-bottom: 2rem;
}

.logo {
  font-size: 1.5rem;
  font-weight: bold;
  color: #100c5c;
}

.sidebar-nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sidebar-nav li {
  padding: 0.75rem 1rem;
  margin-bottom: 0.5rem;
  border-radius: 0.5rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  transition: all 0.2s;
}

.sidebar-nav li:hover {
  background: #f3f4f6;
}

.dark-mode .sidebar-nav li:hover {
  background: #374151;
}

.sidebar-nav li.active {
  background: #4f46e5;
  color: white;
}

.nav-icon {
  font-size: 1.25rem;
}

.nav-text {
  font-weight: 500;
}
</style>
