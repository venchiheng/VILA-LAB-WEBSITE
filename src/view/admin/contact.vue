<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <!-- Sidebar -->
    <Sidebar :activeTab="'Contact Messages'" @tab-change="handleTabChange" />

    <!-- Main content -->
    <main class="main-content">
      <!-- Top Navigation -->
      <TopNav :user="user" @toggle-theme="toggleTheme" />

      <!-- Page Content -->
      <div class="dashboard-content">
        <!-- Contact Messages Table -->
        <div class="table-container">
          <div class="table-header">
            <h2 class="text-h5 font-weight-bold mb-4">Contact Messages</h2>
            <div class="filters">
              <v-text-field
                v-model="searchName"
                density="compact"
                placeholder="Search by name..."
                hide-details
              />
              <v-text-field
                v-model="searchEmail"
                density="compact"
                placeholder="Search by email..."
                hide-details
              />
            </div>
          </div>

          <table class="booking-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>phone_number</th>
                <th>Message Preview</th>
                <th>Submitted At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="msg in paginatedItems" :key="msg.id">
                <tr>
                  <td class="cell-center">{{ msg.name }}</td>
                  <td class="cell-center">{{ msg.email }}</td>
                  <td class="cell-center">{{ msg.phone_number }}</td>
                  <td class="cell-center">{{ msg.message.substring(0, 50) }}...</td>
                  <td class="cell-center">{{ msg.created_at }}</td>
                  <td class="cell-center">
                    <button style="background-color: var(--color-primary); color: white;" @click="toggleDetails(msg.id)">
                      {{ expandedId === msg.id ? 'Hide Details' : 'View Details' }}
                    </button>
                  </td>
                </tr>

                <tr v-if="expandedId === msg.id">
                  <td colspan="6">
                    <div class="detail-card">
                      <div class="detail-row">
                        <span class="label">Name:</span>
                        <span class="value">{{ msg.name }}</span>
                      </div>
                      <div class="detail-row">
                        <span class="label">Email:</span>
                        <a :href="`mailto:${msg.email}`" class="link">{{ msg.email }}</a>
                      </div>
                      <div class="detail-row">
                        <span class="label">phone_number:</span>
                        <a :href="`tel:${msg.phone_number}`" class="link">{{ msg.phone_number }}</a>
                      </div>
                      <div class="detail-row">
                        <span class="label">Message:</span>
                        <span class="value">{{ msg.message }}</span>
                      </div>
                      <div class="detail-row">
                        <span class="label">Submitted At:</span>
                        <span class="value">{{ msg.created_at }}</span>
                      </div>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="pagination">
            <button class="btn-prev" @click="prevPage" :disabled="page === 1">Previous</button>
            <span>Page {{ page }} of {{ totalPages }}</span>
            <button class="btn-next" @click="nextPage" :disabled="page === totalPages">Next</button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { api } from '@/lib/api.js'
import Sidebar from '@/components/admin/sidebar.vue'
import TopNav from '@/components/admin/topnav.vue'

const darkMode = ref(false)
const toggleTheme = () => darkMode.value = !darkMode.value

const user = ref({
  name: 'Admin User',
  email: 'admin@vilalab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

const messages = ref([])
const searchName = ref('')
const searchEmail = ref('')
const page = ref(1)
const itemsPerPage = ref(5)
const expandedId = ref(null)

// Fetch messages
const fetchMessages = async () => {
  try {
    const res = await api.get('http://44.223.137.10:8000/api/contact-messages') 
    messages.value = res.data.data
  } catch (err) {
    console.error(err)
    messages.value = []
  }
}
onMounted(fetchMessages)

// Filter & paginate
const filteredMessages = computed(() =>
  messages.value.filter(
    m =>
      (!searchName.value || m.name.toLowerCase().includes(searchName.value.toLowerCase())) &&
      (!searchEmail.value || m.email.toLowerCase().includes(searchEmail.value.toLowerCase()))
  )
)
const totalPages = computed(() => Math.ceil(filteredMessages.value.length / itemsPerPage.value))
const paginatedItems = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredMessages.value.slice(start, end)
})
const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

const toggleDetails = (id) => expandedId.value = expandedId.value === id ? null : id

const handleTabChange = (tab) => console.log('Tab changed to:', tab)
</script>

<style scoped>
.app-container { display: flex; min-height: 100vh; background-color: #f8fafc; transition: 0.3s; }
.app-container.dark-mode { background-color: #1a1a1a; color: #e5e7eb; }
.main-content { flex: 1; margin-left: 250px; overflow-x: hidden; overflow-y: auto; min-height: 100vh; }
.dashboard-content { padding: 2rem; }

.table-container { background: white; border-radius: 0.75rem; overflow: hidden; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
.booking-table { width: 100%; border-collapse: collapse; }
.booking-table th { padding: 1rem 5px; text-align: center; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
.booking-table td { padding: 1rem 5px; text-align: center; border-bottom: 1px solid #e5e7eb; }
.booking-table tbody tr:hover { background: #f9fafb; }

.detail-card { background: #f3f4f6; padding: 1rem; border-radius: 0.5rem; margin-top: 0.5rem; }
.detail-row { display: flex; gap: 0.5rem; margin-bottom: 0.5rem; }
.label { font-weight: 500; min-width: 120px; color: #6b7280; }
.value { color: #111827; }
.link { color: #3b82f6; text-decoration: underline; }

.filters { display: flex; gap: 1rem; margin-bottom: 1rem; }

.pagination { display: flex; justify-content: flex-end; align-items: center; gap: 1rem; margin-top: 1rem; }
.pagination button { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; color: white; }
.btn-prev { background-color: #ef4444; } .btn-prev:disabled { background-color: #fca5a5; cursor: not-allowed; }
.btn-next { background-color: #22c55e; } .btn-next:disabled { background-color: #86efac; cursor: not-allowed; }
</style>
