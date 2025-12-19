<template>
    <button class="cta-button" :class="{ active: isActive }" @click="goToEquipments">
        Become a member
    </button>
</template>

<script setup>
import { computed } from 'vue'
import { Icon } from '@iconify/vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const isActive = computed(() => route.path === '/becomemember')

function goToEquipments() {
  router.push('/becomemember')
}
</script>
<style scoped>
.cta-button {
    background-color: var(--color-bg);
    color: var(--color-primary);
    font-weight: 600;
    padding: 8px 20px;
    height: 42px;
    border-radius: 9999px;
    transition: background 0.2s;
}

.cta-button:hover {
    background-color: var(--color-bg);
}

.cta-button.active {
    background-color: var(--color-primary);
    color: white;
}
</style>
