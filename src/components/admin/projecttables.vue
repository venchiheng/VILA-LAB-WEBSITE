<template>
  <div class="table-container mb-6">
    <div class="table-header">
      <h2 class="text-h5 font-weight-bold mb-4">All Projects</h2>
      <div style="display:flex; gap:12px;">
        <v-text-field
          v-model="searchProject"
          density="compact"
          placeholder="Search project..."
          hide-details
        />

        <button class="btn-primary" @click="openCreate">
          + Create
        </button>

        <button
          class="btn-secondary"
          :disabled="!selectedProject"
          @click="openEdit"
        >
          Edit
        </button>
      </div>
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

    <!-- Project Modal -->
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-card">
        <h3>{{ isEdit ? 'Update Project' : 'Create Project' }}</h3>

        <input v-model="form.title" type="text" placeholder="Project Title" />

        <input
          v-model="form.category_id"
          type="number"
          placeholder="Category ID"
          :readonly="true"
        />

        <select v-model="form.status">
          <option value="pending">Pending</option>
          <option value="ongoing">Ongoing</option>
          <option value="completed">Completed</option>
        </select>

        <div class="modal-actions">
          <button class="btn-secondary" @click="closeModal">Cancel</button>
          <button class="btn-primary" @click="submitForm">
            {{ isEdit ? 'Update' : 'Create' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const projects = ref([])
const searchProject = ref('')
const selectedProject = ref(null)

const showModal = ref(false)
const isEdit = ref(false)
const form = ref({ title: '', category_id: null, status: 'ongoing' })

// Fetch projects
const fetchProjects = async () => {
  try {
    const res = await axios.get('https://52.87.185.116:8000/api/projects')
    projects.value = res.data.data
  } catch (err) {
    console.error(err)
  }
}

const filteredProjects = computed(() =>
  projects.value.filter(p =>
    p.title.toLowerCase().includes(searchProject.value.toLowerCase())
  )
)

const getStatusClass = status => {
  const map = { ongoing: 'in-use', completed: 'completed', pending: 'pending' }
  return map[status] || 'pending'
}

const selectProject = project => {
  selectedProject.value = project
  emit('project-selected', project)
}

const openCreate = () => {
  isEdit.value = false
  form.value = { title: '', category_id: projects.value.length ? projects.value[projects.value.length-1].category.id + 1 : 1, status: 'ongoing' }
  showModal.value = true
}

const openEdit = () => {
  if (!selectedProject.value) return
  isEdit.value = true
  form.value = { ...selectedProject.value, category_id: selectedProject.value.category.id }
  showModal.value = true
}

const closeModal = () => (showModal.value = false)

const submitForm = async () => {
  try {
    if (isEdit.value) {
      await axios.put(`https://52.87.185.116:8000/api/projects/${form.value.id}`, form.value)
    } else {
      await axios.post('https://52.87.185.116:8000/api/projects', form.value)
    }
    closeModal()
    fetchProjects()
  } catch (err) {
    console.error('Failed to save project', err)
  }
}

onMounted(fetchProjects)
</script>
