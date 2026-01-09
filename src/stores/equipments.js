import { defineStore } from 'pinia' 

export const useEquipmentStore = defineStore('equipment', {
  state: () => ({
    equipments: [
      {
        id: 1,
        name: 'Raspberry Pi 5',
        spec: '16GB RAM, M.2 SSD',
        image: '/src/assets/equipment/pi5.png',
        status: 'Available'
      },
      {
        id: 2,
        name: 'Raspberry Pi Compute Model 5',
        spec: '16GB RAM, M.2 SSD',
        image: '/src/assets/equipment/compute5.png',
        status: 'Booked'
      },
      {
        id: 3,
        name: 'Raspberry Pi Compute Model 5',
        spec: '16GB RAM, M.2 SSD',
        image: '/src/assets/equipment/module5.png',
        status: 'Available'
      },
      {
        id: 4,
        name: 'Raspberry Pi 5',
        spec: '16GB RAM, M.2 SSD',
        image: '/src/assets/equipment/pi5.png',
        status: 'Available'
      },
      {
        id: 5,
        name: 'Raspberry Pi 5',
        spec: '16GB RAM, M.2 SSD',
        image: '/src/assets/equipment/module5.png',
        status: 'Available'
      },
      {
        id: 6,
        name: 'Raspberry Pi 5',
        spec: '16GB RAM, M.2 SSD',
        image: '/src/assets/equipment/compute5.png',
        status: 'Booked'
      }
    ]
  }),

  getters: {
    getById: (state) => (id) =>
      state.equipments.find(e => e.id === Number(id))
  }
})