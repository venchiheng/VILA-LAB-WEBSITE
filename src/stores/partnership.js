import axios from 'axios'
import { defineStore } from 'pinia'
import { reactive, ref } from 'vue'

export const usePartnershipStore = defineStore('partnership', () => {
    // Form data
    const formData = reactive({
        name: '',
        thumbnail: null,
    })

    const partnerships = ref([])
    const errors = reactive({})
    const loading = reactive({ submit: false })

    // Set thumbnail file
    function setThumbnail(file) {
        formData.thumbnail = file
        errors.thumbnail = ''
    }

    // Reset form
    function resetForm() {
        formData.name = ''
        formData.thumbnail = null
        Object.keys(errors).forEach(key => delete errors[key])
    }

    // Fetch all partnerships
    async function fetchPartnerships() {
        try {
            const res = await axios.get('https://52.87.185.116:8000/api/partnerships')
            partnerships.value = res.data
            console.log('Fetched partnerships:', partnerships.value)
        } catch (err) {
            console.error('Failed to fetch partnerships:', err)
            errors.general = 'Failed to load partnerships'
        }
    }

    // Create partnership
    async function createPartnership() {
        loading.submit = true
        Object.keys(errors).forEach(key => delete errors[key])

        try {
            const form = new FormData()
            form.append('name', formData.name)
            if (formData.thumbnail) {
                form.append('thumbnail', formData.thumbnail)
            }

            const res = await axios.post(
                'https://52.87.185.116:8000/api/partnerships',
                form,
                { headers: { 'Content-Type': 'multipart/form-data' } }
            )

            // Add to list
            partnerships.value.push(res.data)
            resetForm()
            return res.data
        } catch (err) {
            console.error(err)
            errors.general = err.response?.data?.message || 'Failed to create partnership'
            throw err
        } finally {
            loading.submit = false
        }
    }

    // Update partnership
    async function updatePartnership(id, payload) {
        loading.submit = true
        errors.general = null

        try {
            const form = new FormData()
            form.append('name', payload.name)
            if (payload.thumbnail) form.append('thumbnail', payload.thumbnail)
            form.append('_method', 'PUT') // Laravel PUT via POST

            await axios.post(`https://52.87.185.116:8000/api/partnerships/${id}`, form)
            await fetchPartnerships()
        } catch (err) {
            console.error(err)
            errors.general = err.response?.data?.message || 'Failed to update partnership'
            throw err
        } finally {
            loading.submit = false
        }
    }

    // Delete partnership
    async function deletePartnership(id) {
        loading.submit = true
        errors.general = null

        try {
            await axios.delete(`https://52.87.185.116:8000/api/partnerships/${id}`)
            partnerships.value = partnerships.value.filter(p => p.id !== id)
        } catch (err) {
            console.error(err)
            errors.general = err.response?.data?.message || 'Failed to delete partnership'
            throw err
        } finally {
            loading.submit = false
        }
    }

    return {
        formData,
        partnerships,
        errors,
        loading,
        setThumbnail,
        resetForm,
        fetchPartnerships,
        createPartnership,
        updatePartnership,
        deletePartnership,
    }
})
