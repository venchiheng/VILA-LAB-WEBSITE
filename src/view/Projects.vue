<template>
    <div class="projects-page">
        <div class="content-wrapper">
            <!-- Header -->
            <div class="page-header">
                <h1>Research & Innovation Projects</h1>
                <p class="subtitle">Explore our ongoing work in AI, Computer Vision, Data Science, and more.</p>
            </div>

            <!-- Controls -->
            <div class="controls-section">
                <!-- Search Bar -->
                <div class="search-bar">
                    <div class="search-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z"
                                stroke="#222222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21 21L16.65 16.65" stroke="#222222" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <input type="text" v-model="searchQuery" placeholder="Search projects...." class="search-input" />
                </div>

                <!-- Filter Buttons -->
                <div class="filter-buttons">
                    <button v-for="category in projectCategoriesStore.categories" :key="category"
                        :class="['filter-btn', { active: activeCategory === category }]"
                        @click="activeCategory = category">
                        {{ category }}
                    </button>
                </div>
            </div>

            <!-- Projects Grid -->
            <div class="projects-grid">
                <ProjectCard v-for="(project, index) in filteredProjects" :key="index" :projectName="project.title"
                    :description="project.description" 
                    :image="project.banner_image || projectImage" 
                    :tags="[project.status, project.category ? project.category.name : ''].filter(t => t)" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { useProjectCategoriesStore } from '../stores/categories';
import projectsService from '@/services/projects';
import { ref, computed, onMounted } from 'vue';

// const searchQuery = ref('');
// const activeCategory = ref('All Projects');

const projectCategoriesStore = useProjectCategoriesStore();
const projects = ref([]);

const searchQuery = ref("");
const activeCategory = ref("All Projects");

const filteredProjects = computed(() => {
    return projects.value.filter(project => {
        const matchesSearch = project.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            (project.description && project.description.toLowerCase().includes(searchQuery.value.toLowerCase()));
        
        // Match category name from the nested object (e.g. project.category.name)
        const projectCategoryName = project.category ? project.category.name : null;
        const matchesCategory = activeCategory.value === "All Projects" || projectCategoryName === activeCategory.value;

        return matchesSearch && matchesCategory;
    });
});

const loadProjects = async () => {
    try {
        const data = await projectsService.getAll();
        projects.value = data;
    } catch (error) {
        console.error("Error loading projects:", error);
    }
};

onMounted(async () => {
    await projectCategoriesStore.fetchCategories(); // load categories dynamically
    await loadProjects(); // load projects from backend
});
</script>

<style scoped>
.projects-page {
    background-color: var(--color-bg);
    min-height: 100vh;
    padding-top: 120px;
    /* Space for fixed navbar + header spacing */
    padding-bottom: 80px;
    display: flex;
    justify-content: center;
}

.content-wrapper {
    max-width: 1200px;
    width: 100%;
    padding: 0 24px;
    display: flex;
    flex-direction: column;
    gap: 60px;
}

/* Header */
.page-header {
    text-align: left;
}

.page-header h1 {
    font-size: 39px;
    font-weight: 700;
    color: var(--color-text);
    /* Black title */
    margin-bottom: 16px;
}

.subtitle {
    font-size: 16px;
    font-weight: 400;
    color: var(--color-text);
    margin: 0;
}

/* Controls */
.controls-section {
    display: flex;
    flex-direction: column;
    gap: 32px;
    align-items: flex-start;
}

/* Search Bar */
.search-bar {
    position: relative;
    width: 100%;
    max-width: 400px;
}

.search-input {
    width: 100%;
    height: 50px;
    border: 1px solid #CCCCCC;
    border-radius: 12px;
    /* Slight rounding like screenshot */
    padding-left: 50px;
    /* Space for icon */
    padding-right: 16px;
    font-size: 16px;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s;
}

.search-input:focus {
    border-color: var(--color-primary);
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    display: flex;
}

/* Filter Buttons */
.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.filter-btn {
    padding: 10px 24px;
    border-radius: 100px;
    background-color: #E0E0E0;
    /* Inactive gray color */
    color: var(--color-text);
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s, color 0.2s;
}

.filter-btn:hover {
    background-color: #D0D0D0;
}

.filter-btn.active {
    background-color: var(--color-primary);
    color: var(--color-bg);
    /* White text on active */
}

/* Grid */
.projects-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    /* 3 Columns on desktop */
    gap: 32px;
}

/* Responsive */
@media (max-width: 1024px) {
    .projects-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .projects-grid {
        grid-template-columns: 1fr;
    }

    .page-header h1 {
        font-size: 32px;
    }

    .search-bar {
        max-width: 100%;
    }
}
</style>