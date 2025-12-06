<script setup>
import logoImg from '@/assets/logo/VilaLab.png'

const props = defineProps({
    size: {
        type: Number,
        default: 60, // width & height of logo image
    },
    label: {
        type: String,
        default: 'ViLa Lab'
    },
    fontSize: {
        type: Number,
        default: 24 // font size for the label in pixels
    }
})
</script>

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
    font-weight: 700;
    white-space: nowrap;
    color: var(--color-bg);
}
</style>
