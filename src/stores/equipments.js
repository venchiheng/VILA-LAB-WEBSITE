import { defineStore } from 'pinia'

export const useEquipmentStore = defineStore('equipment', {
  state: () => ({
    equipments: [
      {
        id: 1,
        name: 'Raspberry Pi 5',
        thumbnail: new URL('@/assets/equipment/rsbrpi.png', import.meta.url).href,
        status: 'Available',
        condition: 'New',
        description: 'Single-board computer for embedded projects',
        images: [
          new URL('@/assets/equipment/rsbrpi.png', import.meta.url).href,
          new URL('@/assets/equipment/rsbrpi.png', import.meta.url).href
        ]
      }
    ]
  }),

  getters: {
    getById: (state) => (id) =>
      state.equipments.find(e => e.id === Number(id))
  }
})
