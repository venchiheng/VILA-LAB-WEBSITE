import { defineStore } from 'pinia'
import axios from 'axios'

export const useProjectStore = defineStore('project', {
  state: () => ({
    projects: []
  }),
  actions: {
    async fetchProjects() {
      try {
        const res = await axios.get('https://52.87.185.116:8000/api/projects')
        this.projects = res.data
      } catch (error) {
        console.error('Failed to fetch projects:', error)
      }
    }
  }
})
