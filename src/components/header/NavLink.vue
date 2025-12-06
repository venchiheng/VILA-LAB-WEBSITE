<script setup>
defineProps({
    to: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    isActive: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <router-link :to="to" class="nav-link" :class="{ active: isActive }">
        {{ label }}
        <span v-if="isActive" class="active-indicator"></span>
    </router-link>
</template>

<style scoped>
.nav-link {
    position: relative;
    text-decoration: none;
    color: var(--color-bg);
    padding: 8px 12px;
    font-weight: 500;
    transition: color 0.2s;
}

.nav-link:hover {
    color: var(--color-secondary);

}


.active-indicator {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: var(--color-secondary);
    border-radius: 2px;
    transition: left 0.3s ease, width 0.3s ease;
}
</style>
