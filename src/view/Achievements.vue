<template>
  <div class="wrapper">
    <!-- ================= Achievements ================= -->
    <h1 class="page-title">Our Achievements</h1>

    <div class="carousel-container">
      <div class="card-frame">
        <transition name="fade" mode="out-in">
          <AchievementCard
            :key="currentIndex"
            :image="currentAchievement.image"
            class="active-card"
          />
        </transition>

        <button class="learn-more-btn">
          Learn more
          <svg width="8" height="12" viewBox="0 0 8 12">
            <path
              d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z"
              fill="#0049AF"
            />
          </svg>
        </button>
      </div>

      <div class="pagination-dots">
        <span
          v-for="(item, index) in achievements"
          :key="index"
          class="dot"
          :class="{ active: index === currentIndex }"
          @click="setCurrent(index)"
        ></span>
      </div>
    </div>

    <!-- ================= Partnership ================= -->
    <div class="partners-section">
      <h1 class="page-title">Our Partnership</h1>

      <!-- Top row (4 circles) -->
      <v-row justify="center" class="partners-row top-row">
        <v-col
          v-for="(partner, index) in partners.slice(0, 4)"
          :key="index"
          cols="6"
          sm="4"
          md="3"
          lg="3"
          class="d-flex justify-center"
        >
          <PartnerCard v-model:image="partner.image" />
        </v-col>
      </v-row>

      <!-- Bottom row (3 circles) -->
      <v-row justify="center" class="partners-row bottom-row">
        <v-col
          v-for="(partner, index) in partners.slice(0, 4)"
          :key="index"
          cols="6"
          sm="4"
          md="3"
          lg="3"
          class="d-flex justify-center"
        >
          <PartnerCard v-model:image="partner.image" />
        </v-col>
      </v-row>
    </div>

    <!-- ================= Publications ================= -->
    <div class="publication-list">
      <PublicationCard
        v-for="(pub, index) in publications"
        :key="index"
        :title="pub.title"
        :authors="pub.authors"
        :journal="pub.journal"
        :year="pub.year"
        @upload="handleUpload"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

/* Components */
import AchievementCard from '@/components/achievement/achievementcard.vue'
import PartnerCard from '@/components/PartnerCard/PartnerCard.vue'
import PublicationCard from '@/components/publication/PublicationCard.vue'

/* Achievement Images */
import achievementImg1 from '@/assets/achievement/achievementcard1.png'
import achievementImg2 from '@/assets/achievement/achievementcard2.png'
import achievementImg3 from '@/assets/achievement/achievementcard3.png'
import achievementImg4 from '@/assets/achievement/achievementcard4.png'

/* ================= Achievements Logic (UNCHANGED) ================= */
const currentIndex = ref(0)
let timer = null

const achievements = [
  { image: achievementImg1 },
  { image: achievementImg2 },
  { image: achievementImg3 },
  { image: achievementImg4 }
]

const currentAchievement = computed(() => achievements[currentIndex.value])

const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % achievements.length
}

const setCurrent = (index) => {
  currentIndex.value = index
  clearInterval(timer)
  startTimer()
}

const startTimer = () => {
  timer = setInterval(nextSlide, 5000)
}

onMounted(startTimer)
onUnmounted(() => clearInterval(timer))

/* ================= Partners (ONLY NEW PART) ================= */
const partners = ref([
  { image: '' },
  { image: '' },
  { image: '' },
  { image: '' },
  { image: '' },
  { image: '' },
  { image: '' }
])

/* ================= Publications (UNCHANGED) ================= */
const publications = [
  {
    title: 'Generative Adversarial Networks for Realistic Image Synthesis',
    authors: 'J. Doe, A. Smith, B. Johnson',
    journal: 'Journal of Vision and Learning',
    year: 2023
  }
]

const handleUpload = ({ type, file }) => {
  console.log(type, file)
}
</script>

<style scoped>
.wrapper {
  margin-top: 40px;
  padding: 40px 24px;
  display: flex;
  flex-direction: column;
  gap: 100px;
  align-items: center;
  background: white;
}

.page-title {
  color: var(--color-primary);
  text-align: center;
  font-size: 2.8rem;
  font-weight: 700;
  margin-bottom: 40px;
}

/* Carousel */
.carousel-container {
  display: flex;
  align-items: center;
  gap: 24px;
  width: 100%;
  max-width: 1200px;
  justify-content: center;
  flex-direction: column;
}

.card-frame {
  position: relative;
  width: 100%;
  border: 1px solid var(--color-primary);
  border-radius: 40px;
  overflow: hidden;
  aspect-ratio: 16 / 7;
}

.active-card {
  width: 100%;
  height: 100%;
}

.learn-more-btn {
  position: absolute;
  bottom: 8%;
  right: 5%;
  z-index: 10;
  background-color: var(--color-secondary);
  color: var(--color-primary);
  border: none;
  padding: 12px 24px;
  border-radius: 100px;
  font-weight: 600;
  cursor: pointer;
}

.pagination-dots {
  display: flex;
  gap: 12px;
}

.dot {
  width: 12px;
  height: 12px;
  background-color: #e0e0e0;
  border-radius: 50%;
  cursor: pointer;
}

.dot.active {
  background-color: var(--color-primary);
}

/* Partnership */
.partners-section {
  width: 100%;
  max-width: 1400px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.partners-row.top-row {
  margin-bottom: 40px;
}

/* Publications */
.publication-list {
  width: 100%;
  max-width: 1128px;
  display: flex;
  flex-direction: column;
  gap: 25px;
  align-items: center;
}

/* Fade */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Responsive */
@media (min-width: 768px) {
  .carousel-container {
    flex-direction: row;
  }
  .pagination-dots {
    flex-direction: column;
  }
}
</style>
