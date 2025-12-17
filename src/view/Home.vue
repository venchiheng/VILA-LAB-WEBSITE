<template>
  <div>
    <h1>To be constructed...</h1>
    <!-- <ProjectSection />   -->
  </div>

  <div class="projects-grid">
    <ProjectCard
      v-for="project in projects"
      :key="project.id"
      :project-name="project.projectName"
      :description="project.description"
      :image="project.image"
    />
  </div>

  <div class="member-grid">
    <ResearchMemberCard
      v-for="member in members"
      :key="member.id"
      :name="member.name"
      :program="member.program"
      :description="member.description"
      :image="member.image"
      @explore="goToDetail(member.id)"
    />
  </div>

</template>

<script setup>
import ProjectSection from '@/components/showcase/ProjectShowcase.vue'

import ProjectCard from '../components/project/ProjectCard.vue'
import ResearchMemberCard from '../components/research-member/ResearchMemberCard.vue'

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
  {
    id: 3,
    projectName: 'AIR HANDWRITING FOR KHMER CHARACTERS',
    description:
      'The collection of Khmer handwriting data is significant for supporting AI research on the Khmer languages ...',
    image: '/src/assets/project/air-handwriting.png',
  },
]

const members = [
  {
    id: 1,
    name: 'Heng HAM',
    program: 'M-ECS',
    description:
      'Researcher of Online Khmer Handwritten Text Recognition for Teaching and Learning Assistance',
    image: '/src/assets/research-member/heng.png'
  },
  {
    id: 2,
    name: 'Pechmonivann SEK',
    program: 'M-MIC',
    description:
      'Researcher of Fine-tune FaceNet with Siamese Network for Cambodian Face Dataset',
    image: '/src/assets/research-member/vann.png'
  },
  {
    id: 3,
    name: 'Both CHAN',
    program: 'M-ECS',
    description:
      'Researcher CNN-based Reinforcement Learning with Policy Gradient for Khmer Chess',
    image: '/src/assets/research-member/both.png'
  },
  {
    id: 4,
    name: 'Monyvann CHHAY',
    program: 'M-MIC',
    description:
      'Researcher of Enhanced Robot Navigation through Reinforcement Learning with Khmer Direction Recognition',
    image: '/src/assets/research-member/mony.png'
  },
  {
    id: 5,
    name: 'Kimleang LY',
    program: 'M-ECS',
    description:
      'Researcher of Khmer Question-Answer System by Fine-tuning Pre-trained language Models',
    image: '/src/assets/research-member/leang.png'
  },
]

const goToDetail = (id) => {
  console.log('Explore member:', id)
  // router.push(`/research/${id}`)
}
</script>

<style scoped>

.projects-grid {
  background-color: var(--color-bg);
  padding: 100px 0px 100px 100px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(288px, 1fr));
  gap: 40px;
  max-width: 1440px;
  margin: 0 auto;
  justify-items: center;
  direction: rtl;
}

.member-grid {
  /* display: grid; */
  padding: 100px 80px 156px 80px;
  grid-template-columns: repeat(auto-fill, minmax(288px, 1fr));
  display: flex;
  flex-wrap: wrap;
  column-gap: 20px;
  justify-content: center;
}
</style>