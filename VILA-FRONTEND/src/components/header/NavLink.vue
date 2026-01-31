<template>
    <router-link :to="to" class="nav-link" :class="{ active: isActive }">
        {{ label }}
    </router-link>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const props = defineProps({
    to: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    }
})

const route = useRoute()
const isActive = computed(() => route.path === props.to)
</script>

<style scoped>
.nav-link {
    color: var(--color-bg);
    font-weight: 500;
    font-size: 16px;
    padding: 20px;
    transition: color 0.2s;
    color: var(--color-secondary);

}

.nav-link:hover {
    color: var(--color-bg);

}

.nav-link.active {
    font-weight: 700;
    color: var(--color-bg);
}

</style>
