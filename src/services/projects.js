import api from './api';

const projectsService = {
  async getAll() {
    try {
      const response = await api.get('/projects');
      return response.data.data || [];
    } catch (error) {
      console.error('Error fetching projects:', error);
      return [];
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/projects/${id}`);
      return response.data.data;
    } catch (error) {
      console.error(`Error fetching project ${id}:`, error);
      return null;
    }
  }
};

export default projectsService;
