<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <Sidebar :activeTab="'Contact Messages'" @tab-change="handleTabChange" />
    <main class="main-content">
      <TopNav :user="user" @toggle-theme="toggleTheme" />

      <div class="dashboard-content">
        <div class="table-container">
          <div class="table-header">
            <h2 class="text-h5 font-weight-bold mb-4">Achievements</h2>
            <div class="filters">
              <v-text-field
                v-model="searchName"
                density="compact"
                placeholder="Search by name..."
                hide-details
              />
              <button style="color:white; background-color: var(--color-primary);" @click="openCreate">Create</button>
            </div>
          </div>

          <!-- Partnership Table -->
          <table class="booking-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Thumbnail</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="p in paginatedItems" :key="p.id">
                <tr style="vertical-align: middle;">
                  <td>{{ p.name }}</td>
                  <td>
                    <img :src="getThumbnailUrl(p)" alt="Thumbnail" class="thumbnail" />
                  </td>
                  <td>{{ p.created_at }}</td>
                  <td>
                    <button class="btn-update" @click="openUpdate(p)">Update</button>
                    <button class="btn-delete" @click="deletePartnership(p.id)">Delete</button>
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

    <!-- Create / Update Dialog -->
    <v-dialog v-model="dialog" max-width="600">
    <v-card class="pa-4">
        <!-- Title -->
        <v-card-title class="text-h6 d-flex align-center justify-center font-weight-black py-3">
        {{ isUpdate ? 'Update Achievement' : 'Create Achievement' }}
        </v-card-title>

        <!-- Content -->
        <v-card-text class="d-flex flex-column px-6 py-3">
        <p>Achievement Title</p>
        <v-text-field
            v-model="formData.title"
            :error="!!errors.title"
            :error-messages="errors.title"
            class="w-100 text-body-2"
            variant="underlined"
        />
        <p>Achievement Description</p>
        <v-text-field
            v-model="formData.description"
            :error="!!errors.description"
            :error-messages="errors.description"
            class="w-100 text-body-2"
            variant="underlined"
        />
        <p class="mt-4">Logo (PNG or JPG)</p>
        <v-file-input
            accept="image/png, image/jpg"
            @change="handleFile"
            :error="!!errors.thumbnail"
            :error-messages="errors.thumbnail"
            class="w-100 mt-3"
        />

        <div v-if="preview" class="preview mt-3">
            <img
            :src="preview"
            alt="Preview"
            style="max-width: 200px; border-radius: 8px;"
            />
        </div>

        <div v-if="errors.general" class="text-red-500 mt-3 text-center">
            {{ errors.general }}
        </div>
        </v-card-text>

        <!-- Actions -->
        <v-card-actions class="justify-center px-6 py-3 gap-3">
        <v-btn style="color:white; background-color: var(--color-error);" text @click="closeDialog">Cancel</v-btn>
        <v-btn
            color="primary"
            :loading="loading.submit"
            @click="isUpdate ? submitUpdate() : submitCreate()"
        >
            {{ isUpdate ? 'Update' : 'Create' }}
        </v-btn>
        </v-card-actions>
    </v-card>
    </v-dialog>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Sidebar from '@/components/admin/sidebar.vue'
import TopNav from '@/components/admin/topnav.vue'
import { storeToRefs } from 'pinia'
import { useAchievementStore } from '../../stores/achievement'

// Theme & user
const darkMode = ref(false)
const toggleTheme = () => (darkMode.value = !darkMode.value)

const user = ref({
  name: 'Admin User',
  email: 'admin@vilalab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

// Pinia store
const achievementStore = useAchievementStore()
const { achievements, errors, loading } = storeToRefs(achievementStore)
const formData = achievementStore.formData

// Modal / preview
const dialog = ref(false)
const isUpdate = ref(false)
const updatingId = ref(null)
const preview = ref(null)

// Open create modal
const openCreate = () => {
  achievementStore.resetForm()
  preview.value = null
  isUpdate.value = false
  dialog.value = true
}

// Open update modal
const openUpdate = (p) => {
  achievementStore.resetForm()
  formData.title = p.title
  preview.value = `http://44.223.137.10:8000/storage/${p.thumbnail}`
  updatingId.value = p.id
  isUpdate.value = true
  dialog.value = true
}

// Close modal
const closeDialog = () => {
  dialog.value = false
  preview.value = null
  updatingId.value = null
  isUpdate.value = false
}

// File handler
const handleFile = (e) => {
  const file = e.target.files[0]
  if (!file) return
  if (!['image/png', 'image/jpeg', 'image/jpg'].includes(file.type)) {
    errors.thumbnail = 'Thumbnail must be a PNG or JPEG image'
    return
  }
  achievementStore.setThumbnail(file)
  preview.value = URL.createObjectURL(file)
}

// Submit create
const submitCreate = async () => {
  try {
    await achievementStore.createAchievement()
    alert('Achievement created successfully!')
    dialog.value = false
    preview.value = null
  } catch (err) {
    console.error(err)
  }
}

// Submit update
const submitUpdate = async () => {
  try {
    await achievementStore.updateAchievement(updatingId.value, formData)
    alert('Achievement updated successfully!')
    dialog.value = false
    preview.value = null
    updatingId.value = null
  } catch (err) {
    console.error(err)
  }
}

const deleteAchievement = async (id) => {
  if (!confirm('Are you sure you want to delete this achievement?')) return
  try {
    await achievementStore.deleteAchievement(id)
    alert('Achievement deleted successfully!')
  } catch (err) {
    console.error(err)
  }
}

// Thumbnail helper
const getThumbnailUrl = (p) => {
  if (!p.thumbnail) return ''
  return typeof p.thumbnail === 'string'
    ? `http://44.223.137.10:8000/storage/${p.thumbnail}`
    : URL.createObjectURL(p.thumbnail)
}

// Pagination
const searchName = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

const filteredItems = computed(() =>
  achievements.value.filter((p) =>
    !searchName.value || p.title.toLowerCase().includes(searchName.value.toLowerCase())
  )
)

const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage.value))

const paginatedItems = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredItems.value.slice(start, end)
})

const nextPage = () => { if (page.value < totalPages.value) page.value++ }
const prevPage = () => { if (page.value > 1) page.value-- }

const handleTabChange = (tab) => console.log('Tab changed to:', tab)

// Fetch achievements
onMounted(async () => {
  await achievementStore.fetchAchievements()
})</script>

<style scoped>
.app-container {
    display: flex;
    min-height: 100vh;
    background-color: #f8fafc;
    transition: 0.3s;
}

.app-container.dark-mode {
    background-color: #1a1a1a;
    color: #e5e7eb;
}

.main-content {
    flex: 1;
    margin-left: 250px;
    overflow-x: hidden;
    overflow-y: auto;
    min-height: 100vh;
}

.dashboard-content {
    padding: 2rem;
}

.table-container {
    background: white;
    border-radius: 0.75rem;
    overflow: hidden;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.booking-table {
    width: 100%;
    border-collapse: collapse;
}
.booking-table td,
.booking-table th {
  vertical-align: middle;
  text-align: center;
  padding: 1rem 5px;
}

.booking-table th {
    padding: 1rem 5px;
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
}

.booking-table td {
    padding: 1rem 5px;
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
}

.booking-table tbody tr:hover {
    background: #f9fafb;
}

.detail-card {
    background: #f3f4f6;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-top: 0.5rem;
}

.detail-row {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.label {
    font-weight: 500;
    min-width: 120px;
    color: #6b7280;
}

.value {
    color: #111827;
}

.filters {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.pagination {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 1rem;
    margin-top: 1rem;
}

.pagination button {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    color: white;
}

.btn-prev {
    background-color: #ef4444;
}

.btn-prev:disabled {
    background-color: #fca5a5;
    cursor: not-allowed;
}
.btn-update {
  color: white;
    background-color: var(--color-warning);
}

.btn-delete {
  color: white;
    background-color: var(--color-error);
    margin-left: 8px;
}

.btn-next {
    background-color: #22c55e;
}

.btn-next:disabled {
    background-color: #86efac;
    cursor: not-allowed;
}

.thumbnail {
    max-width: 80px;
    border-radius: 6px;
}
</style>
