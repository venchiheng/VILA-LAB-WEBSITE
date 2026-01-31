<template>
  <div class="achievements-section">
    <h2>Achievements</h2>

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

    <table class="achievements-table">
      <thead>
        <tr>
          <th>ICON</th>
          <th>TITLE</th>
          <th>ORGANIZATION</th>
          <th>YEAR</th>
          <th>ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in filteredAchievements" :key="item.id || item.tempId">
          <td class="icon-cell">
            <span class="achievement-icon">{{ item.icon }}</span>
          </td>
          <td>{{ item.title }}</td>
          <td>{{ item.organization }}</td>
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
        <tr v-if="!filteredAchievements.length">
          <td colspan="5" class="no-data">
            {{ searchQuery ? 'No achievements found matching your search' : 'No achievements found' }}
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <teleport to="body">
      <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
          <div class="modal-header">
            <h3>{{ isEditMode ? 'Edit Award' : 'Add Award' }}</h3>
            <button class="modal-close" @click="closeModal">×</button>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label>Icon</label>
              <div class="icon-selector">
                <span
                  v-for="emoji in availableIcons"
                  :key="emoji"
                  :class="{ selected: form.icon === emoji }"
                  class="icon-option"
                  @click="form.icon = emoji"
                >
                  {{ emoji }}
                </span>
              </div>
            </div>

            <div class="form-group">
              <label>Award Title <span class="required">*</span></label>
              <input v-model="form.title" type="text" required />
            </div>

            <div class="form-group">
              <label>Organization <span class="required">*</span></label>
              <input v-model="form.organization" type="text" required />
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
            <button class="btn-save" @click="saveAchievement" :disabled="saving">
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
const achievements = ref([])
const showModal = ref(false)
const isEditMode = ref(false)
const saving = ref(false)
const editingItem = ref(null)

const form = ref({
  icon: '🏆',
  title: '',
  organization: '',
  year: new Date().getFullYear(),
})

const availableIcons = ref([
  '🏆', '💡', '🎓', '🏅', '⭐', '👨‍🔬', '📜', '🔬', '🌟', '🥇'
])

// Computed filtered list - filters by TITLE and YEAR
const filteredAchievements = computed(() => {
  if (!searchQuery.value.trim()) return achievements.value

  const q = searchQuery.value.toLowerCase().trim()
  return achievements.value.filter(item => {
    // Check title match
    const titleMatch = item.title && item.title.toLowerCase().includes(q)
    
    // Check year match - convert both to string for comparison
    const yearMatch = item.year && String(item.year).includes(q)
    
    return titleMatch || yearMatch
  })
})

onMounted(async () => {
  // For development / demo — replace with real API call
  achievements.value = [
    { id: 1, icon: '🏆', title: 'Best Paper Award', organization: 'NeurIPS 2023', year: 2023 },
    { id: 2, icon: '💡', title: 'Innovation in AI Grant', organization: 'National Science Foundation', year: 2022 },
    { id: 3, icon: '🎓', title: 'Outstanding Dissertation Award', organization: 'ACM', year: 2021 },
    { id: 4, icon: '🏅', title: 'Early Career Researcher Prize', organization: 'IEEE Computer Society', year: 2020 },
  ]

  // Real API version (uncomment when ready):
  // const res = await axios.get('/api/admin/achievements')
  // achievements.value = res.data
})

function openAddModal() {
  isEditMode.value = false
  editingItem.value = null
  form.value = {
    icon: '🏆',
    title: '',
    organization: '',
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

async function saveAchievement() {
  if (!form.value.title || !form.value.organization || !form.value.year) {
    alert('Please fill in all required fields')
    return
  }

  saving.value = true

  try {
    if (isEditMode.value) {
      // Update existing
      const index = achievements.value.findIndex(i => i.id === editingItem.value.id)
      if (index !== -1) {
        achievements.value[index] = { ...form.value }
      }

      // API version:
      // await axios.put(`/api/admin/achievements/${form.value.id}`, form.value)
    } else {
      // Create new (demo version with temp id)
      const newItem = {
        ...form.value,
        id: 'temp-' + Date.now(), // replace with real id from backend
      }
      achievements.value.unshift(newItem)

      // API version:
      // const res = await axios.post('/api/admin/achievements', form.value)
      // achievements.value.unshift(res.data)
    }

    closeModal()
  } catch (err) {
    console.error(err)
    alert('Failed to save achievement')
  } finally {
    saving.value = false
  }
}

function confirmDelete(item) {
  if (!confirm(`Delete "${item.title}"?`)) return

  const index = achievements.value.indexOf(item)
  if (index !== -1) {
    achievements.value.splice(index, 1)
  }

  // API version:
  // await axios.delete(`/api/admin/achievements/${item.id}`)
}
</script>

<style scoped>
.achievements-section {
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

.achievements-table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.achievements-table th,
.achievements-table td {
  padding: 14px 16px;
  text-align: left;
  border-bottom: 1px solid #e5e7eb;
}

.achievements-table th {
  background: #f8fafc;
  font-weight: 600;
  color: #4b5563;
  text-transform: uppercase;
  font-size: 0.85rem;
}

.icon-cell {
  width: 60px;
}

.achievement-icon {
  font-size: 1.8rem;
  line-height: 1;
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
  max-width: 480px;
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

.icon-selector {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 8px;
}

.icon-option {
  font-size: 2.2rem;
  cursor: pointer;
  padding: 8px;
  border-radius: 8px;
  border: 2px solid transparent;
  transition: all 0.15s;
}

.icon-option:hover,
.icon-option.selected {
  background: #eff6ff;
  border-color: #3b82f6;
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