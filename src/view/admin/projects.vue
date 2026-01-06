<template>
  <div class="admin-projects">
    <div class="header">
      <div class="title-section">
        <h1>Project Management</h1>
        <p class="subtitle">Create and manage your research projects</p>
      </div>
      <button class="add-btn" @click="openCreateModal">
        <Icon icon="mdi:plus" /> Add New Project
      </button>
    </div>

    <!-- Stats summary -->
    <div class="stats-grid">
      <div class="stat-card">
        <span class="stat-label">Total Projects</span>
        <span class="stat-value">{{ projects.length }}</span>
      </div>
      <div class="stat-card">
        <span class="stat-label">Categories</span>
        <span class="stat-value">{{ categories.length - 1 }}</span>
      </div>
    </div>

    <!-- Search and filter -->
    <div class="controls">
      <div class="search-box">
        <Icon icon="mdi:magnify" class="search-icon" />
        <input type="text" v-model="searchQuery" placeholder="Search projects by title or description..." />
      </div>
      <div class="filter-chips">
        <button 
          v-for="cat in categories" 
          :key="cat" 
          :class="['chip', { active: activeCategory === cat }]"
          @click="activeCategory = cat"
        >
          {{ cat }}
        </button>
      </div>
    </div>

    <!-- Projects List/Grid -->
    <div class="projects-container" v-if="filteredProjects.length > 0">
      <div class="project-admin-card" v-for="project in filteredProjects" :key="project.id">
        <!-- Using ProjectCard style structure but with admin controls -->
        <div class="card-image-wrapper">
          <img :src="project.image" :alt="project.title" />
          <div class="admin-overlay">
             <button class="action-btn edit" @click="editProject(project)" title="Edit">
                <Icon icon="mdi:pencil" />
              </button>
              <button class="action-btn delete" @click="deleteProject(project.id)" title="Delete">
                <Icon icon="mdi:delete" />
              </button>
          </div>
          <div class="category-badge">{{ project.category }}</div>
        </div>
        
        <div class="card-bottom-section">
          <h3 class="project-name">{{ project.title }}</h3>
          <p class="description">{{ project.description }}</p>
          <div class="tags-container">
            <span v-for="(tag, index) in project.tags" :key="index" class="tag">
                {{ tag }}<span v-if="index < project.tags.length - 1" class="separator">, </span>
            </span>
          </div>
        </div>
      </div>
    </div>
    
    <div class="empty-state" v-else>
      <Icon icon="mdi:folder-open-outline" class="empty-icon" />
      <p>No projects found matching your criteria</p>
    </div>

    <!-- Modal for Create/Edit -->
    <ProjectModal 
      v-if="showModal" 
      :project="currentProject" 
      :loading="isSaving"
      @close="showModal = false" 
      @save="handleSave"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ProjectModal from '@/components/admin/project-card.vue';
import projectImage from '@/assets/project/image1.jpeg';

const searchQuery = ref('');
const activeCategory = ref('All');
const showModal = ref(false);
const currentProject = ref(null);
const isSaving = ref(false);

// Dummy data for admin
const projects = ref([
    { 
        id: 1,
        title: "Project Alpha: Autonomous Drone Nagavation", 
        description: "Developing AI for real-time environmental mapping.", 
        tags: ["AI", "Robotics"],
        category: "Artificial Intelligence",
        image: projectImage
    },
    { 
        id: 2,
        title: "Project Beta: Natural Language Understanding", 
        description: "Developing a conversational AI that understands nuanced human language.", 
        tags: ["AI", "HCI"],
        category: "NLP",
        image: projectImage
    },
    { 
        id: 3,
        title: "Project Gamma: Predictive Data Modeling", 
        description: "Using machine learning to forecast market trends with high accuracy.", 
        tags: ["Data Science"],
        category: "Data Science",
        image: projectImage
    },
    { 
        id: 4,
        title: "Project Delta: Human-Computer Interaction Study", 
        description: "Researching intuitive interfaces for complex systems.", 
        tags: ["Robotics", "HCI"],
        category: "Computer Vision",
        image: projectImage
    }
]);

const categories = ["All", "Artificial Intelligence", "Computer Vision", "Data Science", "NLP"];

const filteredProjects = computed(() => {
    return projects.value.filter(p => {
        const matchesSearch = p.title.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
                             p.description.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesCategory = activeCategory.value === 'All' || p.category === activeCategory.value;
        return matchesSearch && matchesCategory;
    });
});

const openCreateModal = () => {
    currentProject.value = null;
    showModal.value = true;
};

const editProject = (project) => {
    currentProject.value = { ...project };
    showModal.value = true;
};

const deleteProject = (id) => {
    if (confirm('Are you sure you want to delete this project?')) {
        projects.value = projects.value.filter(p => p.id !== id);
    }
};

const handleSave = async (projectData) => {
    isSaving.value = true;
    
    // Mock API call delay for backend connectivity simulation
    await new Promise(resolve => setTimeout(resolve, 1200));
    
    if (projectData.id) {
        const index = projects.value.findIndex(p => p.id === projectData.id);
        if (index !== -1) projects.value[index] = projectData;
    } else {
        const newProject = {
            ...projectData,
            id: Date.now(),
            image: projectData.image || projectImage
        };
        projects.value.push(newProject);
    }
    
    isSaving.value = false;
    showModal.value = false;
};
</script>

<style scoped>
.admin-projects {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 24px; /* Matches content-wrapper padding in Projects.vue */
  text-align: left;
  background-color: transparent;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start; /* Changed to flex-start to match provided design */
  margin-bottom: 40px;
}

.title-section h1 {
  margin: 0;
  font-size: 39px; /* Matches Projects.vue */
  font-weight: 700; /* Sticking to 700 */
  color: var(--color-text); /* Using CSS var */
  letter-spacing: -0.5px;
}

.subtitle {
  color: #666;
  margin: 8px 0 0 0;
  font-size: 16px;
  font-weight: 400;
}

.add-btn {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px 32px;
  background-color: var(--color-primary);
  color: white;
  border-radius: 100px;
  font-weight: 700;
  font-size: 16px;
  border: none;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 12px rgba(0, 73, 175, 0.2);
}

.add-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0, 73, 175, 0.3);
  filter: brightness(1.05);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-bottom: 50px;
}

.stat-card {
  padding: 32px;
  background: white;
  border-radius: 16px;
  border: 1px solid var(--color-secondary);
  display: flex;
  flex-direction: column;
  gap: 12px;
  transition: border-color 0.2s;
}

.stat-label {
  font-size: 15px;
  font-weight: 600;
  color: #666;
}

.stat-value {
  font-size: 42px;
  font-weight: 800;
  color: var(--color-primary);
  line-height: 1;
}

.controls {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin-bottom: 40px;
}

.search-box {
  position: relative;
  width: 100%;
  max-width: 400px;
}

.search-icon {
  position: absolute;
  left: 20px;
  top: 50%;
  transform: translateY(-50%);
  color: #999;
  font-size: 20px;
}

.search-box input {
  width: 100%;
  height: 54px;
  padding: 0 20px 0 54px;
  border-radius: 12px;
  border: 1px solid var(--color-secondary);
  font-size: 16px;
  font-family: inherit;
  transition: all 0.2s;
  background-color: white;
  color: #222;
}

.search-box input:focus {
  border-color: var(--color-primary);
  outline: none;
  box-shadow: 0 0 0 4px rgba(0, 73, 175, 0.05);
}

.filter-chips {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.chip {
  padding: 12px 28px;
  border-radius: 100px;
  background: var(--color-secondary);
  color: #444;
  border: none;
  cursor: pointer;
  font-weight: 600;
  font-size: 15px;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.chip.active {
  background: var(--color-primary);
  color: white;
  box-shadow: 0 4px 12px rgba(0, 73, 175, 0.2);
}

.chip:not(.active):hover {
  background: #cbdceb;
  color: #222;
}

/* Projects grid aligned with ProjectCard.vue */
.projects-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}

.project-admin-card {
  width: 100%;
  background-color: transparent;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease;
}

.project-admin-card:hover {
  transform: translateY(-8px);
}

.card-image-wrapper {
  position: relative;
  width: 100%;
  aspect-ratio: 16/10;
  overflow: hidden;
  background-color: var(--color-secondary);
  border-radius: 20px;
  margin-bottom: 0;
}

.card-image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.admin-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 73, 175, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  opacity: 0;
  transition: opacity 0.3s ease;
  backdrop-filter: blur(3px);
}

.card-image-wrapper:hover .admin-overlay {
  opacity: 1;
}

.action-btn {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  cursor: pointer;
  font-size: 24px;
  transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.action-btn.edit {
  background: white;
  color: var(--color-primary);
}

.action-btn.delete {
  background: white;
  color: var(--color-error);
}

.action-btn:hover {
  transform: scale(1.15);
}

.category-badge {
  position: absolute;
  top: 16px;
  left: 16px;
  background: var(--color-primary);
  color: white;
  padding: 8px 16px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 700;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card-bottom-section {
  padding: 20px 0 0 0;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.project-name {
  font-weight: 700;
  font-size: 20px;
  margin: 0;
  text-align: left;
  color: #222;
  line-height: 1.3;
}

.description {
  font-size: 16px;
  line-height: 1.6;
  text-align: left;
  margin: 0;
  color: #444;
  font-weight: 400;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.tags-container {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 4px;
  margin-top: 4px;
}

.tag {
    font-size: 14px;
    font-weight: 600;
    color: var(--color-primary);
}

.separator {
  color: #666;
}

.empty-state {
  text-align: center;
  padding: 100px 40px;
  color: #999;
}

.empty-icon {
  font-size: 72px;
  margin-bottom: 20px;
  opacity: 0.3;
}

@media (max-width: 1024px) {
  .projects-container {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .header {
    flex-direction: column;
    align-items: flex-start;
    gap: 28px;
  }
  
  .projects-container {
    grid-template-columns: 1fr;
  }
  
  .title-section h1 {
    font-size: 32px;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .add-btn {
    width: 100%;
    justify-content: center;
  }
}
</style>


