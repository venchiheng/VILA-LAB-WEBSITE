<template>
  <nav class="top-nav">
    <div class="nav-left">
      <div class="breadcrumb">
       {{ activeTab }}
      </div>
    </div>
    <div class="nav-right">
      
      <div class="user-info">
        <div class="user-details">
          <div class="user-name">{{ user.name }}</div>
          <div class="user-email">{{ user.email }}</div>
        </div>
        <img :src="user.avatar" alt="User" class="user-avatar" />
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'  

defineProps({
  user: Object,
  activeTab: String
})

defineEmits(['toggle-theme'])

const darkMode = ref(false)
</script>

<style scoped>
.top-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background: white;
  border-bottom: 1px solid #e5e7eb;
}

.dark-mode .top-nav {
  background: #1f2937;
  border-color: #374151;
}

.breadcrumb {
  color: #6b7280;
  font-size: 0.875rem;
}

.dark-mode .breadcrumb {
  color: #9ca3af;
}

.nav-right {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.theme-toggle {
  background: none;
  border: none;
  font-size: 1.25rem;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 0.375rem;
  transition: background 0.2s;
}

.theme-toggle:hover {
  background: #f3f4f6;
}

.dark-mode .theme-toggle:hover {
  background: #374151;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.user-details {
  text-align: right;
}

.user-name {
  font-weight: 500;
}

.user-email {
  font-size: 0.75rem;
  color: #6b7280;
}

.dark-mode .user-email {
  color: #9ca3af;
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}
</style>