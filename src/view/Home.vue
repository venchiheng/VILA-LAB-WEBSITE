<template>
  <Banner />
  <div class="project-section">
    <div class="project-content">
      <div class="project-title">
        <h1>Our Projects</h1>
        <p>Our project uses Natural Language Processing and Computer Vision to improve how machines understand Khmer language and visual content.</p>
        <router-link to="/projects" class="explore-btn">
          <img
            src="@/assets/icons/ic--baseline-message.png"
            alt="message"
            class="btn-icon"
          />
          <span>Read more</span>
        </router-link>
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
    </div>
  </div>
  <div class="carousel-wrapper">
    <v-carousel
      height="auto"
      show-arrows="hover"
      cycle
      :interval="5000"
      hide-delimiter-background
      class="research-carousel"
    >
      <v-carousel-item
        v-for="(chunk, i) in chunkedMembers"
        :key="i"
      >
        <div class="member-grid">
          <ResearchMemberCard
            v-for="member in chunk"
            :key="member.id"
            :name="member.name"
            :program="member.program"
            :description="member.description"
            :image="member.image"
            @explore="goToDetail(member.id)"
          />
        </div>
      </v-carousel-item>          
    </v-carousel>            
  </div>
</template>

<script setup>
import { computed } from 'vue'
import ProjectSection from '@/components/showcase/ProjectShowcase.vue'
import Banner from '../components/about-us/banner.vue'
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
  // {
  //   id: 3,
  //   projectName: 'AIR HANDWRITING FOR KHMER CHARACTERS',
  //   description:
  //     'The collection of Khmer handwriting data is significant for supporting AI research on the Khmer languages ...',
  //   image: '/src/assets/project/air-handwriting.png',
  // },
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
  {
    id: 6,
    name: 'Hengly EM',
    program: 'M-ECS',
    description:
      'Researcher of Word Spotting on Khmer Printed Documents using Deep Learning',
    image: '/src/assets/research-member/hengly.png'
  },
]

const itemsPerSlide = 4

// Split members into chunks for carousel slides
const chunkedMembers = computed(() => {
  const chunks = []
  for (let i = 0; i < members.length; i += itemsPerSlide) {
    chunks.push(members.slice(i, i + itemsPerSlide))
  }
  return chunks
})

const goToDetail = (id) => {
  console.log('Explore member:', id)
  // router.push(`/research/${id}`)
}

</script>

<style scoped>

.project-section {
  padding: 100px 156px;
  background-color: var(--color-bg);
  width: 100%;
  min-height: 600px;

}

.project-content {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 60px;
  max-width: 1400px;
  margin: 0 auto;
}

.project-title {
  flex: 0 0 40%;
  margin: auto 0; /* Centers vertically within parent */
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.project-title h1 {
  font-weight: bold;
  color: var(--color-primary);
  line-height: 1.2;
}

/* Button */
.explore-btn {
  align-self: center;
  background-color: var(--color-primary);
  color: var(--color-bg);
  padding: 12px 24px;
  border-radius: 100px;
  font-weight: bold;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  transition: all 0.3s ease;
}

.btn-icon {
  width: 20px;
  height: 20px;
  object-fit: contain;
}

.explore-btn:hover {
  background-color: #747bff;
  transform: translateY(-2px);
}

.projects-grid {
  background-color: var(--color-bg);
  flex: 0 0 55%;
  display: flex;
  grid-template-columns: repeat(auto-fill, minmax(288px, 1fr));
  gap: 24px;
  margin: 0 auto;
  flex-wrap: wrap;
  justify-content: flex-start;
}

.carousel-wrapper {
  width: 100%;
  padding: auto 0 100px;
}

.research-carousel {
  max-width: 1400px;
  margin: 0 auto;
}

.member-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  padding: 40px 20px;
  animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Only style the navigation arrows, not the control dots */
:deep(.v-window__controls .v-btn--icon) {
  background-color: var(--color-primary) !important;
  color: white !important;
}

/* Vuetify carousel customization */
:deep(.v-carousel__controls) {
  background: transparent;
  padding: 8px 0 16px 0;
}

:deep(.v-carousel__controls__item) {
  margin: 0 4px;
  pointer-events: none; /* Disable clicking on dots */
}

/* Small dots - inactive = light blue */
:deep(.v-carousel__controls__item .v-btn) {
  width: 8px !important;
  height: 8px !important;
  min-width: 8px !important;
  background-color: var(--color-secondary) !important;
  opacity: 1 !important;
  border-radius: 50% !important;
  box-shadow: none !important;
  border: none !important;
  outline: none !important;
  pointer-events: none !important;
}

/* Active dot = dark blue (primary color) */
:deep(.v-carousel__controls__item .v-btn--active) {
  background-color: var(--color-primary) !important;
}

/* Hide all internal elements */
:deep(.v-carousel__controls__item .v-btn::before),
:deep(.v-carousel__controls__item .v-btn::after),
:deep(.v-carousel__controls__item .v-btn .v-icon),
:deep(.v-carousel__controls__item .v-btn .v-btn__overlay),
:deep(.v-carousel__controls__item .v-btn .v-btn__underlay),
:deep(.v-carousel__controls__item .v-btn .v-ripple__container) {
  display: none !important;
}
</style>