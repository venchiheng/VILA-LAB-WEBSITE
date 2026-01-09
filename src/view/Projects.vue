<template>
    <div class="projects-page">
        <div class="projects-container">
            <Artical v-for="(project, index) in projects" :key="index"
                :title="project.title"
                :description="project.description"
                :tags="project.tags"
                class="project-item"
            />
        </div>
    </div>
</template>

<script setup>
import Artical from '@/components/artical/artical.vue'

const projects = [
    { 
        title: "Project Alpha: Autonomous Drone Navigation", 
        description: "Developing AI for real-time environmental mapping.", 
        tags: "AI, Robotics" 
    },
    { 
        title: "Project Beta: Natural Language Understanding", 
        description: "Developing a conversational AI that understands nuanced human language.", 
        tags: "AI, HCI" 
    },
    { 
        title: "Project Gamma: Predictive Data Modeling", 
        description: "Using machine learning to forecast market trends with high accuracy.", 
        tags: "Data Science" 
    },
    { 
        title: "Project Delta: Human-Computer Interaction Study", 
        description: "Researching intuitive interfaces for complex systems.", 
        tags: "Robotics, HCI" 
    }
]
</script>

<style scoped>
.projects-page {
    background-color: var(--color-bg);
    min-height: 100vh;
    padding-top: 100px; /* Space for fixed navbar */
    padding-bottom: 60px;
    display: flex;
    justify-content: center;
}

.projects-container {
    max-width: 1200px;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 32px;
    padding: 0 24px;
}
</style>