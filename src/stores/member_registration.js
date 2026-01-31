import { defineStore } from 'pinia'
import { reactive } from 'vue'
import axios from 'axios'

export const useMembershipStore = defineStore('membership', () => {
  const formData = reactive({
    name: '',
    gender: '',
    email: '',
    phone: '',
    studentId: '',
    faculty: '',
    year: '',
    cv: null,
    motivation: '',
    timeManagement: '',
    availability: ''
  })

  const errors = reactive({})
  const loading = reactive({ submit: false })

  function setFile(file) {
    formData.cv = file
    errors.cv = ''
  }

  function resetForm() {
    Object.keys(formData).forEach(key => {
      if (key === 'cv') formData[key] = null
      else formData[key] = ''
    })
    Object.keys(errors).forEach(key => delete errors[key])
  }

  async function submitForm() {
    loading.submit = true
    Object.keys(errors).forEach(key => delete errors[key])

    const form = new FormData()
    form.append('full_name', formData.name)
    form.append('gender', formData.gender)
    form.append('email', formData.email)
    form.append('phone_number', formData.phone)
    form.append('stu_id', formData.studentId)
    form.append('faculty', formData.faculty)
    form.append('year', formData.year)
    form.append('motivation', formData.motivation)
    form.append('time_management', formData.timeManagement)
    form.append('availability', formData.availability)
    if (formData.cv) form.append('cv_path', formData.cv)

    try {
      const res = await axios.post(
        'https://52.87.185.116:8000/api/membership-applications',
        form,
        { headers: { 'Content-Type': 'multipart/form-data' } }
      )
      resetForm()
      return res.data
    } catch (err) {
      if (err.response?.data?.errors) {
        Object.assign(errors, err.response.data.errors)
      } else if (err.response?.data?.message) {
        errors.general = err.response.data.message
      }
      throw err
    } finally {
      loading.submit = false
    }
  }

  return { formData, errors, loading, setFile, submitForm, resetForm }
})
