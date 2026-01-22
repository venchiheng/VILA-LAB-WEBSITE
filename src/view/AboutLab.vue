<template>
    <div class="cover-container">
        <img src="@/assets/about-us/cover.png" alt="Cover Image" class="cover-image" />
    </div>
    <History />
    <HOL_Card />    
    <OurVision />
    <OurService :services="servicesData" />
    <ResearchInterests />
    <ExpectedApplications />
    <div class="member-section">
      <div class="member-content">
        <div class="member-title">
          <h1>Research Members</h1>
        </div>
      </div>
      <div class="carousel-wrapper">
        <div class="carousel-container">
          <button 
            class="carousel-nav prev" 
            @click="prevSlide"
            :disabled="currentIndex === 0"
          >
            <img src="/src/assets/icons/left.png" alt="Previous" class="nav-icon" />
          </button>
          
          <div class="carousel-viewport">
            <div 
              class="member-grid" 
              :style="{ transform: `translateX(-${currentIndex * (100 / 4)}%)` }"
            >
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
          </div>
          
          <button 
            class="carousel-nav next" 
            @click="nextSlide"
            :disabled="currentIndex >= members.length - 4"
          >
            <img src="/src/assets/icons/right.png" alt="Next" class="nav-icon" />
          </button>
        </div>
        
        <div class="carousel-dots">
          <span 
            v-for="(member, index) in members" 
            :key="index"
            class="dot"
            :class="{ active: index === currentIndex }"
            @click="goToSlide(index)"
          ></span>
        </div>
      </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import OurVision from '@/components/about-us/our-vision.vue'
import HOL_Card from '../components/about-us/HOL_Card.vue';
import OurService from '@/components/about-us/our-service.vue';
import History from '@/components/about-us/history.vue';
import ResearchInterests from '@/components/about-us/research-interests.vue';
import ExpectedApplications from '@/components/about-us/expected-application.vue';
import ResearchMemberCard from '../components/research-member/ResearchMemberCard.vue'

// Import assets for services
import service1 from '@/assets/our-service/service1.png'
import service2 from '@/assets/our-service/service2.png'
import service3 from '@/assets/our-service/service3.png'

// currentIndex ref
const currentIndex = ref(0)

const servicesData = [
    { 
        image: service1, 
        title: "Consultation on AI solutions for businesses and institutions" 
    },
    { 
        image: service2, 
        title: "AI skills training on Machine Learning, Deep Learning, Computer Vision, and NLP" 
    },
    { 
        image: service3, 
        title: "AI application development in sectors such as education, agriculture, and healthcare" 
    }
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

const nextSlide = () => {
  if (currentIndex.value < members.length - 4) {
    currentIndex.value++
  }
}

const prevSlide = () => {
  if (currentIndex.value > 0) {
    currentIndex.value--
  }
}

const goToSlide = (index) => {
  if (index <= members.length - 4) {
    currentIndex.value = index
  }
}

const goToDetail = (id) => {
  console.log('Explore member:', id)
  // router.push(`/research/${id}`)
}
</script>

<style scoped>
.cover-container {
    width: 100%;
    margin-bottom: 60px;
}

.cover-image {
    width: 100%;
    height: auto;
    object-fit: cover;
}

.member-section {
  padding: 50px 156px 0px;
  background-color: var(--color-primary);
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.member-title {
  text-align: start;
  width: 100%;
  max-width: 1400px;
}

.member-title h1 {
  font-weight: bold;
  color: var(--color-bg);
  line-height: 1.2;
  padding-bottom: 20px;
}

.member-title p {
  color: var(--color-bg);
  line-height: 1.6;
}

.carousel-wrapper {
  width: 100%;
  padding: auto 0 100px;
  margin-bottom: 100px;
  max-width: 1400px;
  padding: 40px 0 100px;
  margin-bottom: 100px;
}

.carousel-container {
  position: relative;
  display: flex;
  align-items: center;
  gap: 20px;
}

.carousel-container:hover .carousel-nav:not(:disabled) {
  opacity: 1;
}

.carousel-viewport {
  overflow: hidden;
  width: 100%;
}

.member-grid {
  display: grid;
  grid-template-columns: repeat(6, calc(25% - 18px));
  gap: 24px;
  transition: transform 0.5s ease-in-out;
  width: 100%;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.carousel-nav {
  background-color: #100d5f;
  color: var(--color-bg);
  border: 3px solid var(--color-bg); /* Add border here */
  width: 48px;
  height: 48px;
  border-radius: 50%;
  font-size: 24px;
  cursor: pointer;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity 0.3s ease, transform 0.2s ease;
  z-index: 10;
  opacity: 0;
}

.carousel-nav:hover:not(:disabled) {
  transform: scale(1.1);
}

.carousel-nav:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

.nav-icon {
  width: 20px;
  height: 20px;
  object-fit: contain;
  
}

.carousel-dots {
  display: flex;
  justify-content: center;
  gap: 12px;
  margin-top: 30px;
}

.dot {
  width: 12px;
  height: 12px;
  background-color: #707070;
  border-radius: 50%;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.dot:hover {
  transform: scale(1.2);
}

.dot.active {
  background-color: #ffffff;
}

/* Responsive Design */
@media screen and (max-width: 1400px) {
  .member-section {
    padding-left: 80px;
    padding-right: 80px;
  }
}

@media screen and (max-width: 1024px) {
  .member-section {
    padding-left: 40px;
    padding-right: 40px;
  }
  
  .member-grid {
    grid-template-columns: repeat(6, calc(33.333% - 16px));
  }
}
</style>