<template>
  <v-tooltip location="top">
    <template #activator="{ props }">
      <button class="settings-button" :class="{ active: isActive }" @click="goToEquipments" v-bind="props">
        <Icon class="icon" icon="streamline:ai-chip-spark-solid" />
      </button>
    </template>
    <span>Equipments booking</span>
  </v-tooltip>
</template>

<script setup>
import { computed } from 'vue'
import { Icon } from '@iconify/vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const isActive = computed(() => route.path === '/equipments')

function goToEquipments() {
  router.push('/equipments')
}
</script>

<style scoped>
.settings-button {
  border: none;
  background-color: var(--color-bg);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  padding: 10px;
  border-radius: 50%;
  transition: background 0.2s, box-shadow 0.2s;
}

.settings-button:hover {
  background-color: var(--color-secondary);
}

.icon {
  width: 24px;
  height: 24px;
  color: var(--color-primary);
}

.settings-button.active {
  background-color: var(--color-primary);
}

.settings-button.active .icon {
  color: white;
}
</style>
