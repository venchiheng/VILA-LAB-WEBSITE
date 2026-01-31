// src/stores/achievement.js
import { defineStore } from 'pinia'
import { reactive, ref } from 'vue'
import axios from 'axios'

export const useAchievementStore = defineStore('achievement', () => {
  // Reactive state
  const achievements = ref([])
  const formData = reactive({
    title: '',
    description: '',
    thumbnail: null, // file
  })
  const errors = reactive({})
  const loading = reactive({
    submit: false,
    fetch: false,
  })

  // --- Actions ---

  // Set thumbnail file
  function setThumbnail(file) {
    formData.thumbnail = file
    errors.thumbnail = ''
  }

  // Reset form
  function resetForm() {
    formData.title = ''
    formData.description = ''
    formData.thumbnail = null
    Object.keys(errors).forEach(key => delete errors[key])
  }

  // Fetch all achievements
  async function fetchAchievements() {
    loading.fetch = true
    try {
      const res = await axios.get('http://44.223.137.10:8000/api/achievements')
      achievements.value = res.data
      console.log('Fetched achievements:', achievements.value)
    } catch (err) {
      console.error('Failed to fetch achievements:', err)
      errors.general = 'Failed to load achievements'
    } finally {
      loading.fetch = false
    }
  }

  // Create new achievement
  async function createAchievement() {
    loading.submit = true
    Object.keys(errors).forEach(key => delete errors[key])

    try {
      const form = new FormData()
      form.append('title', formData.title)
      form.append('description', formData.description)
      if (formData.thumbnail) form.append('thumbnail', formData.thumbnail)

      const res = await axios.post('http://44.223.137.10:8000/api/achievements', form, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })

      achievements.value.push(res.data)
      resetForm()
      return res.data
    } catch (err) {
      console.error('Failed to create achievement:', err)
      if (err.response?.data?.errors) {
        Object.assign(errors, err.response.data.errors)
      } else {
        errors.general = err.response?.data?.message || 'Failed to create achievement'
      }
      throw err
    } finally {
      loading.submit = false
    }
  }

  // Update achievement
  async function updateAchievement(id, payload) {
    loading.submit = true
    Object.keys(errors).forEach(key => delete errors[key])

    try {
      const form = new FormData()
      form.append('title', payload.title)
      form.append('description', payload.description)
      if (payload.thumbnail) form.append('thumbnail', payload.thumbnail)
      form.append('_method', 'PUT') // Laravel PUT via POST

      const res = await axios.post(`http://44.223.137.10:8000/api/achievements/${id}`, form, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })

      const index = achievements.value.findIndex(a => a.id === id)
      if (index !== -1) achievements.value[index] = res.data
      resetForm()
      return res.data
    } catch (err) {
      console.error('Failed to update achievement:', err)
      if (err.response?.data?.errors) {
        Object.assign(errors, err.response.data.errors)
      } else {
        errors.general = err.response?.data?.message || 'Failed to update achievement'
      }
      throw err
    } finally {
      loading.submit = false
    }
  }

  // Delete achievement
  async function deleteAchievement(id) {
    loading.submit = true
    Object.keys(errors).forEach(key => delete errors[key])

    try {
      await axios.delete(`http://44.223.137.10:8000/api/achievements/${id}`)
      achievements.value = achievements.value.filter(a => a.id !== id)
    } catch (err) {
      console.error('Failed to delete achievement:', err)
      errors.general = err.response?.data?.message || 'Failed to delete achievement'
      throw err
    } finally {
      loading.submit = false
    }
  }

  return {
    achievements,
    formData,
    errors,
    loading,
    setThumbnail,
    resetForm,
    fetchAchievements,
    createAchievement,
    updateAchievement,
    deleteAchievement,
  }
})
