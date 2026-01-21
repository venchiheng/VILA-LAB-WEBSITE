import { defineStore } from 'pinia'
import api from '../services/api'

export const useEquipmentStore = defineStore('equipment', {
  state: () => ({
    equipments: [],
    loading: false,
    error: null
  }),

  getters: {
    getById: (state) => (id) =>
      state.equipments.find(e => e.id === Number(id))
  },

  actions: {
    async fetchEquipments() {
      this.loading = true
      this.error = null
      try {
        const response = await api.get('/equipment') // your backend route
        // map the response if needed
        this.equipments = response.data.data.map(e => ({
          id: e.id,
          name: e.name,
          spec: e.spec || e.description || '',
          image: e.image || '/src/assets/equipment/default.png', // fallback
          status: e.availability === 'available' ? 'Available' : 'Booked'
        }))
      } catch (err) {
        this.error = err
        console.error('Failed to fetch equipments:', err)
      } finally {
        this.loading = false
      }
    }
  }
})
