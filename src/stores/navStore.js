import { defineStore } from 'pinia'

export const useNavStore = defineStore('nav', {
  state: () => ({
    activeIndex: 0
  }),
  actions: {
    setActive(index) {
      this.activeIndex = index
    }
  }
})
