<template>
  <!-- Header -->
  <div v-if="currentView === 'list'" class="equipment-header">
    <div class="header-left">
      <h1>Equipment Booking</h1>
      <p>Lab Resource management</p>

      <div class="search-box">
        <input type="text" placeholder="Search equipment..." v-model="searchQuery" />
      </div>
    </div>

    <button class="my-booking-btn" @click="goToBooking">
      <img src="/src/assets/icons/folder.png" alt="folder" />
      <span>My Booking</span>
    </button>
  </div>

  <!-- Equipment List -->
  <div v-if="currentView === 'list'" class="page-wrapper">
    <div class="equipment-grid">
      <EquipmentCard
        v-for="item in filteredEquipments"
        :key="item.id"
        v-bind="item"
        @view-detail="openDetail"
      />
    </div>
  </div>

  <!-- My Booking -->
  <MyBooking v-if="currentView === 'booking'" />

  <!-- Equipment Detail -->
  <EquipmentDetail
    v-if="currentView === 'detail'"
    :equipment="selectedEquipment"
    :source="images"
    color="green"
    @close="backToList"
  />
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import EquipmentCard from '@/components/equipment/EquipmentCard.vue'
import EquipmentDetail from '@/components/equipment/equipment-detail.vue'
import MyBooking from '@/components/equipment/my-booking.vue'
import { useEquipmentStore } from '@/stores/equipments'

const route = useRoute()
const router = useRouter()
const equipmentStore = useEquipmentStore()

const searchQuery = ref('')

// Computed list from store (filtered by search)
const filteredEquipments = computed(() => {
  if (!searchQuery.value) return equipmentStore.equipments
  return equipmentStore.equipments.filter(e =>
    e.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

// Selected equipment for detail view
const selectedEquipment = ref(null)

// Current view
const currentView = computed(() => {
  const id = route.params.id
  if (id === 'booking') return 'booking'
  if (id && !isNaN(id)) return 'detail'
  return 'list'
})

// Update selected equipment based on route id
const updateSelectedEquipment = () => {
  const id = parseInt(route.params.id)
  if (!isNaN(id)) {
    const item = equipmentStore.getById(id)
    if (item) {
      // Pass the full item object with extra computed fields
      selectedEquipment.value = {
        ...item,
        thumbnail: item.image,
        condition: 'New',
        htmlContent: `<p>${item.name} with ${item.spec}.<br />Current status: <b>${item.status}</b>.</p>`
      }
    } else {
      router.replace('/equipments')
    }
  } else {
    selectedEquipment.value = null
  }
}

watch(() => route.params.id, updateSelectedEquipment, { immediate: true })

// Navigation handlers
const openDetail = (item) => {
  router.push(`/equipments/${item.id}`)
}

const backToList = () => router.push('/equipments')
const goToBooking = () => router.push('/equipments/booking')

// Fetch equipments from API on mount
onMounted(() => {
  equipmentStore.fetchEquipments()
})
</script>


<style scoped>
.equipment-header {
  padding: 40px 156px;
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
  padding: 40px 156px;
  display: flex;
  flex-wrap: wrap;
  gap: 50px 55px;
  justify-content: flex-start;
}
</style>
