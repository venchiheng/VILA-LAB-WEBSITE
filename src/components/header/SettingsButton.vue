<script setup>
import settingsIcon from '@/assets/icons/setting.png'

defineProps({
    size: { type: Number, default: 56 }
})
</script>

<template>
    <button :style="{ width: size + 'px', height: size + 'px', borderRadius: '50%' }" class="settings-button">
        <img :src="settingsIcon" alt="Settings" class="settings-icon"
            :style="{ width: size * 0.6 + 'px', height: size * 0.6 + 'px' }" />
    </button>
</template>

<style scoped>
.settings-button {
    border: none;
    background-color: var(--color-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding: 0;
    transition: background 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.settings-button:hover {
    background-color: var(--color-bg);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.settings-icon {
    object-fit: contain;
    display: block;
}
</style>
