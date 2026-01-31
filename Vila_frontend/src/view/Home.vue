<template>
  <div class="home-container">
    <Banner />
    <div class="laboratory-section">
      <div class="laboratory-content">
        <div class="laboratory-title">
          <h1>Our Laboratory</h1>
          <p>ViLa Lab is a dedicated research laboratory under the Mechatronics and Information Technology (MIT) Research Unit and the Department of Information and Communication Engineering (GIC) at ITC.</p>
        </div>
      </div>
      <div class="laboratory-grid">
        <LaboratoryCard
          v-for="item in laboratories"
          :key="item.id"
          :name="item.name"
          :image="item.image"
        />
      </div>
    </div>
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
            v-for="project in projects.slice(0,2)"
            :key="project.id"
            :projectName="project.projectName"
            :description="project.description"
            :image="project.image"
          />
        </div>
      </div>
    </div>
    <div class="member-section">
      <div class="member-content">
        <div class="member-title">
          <h1>Research Members</h1>
          <p>Our lab consists of a diverse team of researchers and developers, working together to advance projects in AI, NLP, and Computer Vision, etc. Each member brings unique expertise to drive innovation and collaboration.</p>
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
    <div class="achievement-section">
      <h1 class="achievement-title">Our Achievements</h1>

      <v-defaults-provider
        :defaults="{ VBtn: { variant: 'outlined', color: '#eee' } }"
      >
        <div class="achievement-layout">
          <v-sheet
            class="overflow-hidden achievement-frame"
            max-width="1200"
            rounded="xl"
          >
            <v-carousel
              v-model="currentIndex"
              direction="vertical"
              height="450"
              hide-delimiters
              :show-arrows="false"
              cycle
              interval="5000"
            >
              <v-carousel-item
                v-for="(item, index) in achievements"
                :key="index"
              >
                <AchievementCard
                  :image="item.image"
                  class="active-card"
                />
              </v-carousel-item>

              <!-- Overlay -->
              <v-overlay
                :scrim="false"
                content-class="w-100 h-100 d-flex flex-column justify-end align-end pa-6"
                contained
                model-value
                persistent
              >
                <router-link to="/achievements" class="learn-more-btn">
                  Learn more
                  <svg width="8" height="12" viewBox="0 0 8 12">
                    <path
                      d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z"
                      fill="#0049AF"
                    />
                  </svg>
                </router-link>
              </v-overlay>
            </v-carousel>
          </v-sheet>

          <div class="pagination-dots outside-right">
            <span
              v-for="(_, index) in achievements"
              :key="index"
              class="dot"
              :class="{ active: index === currentIndex }"
              @click="currentIndex = index"
            ></span>
          </div>
        </div>
      </v-defaults-provider>
    </div>
    <div class="partners-section">
      <h1 class="partners-title">Our Partnership</h1>

      <v-row justify="center" class="partners-row">
        <v-col
          v-for="partner in partnerList"
          :key="partner.id"
          cols="6"
          sm="4"
          md="3"
          lg="2"
          class="d-flex justify-center pa-4"
        >
          <PartnerCard :image="partner.image" :name="partner.name" />
        </v-col>
      </v-row>

          <!-- <PartnerCard :image="partner.image" />
        </v-col>
      </v-row> -->
    </div>
  </div>
</template>

<script setup>
import Banner from '../components/about-us/banner.vue'
import ProjectCard from '../components/project/ProjectCard.vue'
import ResearchMemberCard from '../components/research-member/ResearchMemberCard.vue'
import AchievementCard from '@/components/achievement/achievementcard.vue'
import PartnerCard from '@/components/PartnerCard/PartnerCard.vue'
import LaboratoryCard from '@/components/laboratory/LaboratorryCard.vue'

import { ref, onMounted, computed } from 'vue'
import { usePartnershipStore } from '../stores/partnership'
import { useAchievementStore } from '../stores/achievement'

const currentIndex = ref(0)

// --- Laboratories ---
const laboratories = [
  { id: 1, name: 'Meeting Room', image: '/src/assets/laboratory/meeting-room.png' },
  { id: 2, name: 'Open Office Space', image: '/src/assets/laboratory/open-office.png' },
  { id: 3, name: 'Workspace Area', image: '/src/assets/laboratory/workspace.png' },
  { id: 4, name: 'Conference Room', image: '/src/assets/laboratory/conference.png' }
]

// --- Members ---
const members = [
  { id: 1, name: 'Heng HAM', program: 'M-ECS', description: 'Researcher of Online Khmer Handwritten Text Recognition', image: '/src/assets/research-member/heng.png' },
  { id: 2, name: 'Pechmonivann SEK', program: 'M-MIC', description: 'Researcher of Fine-tune FaceNet with Siamese Network', image: '/src/assets/research-member/vann.png' },
  { id: 3, name: 'Both CHAN', program: 'M-ECS', description: 'Researcher CNN-based Reinforcement Learning with Policy Gradient', image: '/src/assets/research-member/both.png' },
  { id: 4, name: 'Monyvann CHHAY', program: 'M-MIC', description: 'Researcher of Enhanced Robot Navigation through RL', image: '/src/assets/research-member/mony.png' },
  { id: 5, name: 'Kimleang LY', program: 'M-ECS', description: 'Researcher of Khmer Question-Answer System by fine-tuning LMs', image: '/src/assets/research-member/leang.png' },
  { id: 6, name: 'Hengly EM', program: 'M-ECS', description: 'Researcher of Word Spotting on Khmer Printed Documents', image: '/src/assets/research-member/hengly.png' }
]

const nextSlide = () => { if (currentIndex.value < members.length - 4) currentIndex.value++ }
const prevSlide = () => { if (currentIndex.value > 0) currentIndex.value-- }
const goToSlide = (index) => { if (index <= members.length - 4) currentIndex.value = index }
const goToDetail = (id) => { console.log('Explore member:', id) }

// --- Partnerships ---
const partnershipStore = usePartnershipStore()
onMounted(() => partnershipStore.fetchPartnerships())

const partnerList = computed(() =>
  partnershipStore.partnerships.map(p => ({
    id: p.id,
    image: p.thumbnail ? `http://44.223.137.10:8000/storage/${p.thumbnail}` : '',
    name: p.name
  }))
)

// --- Achievements ---
const achievementStore = useAchievementStore()
onMounted(async () => {
  await achievementStore.fetchAchievements()
})

const achievements = computed(() =>
  achievementStore.achievements.map(a => ({
    id: a.id,
    image: a.thumbnail ? `http://44.223.137.10:8000/storage/${a.thumbnail}` : '',
  }))
)


import projectsService from '@/services/projects'

// State
const projects = ref([])

// Optional: search/filter (hide if you don't need filtering)
const searchQuery = ref('')
const activeCategory = ref('All Projects')
const projectCategories = ref(['All Projects'])

// Load projects from backend
const loadProjects = async () => {
  try {
    const data = await projectsService.getAll()
    projects.value = data.map(p => ({
      id: p.id,
      projectName: p.title,
      description: p.description,
      image: p.banner_image
        ? `http://44.223.137.10:8000/storage/${p.banner_image}`
        : '/src/assets/project/default.png',
      category: p.category ? p.category.name : 'Other'
    }))

    // Extract categories for optional filter buttons
    const categories = new Set(data.map(p => (p.category ? p.category.name : 'Other')))
    projectCategories.value = ['All Projects', ...categories]
  } catch (error) {
    console.error('Error loading projects:', error)
  }
}

// Computed: filtered projects
const filteredProjects = computed(() =>
  projects.value.filter(project => {
    const matchesSearch =
      project.projectName.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      (project.description && project.description.toLowerCase().includes(searchQuery.value.toLowerCase()))
    const matchesCategory =
      activeCategory.value === 'All Projects' || project.category === activeCategory.value
    return matchesSearch && matchesCategory
  })
)

onMounted(() => {
  loadProjects()
})


</script>

<style scoped>

.home-container {
  background-color: var(--color-bg);
  width: 100%;
}

.laboratory-section {
  padding: 100px 156px 0px;
  background-color: var(--color-bg);
  width: 100%;
}

.laboratory-title {
  margin-bottom: 30px;
}

.laboratory-title h1 {
  font-weight: bold;
  color: var(--color-primary);
  line-height: 1.2;
  margin-bottom: 30px;
}

.laboratory-grid {
  padding: 0px 156px;
  display: grid;
  grid-template-columns: repeat(2, 552px);
  grid-template-rows: repeat(2, 356px);
  gap: 24px 24px;
  justify-content: center;
}

/* Responsive: stack on smaller screens */
@media (max-width: 1200px) {
  .laboratory-grid {
    grid-template-columns: 1fr;
    grid-template-rows: auto;
    padding: 60px 40px;
  }
}

.project-section {
  padding: 45px 156px;
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

.member-section {
  padding: 10px 156px;
  background-color: var(--color-bg);
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
  color: var(--color-text);
  line-height: 1.2;
  padding-bottom: 20px;
}

.member-title p {
  color: var(--color-text);
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
  background-color: var(--color-primary);
  color: var(--color-bg);
  border: none;
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
  background-color: #e0e0e0;
  border-radius: 50%;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.dot:hover {
  transform: scale(1.2);
}

.dot.active {
  background-color: var(--color-primary);
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

.achievement-section {
  padding: 10px 156px;
  background-color: var(--color-bg);
  width: 100%;
  min-height: 600px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.achievement-title {
  color: var(--color-text);
  margin-bottom: 30px;
}

.achievement-layout {
  display: flex;
  align-items: center;
  gap: 24px;
  width: 100%;
  max-width: 1400px;
}

.achievement-frame {
  border: 1px solid var(--color-primary);
  border-radius: 40px;
  background: var(--color-bg);
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  flex: 1;
}

.active-card {
  width: 100%;
  height: 100%;
}

.learn-more-btn {
  background-color: var(--color-secondary);
  color: var(--color-primary);
  border: none;
  padding: 12px 24px;
  border-radius: 100px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.pagination-dots.outside-right {
  display: flex;
  flex-direction: column;
  gap: 12px;
  align-items: center;
}

.dot {
  width: 12px;
  height: 12px;
  background-color: #e0e0e0;
  border-radius: 50%;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.dot.active {
  background-color: var(--color-primary);
}

.partners-section {
  width: 100%;
  max-width: 1400px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 110px 156px;
  margin: 0 auto;
}

.partners-title { 
  color: var(--color-text);
  margin-bottom: 30px;
  text-align: center;
}

.partners-row {
  row-gap: 40px;   
  column-gap: 40px; 
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  width: 100%;
}
</style>