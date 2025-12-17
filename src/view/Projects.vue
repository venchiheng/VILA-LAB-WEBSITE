<template>
    <h1>Hi this is for showcase our Projects</h1>
    <div class="projects-page">
    <div class="projects-grid">
      <ProjectCard
        v-for="project in projects"
        :key="project.id"
        :project-name="project.projectName"
        :description="project.description"
        :image="project.image"
      />
    </div>
  </div>
</template>

<script setup>
import ProjectCard from '../components/project/ProjectCard.vue'

const projects = [
  {
    id: 1,
    projectName: 'OUK CHAKTRANG',
    description:
      'Play the game online, anytime, anywhere! Choose Classic Mode for casual play or Ranked Mode to climb the leaderboard. Love the experience ...',
    image: '/src/assets/project/chatbot.png',
  },
  {
    id: 2,
    projectName: 'KHMER ONLINE HANDWRITING',
    description:
      'The collection of Khmer handwriting data is significant for supporting AI research on the Khmer language. Your participation in providing handwriting samples is extremely ...',
    image: '/src/assets/project/khmer-handwriting.png',
  },
]
</script>

<style scoped>
.projects-page {
  padding: 100px 80px 100px;
  min-height: 100vh;
  background-color: var(--color-bg);
}

.projects-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(288px, 1fr));
  gap: 40px;
  max-width: 1440px;
  margin: 0 auto;
  justify-items: center;
  direction: rtl;
}
</style>