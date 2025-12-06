import { defineStore } from "pinia";
import { ref } from 'vue'
export const useNavStore = defineStore('nav', () => {
    const activeIndex = ref(0)
    const setActive = (index) => {
        activeIndex.value= index
    }
    return { activeIndex ,setActive}
})
