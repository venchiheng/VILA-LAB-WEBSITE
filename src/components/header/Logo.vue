<template>
    <div class="logo-container">
        <!-- Logo image -->
        <div class="logo-wrapper" :style="{ width: props.size + 'px', height: props.size + 'px' }">
            <img :src="logoImg" :alt="props.label" class="logo-image" />
        </div>
        <!-- Label -->
        <span class="logo-label" :style="{ fontSize: props.fontSize + 'px' }">{{ props.label }}</span>
    </div>
</template>

<script setup>
import logoImg from '@/assets/logo/VilaLab.png'

const props = defineProps({
    size: {
        type: Number,
        default: 60,
    },
    label: {
        type: String,
        default: 'ViLa Lab'
    },
    fontSize: {
        type: Number,
        default: 24
    }
})
</script>

<style scoped>
.logo-container {
    display: flex;
    align-items: center;
    /* vertically center logo & label */
    gap: 0.5rem;
    /* space between logo and label */
}

.logo-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

.logo-label {
    font-weight: 500;
 
    color: var(--color-bg);
}
</style>
