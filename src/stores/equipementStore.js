import { defineStore } from 'pinia'
import { getEquipmentListApi } from '@/services/equipementservice'

export const useEquipmentStore = defineStore('equipment', {
  state: () => ({
    equipmentList: [],
    loading: false,
    error: null,
  }),

  getters: {
    availableEquipment: (state) =>
      state.equipmentList.filter(item => item.availability === 'available'),

    bookedEquipment: (state) =>
      state.equipmentList.filter(item => item.availability === 'booked'),

    getEquipmentById: (state) => {
      return (id) => state.equipmentList.find(item => item.id === id)
    },
  },

  actions: {
    async fetchEquipment() {
      this.loading = true
      this.error = null

      try {
        const response = await getEquipmentListApi()
        this.equipmentList = response.data
      } catch (err) {
        this.error = err
        console.error('Error fetching equipment:', err)
      } finally {
        this.loading = false
      }
    },

    clearEquipment() {
      this.equipmentList = []
    },
  },
})
