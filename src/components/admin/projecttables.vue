<template>
  <div class="table-container">
    <div class="table-header">
      <h2 class="text-h5 font-weight-bold mb-4">Projects</h2>

      <div class="filters">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search project..."
          class="search-input"
        />
      </div>
    </div>

    <table class="booking-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Category</th>
          <th>Status</th>
          <th>Featured</th>
          <th>Members</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="project in paginatedProjects" :key="project.id">
          <td class="cell-center">{{ project.id }}</td>
          <td class="cell-center">{{ project.title }}</td>
          <td class="cell-center">{{ project.category?.name || '-' }}</td>
          <td class="cell-center">
            <span class="status-badge" :class="getStatusClass(project.status)">
              {{ project.status }}
            </span>
          </td>
          <td class="cell-center">{{ project.is_featured ? 'Yes' : 'No' }}</td>
          <td class="cell-center">{{ project.members.length }}</td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button @click="prevPage" :disabled="page === 1">Previous</button>
      <span>Page {{ page }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="page === totalPages">Next</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const projects = ref([])
const searchQuery = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

// Fetch all projects
const fetchProjects = async () => {
  try {
    const res = await axios.get('http://localhost:8000/api/projects')
    projects.value = res.data.data // as your JSON has "data" key
  } catch (err) {
    console.error('Failed to fetch projects', err)
    projects.value = []
  }
}

onMounted(fetchProjects)

// Filtered projects
const filteredProjects = computed(() =>
  projects.value.filter(p =>
    !searchQuery.value ||
    p.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    p.category?.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    p.status.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
)

// Pagination
const totalPages = computed(() => Math.ceil(filteredProjects.value.length / itemsPerPage.value))
const paginatedProjects = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredProjects.value.slice(start, end)
})

const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

const getStatusClass = status => {
  const map = { ongoing: 'pending', completed: 'approved', paused: 'in-use' }
  return map[status] || 'pending'
}
</script>

<style scoped>
.table-container {
  background: white;
  border-radius: 0.75rem;
  overflow: hidden;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.search-input {
  padding: 0.5rem 0.75rem;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
  width: 220px;
}

.booking-table {
  width: 100%;
  border-collapse: collapse;
}

.booking-table th {
  padding: 1rem 5px;
  text-align: center;
  font-size: 0.75rem;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e5e7eb;
  background: #f9fafb;
}

.booking-table td {
  padding: 1rem 5px;
  border-bottom: 1px solid #e5e7eb;
  text-align: center;
}

.booking-table tbody tr:hover {
  background: #f9fafb;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
  font-weight: 500;
  border-radius: 9999px;
}

.status-badge.pending { background: #fef3c7; color: #92400e; }
.status-badge.approved { background: #d1fae5; color: #065f46; }
.status-badge.in-use { background: #dbeafe; color: #1e40af; }

.pagination {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 1rem;
  margin-top: 1rem;
}

.pagination button {
  padding: 0.35rem 0.75rem;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
  background: white;
  cursor: pointer;
  transition: background 0.2s;
}

.pagination button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-info {
  font-size: 0.875rem;
  font-weight: 500;
}
</style>
