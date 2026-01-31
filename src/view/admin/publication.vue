<template>
  <div class="app-container" :class="{ 'dark-mode': darkMode }">
    <Sidebar :activeTab="'Contact Messages'" @tab-change="handleTabChange" />
    <main class="main-content">
      <TopNav :user="user" @toggle-theme="toggleTheme" />

      <div class="dashboard-content">
        <div class="table-container">
          <div class="table-header">
            <h2 class="text-h5 font-weight-bold mb-4">Publications</h2>
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

          <!-- Publication Table -->   
          <table class="booking-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Authors</th>
                <th>Published Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="p in paginatedItems" :key="p.id">
                <tr style="vertical-align: middle;">
                  <td>{{ p.title }}</td>
                  <td>{{ p.authors }}</td>
                  <td>{{ p.published_date }}</td>
                  <td>
                    <button class="btn-update" @click="openUpdate(p)">Update</button>
                    <button class="btn-delete" @click="deletePublication(p.id)">Delete</button>
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
        {{ isUpdate ? 'Update Publication' : 'Create Publication' }}
        </v-card-title>

        <!-- Content -->
        <v-card-text class="d-flex flex-column px-6 py-3">
        <p>Publication Title</p>
        <v-text-field
            v-model="formData.title"
            :error="!!errors.title"
            :error-messages="errors.title"
            class="w-100 text-body-2"
            variant="underlined"
        />
        <p class="mt-4">Authors</p>
        <v-text-field
            v-model="formData.authors"
            :error="!!errors.authors"
            :error-messages="errors.authors"
            class="w-100 mt-3"
        />

        <p class="mt-4">Project ID</p>
        <v-text-field
            v-model="formData.project_id"
            :error="!!errors.project_id"
            :error-messages="errors.project_id"
            class="w-100 mt-3"
        />

        <div v-if="errors.general" class="text-red-500 mt-3 text-center">
            {{ errors.general }}
        </div>
        </v-card-text>

        <!-- Actions -->
        <v-card-actions class="justify-center px-6 py-3 gap-3">
        <v-btn style="background-color: var(--color-error);" text @click="closeDialog">Cancel</v-btn>
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
import { usePublicationStore } from '../../stores/publication'
import { storeToRefs } from 'pinia'

// Theme & user
const darkMode = ref(false)
const toggleTheme = () => (darkMode.value = !darkMode.value)

const user = ref({
  name: 'Admin User',
  email: 'admin@vilalab.com',
  avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff'
})

// Pinia store
const publicationStore = usePublicationStore()
const { publications, errors, loading } = storeToRefs(publicationStore)
const formData = publicationStore.formData

// Modal / preview
const dialog = ref(false)
const isUpdate = ref(false)
const updatingId = ref(null)
const preview = ref(null)

// Open create modal
const openCreate = () => {
  publicationStore.resetForm()
  preview.value = null
  isUpdate.value = false
  dialog.value = true
}

// Open update modal
const openUpdate = (p) => {
  publicationStore.resetForm()
  formData.title = p.title
  formData.authors = p.authors
  formData.published_date = p.published_date || null
  preview.value = `https://52.87.185.116:8000/storage/${p.thumbnail}`
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

// Submit create
const submitCreate = async () => {
  try {
    await publicationStore.createPublication()
    alert('Publication created successfully!')
    dialog.value = false
    preview.value = null
  } catch (err) {
    console.error(err)
  }
}

// Submit update
const submitUpdate = async () => {
  try {
    await publicationStore.updatePublication(updatingId.value, formData)
    alert('Publication updated successfully!')
    dialog.value = false
    preview.value = null
    updatingId.value = null
  } catch (err) {
    console.error(err)
  }
}

const deletePublication = async (id) => {
  if (!confirm('Are you sure you want to delete this publication?')) return
  try {
    await publicationStore.deletePublication(id)
    alert('Publication deleted successfully!')
  } catch (err) {
    console.error(err)
  }
}

// Pagination
const searchName = ref('')
const page = ref(1)
const itemsPerPage = ref(5)

const filteredItems = computed(() =>
  publications.value.filter((p) =>
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

// Fetch publications
onMounted(() => publicationStore.fetchPublications())
</script>

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

.btn-delete{
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
/