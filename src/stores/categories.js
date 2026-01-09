
import { defineStore } from 'pinia';
import projectCategoriesService from '@/services/projectCategories';

export const useProjectCategoriesStore = defineStore('projectCategories', {
  state: () => ({
    categories: ['All Projects'], 
  }),
  actions: {
    async fetchCategories() {
      try {
        const categoriesFromAPI = await projectCategoriesService.getAll();
        this.categories = ['All Projects', ...categoriesFromAPI.map(cat => cat.name)];
      } catch (error) {
        console.error('Failed to fetch categories:', error);
      }
    }
  }
});
