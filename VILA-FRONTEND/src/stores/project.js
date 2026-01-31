import { defineStore } from 'pinia'
import axios from 'axios'

export const useProjectStore = defineStore('project', {
  state: () => ({
    projects: []
  }),
  actions: {
    async fetchProjects() {
      try {
        const res = await axios.get('http://44.223.137.10:8000/api/projects')
        this.projects = res.data
      } catch (error) {
        console.error('Failed to fetch projects:', error)
      }
    }
  }
})
