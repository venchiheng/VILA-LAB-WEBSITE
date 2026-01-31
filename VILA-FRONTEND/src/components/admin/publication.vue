<template>
  <div class="publications-section">
    <h2>Publications</h2>

    <div class="controls">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search by title or year..."
        class="search-input"
      />
      <button class="btn-add" @click="openAddModal">
        + Add New
      </button>
    </div>

    <table class="publications-table">
      <thead>
        <tr>
          <th>TITLE</th>
          <th>AUTHORS</th>
          <th>JOURNAL/CONFERENCE</th>
          <th>YEAR</th>
          <th>ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in filteredPublications" :key="item.id || item.tempId">
          <td>{{ item.title }}</td>
          <td>{{ item.authors }}</td>
          <td>{{ item.venue }}</td>
          <td>{{ item.year }}</td>
          <td class="actions">
            <button class="btn-icon edit" @click="openEditModal(item)">
              ✏️
            </button>
            <button class="btn-icon delete" @click="confirmDelete(item)">
              🗑️
            </button>
          </td>
        </tr>
        <tr v-if="!filteredPublications.length">
          <td colspan="5" class="no-data">
            {{ searchQuery ? 'No publications found matching your search' : 'No publications found' }}
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <teleport to="body">
      <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
          <div class="modal-header">
            <h3>{{ isEditMode ? 'Edit Publication' : 'Add Publication' }}</h3>
            <button class="modal-close" @click="closeModal">×</button>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label>Title <span class="required">*</span></label>
              <input v-model="form.title" type="text" required />
            </div>

            <div class="form-group">
              <label>Authors <span class="required">*</span></label>
              <input v-model="form.authors" type="text" required placeholder="e.g., Smith J., Doe A., Johnson B." />
            </div>

            <div class="form-group">
              <label>Journal/Conference <span class="required">*</span></label>
              <input v-model="form.venue" type="text" required />
            </div>

            <div class="form-group">
              <label>Year <span class="required">*</span></label>
              <input
                v-model="form.year"
                type="number"
                min="1900"
                max="2100"
                required
              />
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn-cancel" @click="closeModal">Cancel</button>
            <button class="btn-save" @click="savePublication" :disabled="saving">
              {{ saving ? 'Saving...' : 'Save' }}
            </button>
          </div>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
// import axios from 'axios'   // uncomment when connecting to Laravel

const searchQuery = ref('')
const publications = ref([])
const showModal = ref(false)
const isEditMode = ref(false)
const saving = ref(false)
const editingItem = ref(null)

const form = ref({
  title: '',
  authors: '',
  venue: '',
  year: new Date().getFullYear(),
})

// Computed filtered list - filters by TITLE and YEAR
const filteredPublications = computed(() => {
  if (!searchQuery.value.trim()) return publications.value

  const q = searchQuery.value.toLowerCase().trim()
  return publications.value.filter(item => {
    // Check title match
    const titleMatch = item.title && item.title.toLowerCase().includes(q)
    
    // Check year match - convert both to string for comparison
    const yearMatch = item.year && String(item.year).includes(q)
    
    return titleMatch || yearMatch
  })
})

onMounted(async () => {
  // For development / demo — replace with real API call
  publications.value = [
    {
      id: 1,
      title: 'Deep Learning for Medical Image Analysis',
      authors: 'Smith J., Doe A., Johnson B.',
      venue: 'Nature Medicine',
      year: 2023,
      doi: 'https://doi.org/10.1038/nm.2023.001'
    },
    {
      id: 2,
      title: 'Advances in Neural Network Architectures',
      authors: 'Williams C., Brown D.',
      venue: 'NeurIPS 2022',
      year: 2022,
      doi: 'https://doi.org/10.5555/neurips.2022.002'
    },
    {
      id: 3,
      title: 'Reinforcement Learning in Robotics',
      authors: 'Davis E., Miller F., Wilson G.',
      venue: 'IEEE Transactions on Robotics',
      year: 2021,
      doi: 'https://doi.org/10.1109/TRO.2021.003'
    },
    {
      id: 4,
      title: 'Natural Language Processing: A Survey',
      authors: 'Anderson H., Taylor I.',
      venue: 'ACL 2020',
      year: 2020,
      doi: 'https://doi.org/10.18653/v1/2020.acl-main.004'
    },
  ]

  // Real API version (uncomment when ready):
  // const res = await axios.get('/api/admin/publications')
  // publications.value = res.data
})

function openAddModal() {
  isEditMode.value = false
  editingItem.value = null
  form.value = {
    title: '',
    authors: '',
    venue: '',
    year: new Date().getFullYear(),
  }
  showModal.value = true
}

function openEditModal(item) {
  isEditMode.value = true
  editingItem.value = item
  form.value = { ...item }
  showModal.value = true
}

function closeModal() {
  showModal.value = false
}

async function savePublication() {
  if (!form.value.title || !form.value.authors || !form.value.venue || !form.value.year) {
    alert('Please fill in all required fields')
    return
  }

  saving.value = true

  try {
    if (isEditMode.value) {
      // Update existing
      const index = publications.value.findIndex(i => i.id === editingItem.value.id)
      if (index !== -1) {
        publications.value[index] = { ...form.value }
      }

      // API version:
      // await axios.put(`/api/admin/publications/${form.value.id}`, form.value)
    } else {
      // Create new (demo version with temp id)
      const newItem = {
        ...form.value,
        id: 'temp-' + Date.now(), // replace with real id from backend
      }
      publications.value.unshift(newItem)

      // API version:
      // const res = await axios.post('/api/admin/publications', form.value)
      // publications.value.unshift(res.data)
    }

    closeModal()
  } catch (err) {
    console.error(err)
    alert('Failed to save publication')
  } finally {
    saving.value = false
  }
}

function confirmDelete(item) {
  if (!confirm(`Delete "${item.title}"?`)) return

  const index = publications.value.indexOf(item)
  if (index !== -1) {
    publications.value.splice(index, 1)
  }

  // API version:
  // await axios.delete(`/api/admin/publications/${item.id}`)
}
</script>

<style scoped>
.publications-section {
  padding: 24px;
}

h2 {
  margin: 0 0 20px;
  font-size: 1.8rem;
  color: #1a1a1a;
}

.controls {
  display: flex;
  gap: 12px;
  margin-bottom: 20px;
}

.search-input {
  flex: 1;
  padding: 10px 14px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 1rem;
}

.search-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-add {
  background: #3b82f6;
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
}

.btn-add:hover {
  background: #2563eb;
}

.publications-table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.publications-table th,
.publications-table td {
  padding: 14px 16px;
  text-align: left;
  border-bottom: 1px solid #e5e7eb;
}

.publications-table th {
  background: #f8fafc;
  font-weight: 600;
  color: #4b5563;
  text-transform: uppercase;
  font-size: 0.85rem;
}

.actions {
  white-space: nowrap;
}

.btn-icon {
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  padding: 4px 8px;
  border-radius: 4px;
}

.btn-icon.edit {
  color: #3b82f6;
}

.btn-icon.edit:hover {
  background: #eff6ff;
}

.btn-icon.delete {
  color: #ef4444;
}

.btn-icon.delete:hover {
  background: #fee2e2;
}

.no-data {
  text-align: center;
  color: #9ca3af;
  padding: 40px !important;
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 12px;
  width: 100%;
  max-width: 560px;
  margin: 20px;
  box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid #e5e7eb;
}

.modal-header h3 {
  margin: 0;
  font-size: 1.4rem;
}

.modal-close {
  background: none;
  border: none;
  font-size: 1.8rem;
  cursor: pointer;
  color: #6b7280;
}

.modal-body {
  padding: 24px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 6px;
  font-weight: 500;
  color: #374151;
}

.form-group input {
  width: 100%;
  padding: 10px 14px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 1rem;
}

.required {
  color: #ef4444;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 20px 24px;
  border-top: 1px solid #e5e7eb;
}

.btn-cancel,
.btn-save {
  padding: 10px 20px;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
}

.btn-cancel {
  background: #f3f4f6;
  border: none;
  color: #374151;
}

.btn-save {
  background: #3b82f6;
  color: white;
  border: none;
}

.btn-save:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>