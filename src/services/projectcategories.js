import api from './api'; 

const projectCategoriesService = {

  async getAll() {
    try {
      const response = await api.get('/project-categories');
      return response.data.data || [];
    } catch (error) {
      console.error('Error fetching project categories:', error);
      return [];
    }
  }
};

export default projectCategoriesService;
