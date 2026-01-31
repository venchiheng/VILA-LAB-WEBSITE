import { defineStore } from "pinia";
import { ref, onMounted, onUnmounted } from 'vue'

export const useScreenStore = defineStore('screen', () => {
    const isSmallScreen = ref(window.innerWidth < 768)
    const handleResize = () => {
        isSmallScreen.value= window.innerWidth<768
    }
    onMounted(() => {
        window.addEventListener('resize',handleResize)
    })
    onUnmounted(() => {
        window.removeEventListener('resize',handleResize)
    })
    return { isSmallScreen}
})