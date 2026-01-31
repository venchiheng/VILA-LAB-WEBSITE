import axios from 'axios'
import { defineStore } from 'pinia'
import { reactive, ref } from 'vue'

export const usePublicationStore = defineStore('publication', () => {
    // Form data
    const formData = reactive({
        project_id: '',
        title: '',
        authors: '',
        published_date: '' || null,
    })

    const publications = ref([])
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
    async function fetchPublications() {
        try {
            const res = await axios.get('http://44.223.137.10:8000/api/publications')
            publications.value = res.data
            console.log('Fetched publications:', publications.value)
        } catch (err) {
            console.error('Failed to fetch publications:', err)
            errors.general = 'Failed to load publications'
        }
    }

    // Create publication
    async function createPublication() {
        loading.submit = true
        Object.keys(errors).forEach(key => delete errors[key])

        try {
            const form = new FormData()
            form.append('project_id', formData.project_id)
            form.append('title', formData.title)
            form.append('authors', formData.authors)
            form.append('published_date', formData.published_date)

            const res = await axios.post(
                'http://44.223.137.10:8000/api/publications',
                form,
                { headers: { 'Content-Type': 'multipart/form-data' } }
            )

            // Add to list
            publications.value.push(res.data)
            resetForm()
            return res.data
        } catch (err) {
            console.error(err)
            errors.general = err.response?.data?.message || 'Failed to create publication'
            throw err
        } finally {
            formData.thumbnail = null
            loading.submit = false
        }
    }

    // // Update publication
    // async function updatePublication(id, payload) {
    //     loading.submit = true
    //     errors.general = null

    //     try {
    //         const form = new FormData()
    //         form.append('title', payload.title)
    //         form.append('authors', payload.authors)
    //         form.append('published_date', payload.published_date)
    //         if (payload.thumbnail) form.append('thumbnail', payload.thumbnail)
    //         form.append('_method', 'PUT') // Laravel PUT via POST

    //         await axios.post(`http://44.223.137.10:8000/api/publications/${id}`, form)
    //         await fetchPublications()
    //     } catch (err) {
    //         console.error(err)
    //         errors.general = err.response?.data?.message || 'Failed to update publication'
    //         throw err
    //     } finally {
    //         loading.submit = false
    //     }
    // }

    // Update publication
    async function updatePublication(id, payload) {
        loading.submit = true
        errors.general = null

        try {
            const form = new FormData()
            form.append('title', payload.title)
            form.append('authors', payload.authors)
            form.append('published_date', payload.published_date) || null
            form.append('_method', 'PUT') // Laravel PUT via POST

            await axios.post(`http://44.223.137.10:8000/api/publications/${id}`, form)
            await fetchPublications()
        } catch (err) {
            console.error(err)
            errors.general = err.response?.data?.message || 'Failed to update publication'
            throw err
        } finally {
            loading.submit = false
        }
    }

    // Delete publication
    async function deletePublication(id) {
        loading.submit = true
        errors.general = null

        try {
            await axios.delete(`http://44.223.137.10:8000/api/publications/${id}`)
            publications.value = publications.value.filter(p => p.id !== id)
        } catch (err) {
            console.error(err)
            errors.general = err.response?.data?.message || 'Failed to delete publication'
            throw err
        } finally {
            loading.submit = false
        }
    }

    return {
        formData,
        publications,
        errors,
        loading,
        setThumbnail,
        resetForm,
        fetchPublications,
        createPublication,
        updatePublication,
        deletePublication,
    }
})
