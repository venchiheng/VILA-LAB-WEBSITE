<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <!-- Sidebar -->
    <Sidebar :activeTab="'Projects'" @tab-change="handleTabChange" />

    <!-- Main content -->
    <main class="main-content">
      <TopNav :user="user" @toggle-theme="toggleTheme" />

      <div class="dashboard-content">
        <!-- Projects Table -->
        <div class="table-container mb-6">
          <div class="table-header">
            <h2 class="text-h5 font-weight-bold mb-4">All Projects</h2>
            <v-text-field
              v-model="searchProject"
              density="compact"
              placeholder="Search project..."
              hide-details
            />
          </div>

          <table class="booking-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Members</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="project in filteredProjects"
                :key="project.id"
                @click="selectProject(project)"
                class="project-row"
              >
                <td class="cell-center">{{ project.title }}</td>
                <td class="cell-center">{{ project.category.name }}</td>
                <td class="cell-center">
                  <span class="status-badge" :class="getStatusClass(project.status)">
                    {{ project.status }}
                  </span>
                </td>
                <td class="cell-center">{{ project.members.length }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Project Members Table -->
        <div v-if="selectedProject" class="table-container">
          <div class="table-header">
            <h2 class="text-h5 font-weight-bold mb-4">
              Members of "{{ selectedProject.title }}"
            </h2>
            <div class="filters">
              <v-text-field
                v-model="searchName"
                density="compact"
                placeholder="Search name..."
                hide-details
              />
              <v-text-field
                v-model="searchRole"
                density="compact"
                placeholder="Search role..."
                hide-details
              />
            </div>
          </div>

          <table class="booking-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Member ID</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="member in paginatedMembers" :key="member.id">
                <td class="cell-center">{{ member.user.id }}</td>
                <td class="cell-center">{{ member.user.name }}</td>
                <td class="cell-center">{{ member.user.email }}</td>
                <td class="cell-center">
                  <span class="status-badge" :class="getRoleClass(member.role)">
                    {{ member.role }}
                  </span>
                </td>
                <td class="cell-center">{{ member.user.member_id }}</td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="pagination">
            <button class="btn-prev" @click="prevPage" :disabled="page === 1">
              Previous
            </button>
            <span>Page {{ page }} of {{ totalPages }}</span>
            <button class="btn-next" @click="nextPage" :disabled="page === totalPages">
              Next
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import Sidebar from '@/components/admin/sidebar.vue'
import TopNav from '@/components/admin/topnav.vue'

const darkMode = ref(false)
const user = ref({
  name: 'Admin User',
  email: 'admin@viliab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

const projects = ref([])
const searchProject = ref('')
const selectedProject = ref(null)

const members = ref([])
const searchName = ref('')
const searchRole = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

// Fetch all projects
const fetchProjects = async () => {
  try {
    const res = await axios.get('http://localhost:8000/api/projects')
    projects.value = res.data.data
  } catch (err) {
    console.error('Failed to fetch projects', err)
  }
}

// Fetch project members
const fetchMembers = async (projectId) => {
  try {
    const res = await axios.get(`http://localhost:8000/api/projects/${projectId}/members`)
    members.value = res.data
    page.value = 1 // reset pagination when switching project
  } catch (err) {
    console.error('Failed to fetch members', err)
    members.value = []
  }
}

// Select project to show members
const selectProject = (project) => {
  selectedProject.value = project
  fetchMembers(project.id)
}

// Filter projects by search
const filteredProjects = computed(() =>
  projects.value.filter(p =>
    p.title.toLowerCase().includes(searchProject.value.toLowerCase())
  )
)

// Filter members by name & role
const filteredMembers = computed(() =>
  members.value.filter(
    m =>
      (!searchName.value || m.user.name.toLowerCase().includes(searchName.value.toLowerCase())) &&
      (!searchRole.value || m.role.toLowerCase().includes(searchRole.value.toLowerCase()))
  )
)

// Pagination for members
const totalPages = computed(() => Math.ceil(filteredMembers.value.length / itemsPerPage.value))
const paginatedMembers = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredMembers.value.slice(start, end)
})
const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

const getRoleClass = role => {
  const map = { member: 'pending', admin: 'approved', manager: 'in-use' }
  return map[role] || 'pending'
}

const getStatusClass = status => {
  const map = { ongoing: 'in-use', completed: 'completed', pending: 'pending' }
  return map[status] || 'pending'
}

onMounted(fetchProjects)

const handleTabChange = (tab) => console.log('Tab changed to:', tab)
const toggleTheme = () => darkMode.value = !darkMode.value
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
.booking-table tbody tr:hover { background: #f9fafb; cursor: pointer; }

.status-badge { display: inline-block; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; border-radius: 9999px; }
.status-badge.pending { background: #fef3c7; color: #92400e; }
.status-badge.approved { background: #d1fae5; color: #065f46; }
.status-badge.in-use { background: #dbeafe; color: #1e40af; }
.status-badge.completed { background: #f3e8ff; color: #5b21b6; }

.filters { display: flex; gap: 1rem; margin-bottom: 1rem; }

.pagination { display: flex; justify-content: flex-end; align-items: center; gap: 1rem; margin-top: 1rem; }
.pagination button { padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; color: white; }
.btn-prev { background-color: #ef4444; } .btn-prev:disabled { background-color: #fca5a5; cursor: not-allowed; }
.btn-next { background-color: #22c55e; } .btn-next:disabled { background-color: #86efac; cursor: not-allowed; }

.project-row:hover { background: #f3f4f6; }
</style>
