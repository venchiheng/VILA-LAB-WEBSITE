<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <!-- Sidebar -->
    <Sidebar :activeTab="'Membership Applications'" @tab-change="handleTabChange" />

    <!-- Main content -->
    <main class="main-content">
      <!-- Top Navigation -->
      <TopNav :user="user" @toggle-theme="toggleTheme" />

      <!-- Page Content -->
      <div class="dashboard-content">
        <!-- Membership Applications Table -->
        <div class="table-container">
          <div class="table-header">
            <h2 class="text-h5 font-weight-bold mb-4">Membership Applications</h2>
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
                <th>Full Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Reviewed By</th>
                <th>Submitted At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="application in paginatedItems" :key="application.id">
                <tr>
                  <td class="cell-center">{{ application.full_name }}</td>
                  <td class="cell-center">{{ application.email }}</td>
                  <td class="cell-center">
                    <span class="status-badge" :class="getStatusClass(application.status)">
                      {{ application.status }}
                    </span>
                  </td>
                  <td class="cell-center">{{ application.reviewed_by || '-' }}</td>
                  <td class="cell-center">{{ application.submitted_at }}</td>
                  <td class="cell-center">
                    <button class="vh" @click="toggleDetails(application.id)">
                      {{ expandedId === application.id ? 'Hide Details' : 'View Details' }}
                    </button>
                  </td>
                </tr>

                <tr v-if="expandedId === application.id">
                  <td colspan="6">
                    <MemberAnswerCard :application="application" />
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
// import { api } from '@/lib/api.js'
import api from '../../services/api'
import Sidebar from '@/components/admin/sidebar.vue'
import TopNav from '@/components/admin/topnav.vue'
import MemberAnswerCard from '@/components/admin/MemberAnswerCard.vue'

// Dark mode
const darkMode = ref(false)
const toggleTheme = () => darkMode.value = !darkMode.value

// Admin user
const user = ref({
  name: 'Admin User',
  email: 'admin@vilalab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

// Applications
const applications = ref([])
const searchName = ref('')
const searchEmail = ref('')
const page = ref(1)
const itemsPerPage = ref(5)
const expandedId = ref(null)

// Fetch applications
const fetchApplications = async () => {
  try {
    const res = await api.get('/membership-applications')
    applications.value = res.data.data
  } catch (err) {
    console.error(err)
    applications.value = []
  }
}
onMounted(fetchApplications)

// Filter & paginate
const filteredApplications = computed(() =>
  applications.value.filter(
    a =>
      (!searchName.value || a.full_name.toLowerCase().includes(searchName.value.toLowerCase())) &&
      (!searchEmail.value || a.email.toLowerCase().includes(searchEmail.value.toLowerCase()))
  )
)
const totalPages = computed(() => Math.ceil(filteredApplications.value.length / itemsPerPage.value))
const paginatedItems = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredApplications.value.slice(start, end)
})
const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

// Toggle details
const toggleDetails = (id) => expandedId.value = expandedId.value === id ? null : id

// Status badge
const getStatusClass = status => {
  const map = { approved: 'approved', rejected: 'rejected', pending: 'pending' }
  return map[status] || 'pending'
}

const handleTabChange = (tab) => console.log('Tab changed to:', tab)
</script>

<style scoped>
.vh{ background-color: var(--color-primary); color: white; border: none;}
.app-container { display: flex; min-height: 100vh; background-color: #f8fafc; transition: 0.3s; }
.app-container.dark-mode { background-color: #1a1a1a; color: #e5e7eb; }
.main-content { flex: 1; margin-left: 250px; overflow-x: hidden; overflow-y: auto; min-height: 100vh; }
.dashboard-content { padding: 2rem; }

.table-container { background: white; border-radius: 0.75rem; overflow: hidden; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem; }
.booking-table { width: 100%; border-collapse: collapse; }
.booking-table th { padding: 1rem 5px; text-align: center; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
.booking-table td { padding: 1rem 5px; text-align: center; border-bottom: 1px solid #e5e7eb; }
.booking-table tbody tr:hover { background: #f9fafb; }

.status-badge { display: inline-block; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; border-radius: 9999px; }
.status-badge.approved { background: #d1fae5; color: #065f46; }
.status-badge.rejected { background: #fee2e2; color: #991b1b; }
.status-badge.pending { background: #fef3c7; color: #92400e; }

.filters { display: flex; gap: 1rem; margin-bottom: 1rem; }

.pagination { display: flex; justify-content: flex-end; align-items: center; gap: 1rem; margin-top: 1rem; }
.pagination button { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; color: white; }
.btn-prev { background-color: #ef4444; } .btn-prev:disabled { background-color: #fca5a5; cursor: not-allowed; }
.btn-next { background-color: #22c55e; } .btn-next:disabled { background-color: #86efac; cursor: not-allowed; }
</style>
