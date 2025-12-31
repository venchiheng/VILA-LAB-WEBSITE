<template>
  <div v-if="currentView === 'list'" class="equipment-header">
    <div class="header-left">
      <h1>Equipment Booking</h1>
      <p>Lab Resource management</p>

      <div class="search-box">
        <input type="text" placeholder="Search equipment..." />
      </div>
    </div>

    <button class="my-booking-btn" @click="goToBooking">
      <img src="/src/assets/icons/folder.png" alt="folder" />
      <span>My Booking</span>
    </button>
  </div>

  <div v-if="currentView === 'list'" class="page-wrapper">
    <div class="equipment-grid">
      <EquipmentCard
        v-for="item in equipments"
        :key="item.id"
        :name="item.name"
        :specification="item.spec"
        :image="item.image"
        :status="item.status"
        @view-detail="openDetail(item)"
      />
    </div>
  </div>

  <MyBooking v-if="currentView === 'booking'" />

  <EquipmentDetail
    v-if="currentView === 'detail'"
    :equipment="selectedEquipment"
    :source="images"
    color="green"
    @close="backToList"
  />
</template>

<script setup>
import { ref } from 'vue'
import EquipmentCard from '@/components/equipment/EquipmentCard.vue'
import EquipmentDetail from '@/components/equipment/equipment-detail.vue'
import MyBooking from '@/components/equipment/my-booking.vue'

const currentView = ref('list') // list | booking | detail

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
  }
]

const selectedEquipment = ref(null)

const openDetail = (item) => {
  selectedEquipment.value = {
    name: item.name,
    thumbnail: item.image,
    status: item.status,
    condition: 'New',
    description: item.spec,
    htmlContent: `
      <p>
        ${item.name} with ${item.spec}.<br />
        Current status: <b>${item.status}</b>.
      </p>
    `
  }

  currentView.value = 'detail'
}

const backToList = () => {
  selectedEquipment.value = null
  currentView.value = 'list'
}

const goToBooking = () => {
  currentView.value = 'booking'
}

const images = ref([
  '/src/assets/equipment/rsbrpi.png',
  '/src/assets/equipment/rsbrpi.png',
  '/src/assets/equipment/rsbrpi.png'
])
</script>

<style scoped>
.equipment-header {
  padding: 40px 250px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  text-align: left;

}

.header-left p {
  margin-bottom: 40px;
  margin-top: 15px;
  color: var(--color-text);
  opacity: 0.7;
  
}

.search-box {
  width: 260px;
  border: 1px solid var(--color-secondary);
  border-radius: 8px;
  padding: 10px 14px;
  background: var(--color-bg);
  margin-bottom: 1px;

}

.search-box input {
  border: none;
  outline: none;
  width: 100%;
  font-family: inherit;
}

.my-booking-btn {
  background-color: var(--color-primary);
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 18px;
  color : var(--color-bg);
}

.my-booking-btn img {
  width: 16px;
  height: 16px;
}

.page-wrapper {
  width: 100%;
  display: flex;
  justify-content: center;
}

.equipment-grid {
  width: 100%;
  padding: 40px 250px 156px;
  display: flex;
  flex-wrap: wrap;
  gap: 50px 25px;
  justify-content: flex-start;
}
</style>
