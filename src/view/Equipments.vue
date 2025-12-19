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
    <EquipmentDetail
    :equipment="equipment"
    :source="images"
    color="green"
  />
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


//////////////////////
import { ref } from 'vue'
import EquipmentDetail from '../components/equipment/equipment-detail.vue';

const equipment = ref({
  name: 'Raspberry Pi 5',
  thumbnail: 'src/assets/equipment/rsbrpi.png',
  status: 'Available',
  condition: 'New',
  description: 'Professional mirrorless camera',
  htmlContent: `<p>The Raspberry Pi 5 is the latest iteration of the popular single-board computer, offering enhanced performance and features for a wide range of applications. It is equipped with a powerful quad-core ARM Cortex-A76 CPU, up to 8GB of LPDDR4X RAM, and supports dual 4K display output, making it ideal for multimedia projects, gaming, and general computing tasks.</p>`
})

const images = ref([
  'src/assets/equipment/rsbrpi.png',
  'src/assets/equipment/rsbrpi.png',
  'src/assets/equipment/rsbrpi.png'
])
</script>

<style scoped>
.equipment-grid {
  padding: 100px 80px 156px 80px;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  display: flex;
  flex-wrap: wrap;
  gap: 50px 25px; 
  justify-content: center;
}
</style>
