<template>
  <div class="equipment-grid">
    <EquipmentCard
      v-for="item in equipments"
      :key="item.id"
      :name="item.name"
      :specification="item.spec"
      :image="item.image"
      :status="item.status"
      @view-detail="openDetail(item.id)"
    />
  </div>
</template>

<script setup>
import EquipmentCard from '@/components/equipment/EquipmentCard.vue'

const equipments = [
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
  },
]

const openDetail = (id) => {
  console.log('View equipment detail:', id)
  // router.push(`/equipment/${id}`)
}
</script>

<style scoped>
.equipment-grid {
  padding: 100px 80px 156px 80px;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  display: flex;
  flex-wrap: wrap;
  gap: 50px 25px; /* row-gap column-gap */
  justify-content: center;
}
</style>
