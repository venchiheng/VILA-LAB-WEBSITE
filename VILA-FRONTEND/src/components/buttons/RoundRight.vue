<template>
    <button class="round-button">
        <img :src="icon" alt="Right Icon" class="icon" />
    </button>
</template>

<script setup>
import rightIcon from '@/assets/icons/right.png'
const icon = rightIcon
</script>

<style scoped>
.round-button {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background-color: rgba(59, 130, 246, 0.25);
    backdrop-filter: blur(5px);
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 50%;
    right: 5px;
    transform: translateY(-50%);
    cursor: pointer;
    transition: all 0.3s ease;
}

.round-button:hover {
    background-color: rgba(59, 130, 246, 0.5);
}

.icon {
    width: 24px;
    height: 24px;
    object-fit: contain;
}
</style>
