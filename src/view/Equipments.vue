<template>
  <EquipmentDetail
    :equipment="equipment"
    :source="images"
    color="green"
  />
</template>

<script setup>
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
