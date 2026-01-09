<template>
  <div class="wrapper">
    <h1 class="page-title">Our Achievements</h1>

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
              <button class="learn-more-btn">
                Learn more
                <svg width="8" height="12" viewBox="0 0 8 12">
                  <path
                    d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z"
                    fill="#0049AF"
                  />
                </svg>
              </button>
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

    <div class="partners-section">
      <h1 class="page-title">Our Partnership</h1>

      <v-row justify="center">
        <v-col
          v-for="(partner, index) in partners"
          :key="index"
          cols="6"
          sm="4"
          md="3"
          lg="2"
          class="d-flex justify-center pa-4"
        >
          <PartnerCard :image="partner.image" />
        </v-col>
      </v-row>
    </div>

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
import { ref } from 'vue'

import AchievementCard from '@/components/achievement/achievementcard.vue'
import PartnerCard from '@/components/PartnerCard/PartnerCard.vue'
import PublicationCard from '@/components/publication/PublicationCard.vue'

import achievementImg1 from '@/assets/achievement/achievementcard1.png'
import achievementImg2 from '@/assets/achievement/achievementcard2.png'
import achievementImg3 from '@/assets/achievement/achievementcard3.png'
import achievementImg4 from '@/assets/achievement/achievementcard4.png'

import partner1 from '@/assets/Partner/partner1.png'
import partner2 from '@/assets/Partner/partner2.png'
import partner3 from '@/assets/Partner/partner3.png'
import partner4 from '@/assets/Partner/partner4.png'
import partner5 from '@/assets/Partner/partner5.png'
import partner6 from '@/assets/Partner/partner6.png'
import partner7 from '@/assets/Partner/partner7.png'

const currentIndex = ref(0)

const achievements = [
  { image: achievementImg1 },
  { image: achievementImg2 },
  { image: achievementImg3 },
  { image: achievementImg4 }
]

const partners = [
  { image: partner1 },
  { image: partner2 },
  { image: partner3 },
  { image: partner4 },
  { image: partner5 },
  { image: partner6 },
  { image: partner7 }
]

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
  background-color: var(--color-bg);
}

.page-title {
  color: var(--color-primary);
  text-align: center;
  font-size: 2.8rem;
  font-weight: 700;
  margin-bottom: 10px;
}

.achievement-layout {
  display: flex;
  align-items: center;
  gap: 24px;
}

.achievement-frame {
  border: 1px solid var(--color-primary);
  border-radius: 40px;
  background: var(--color-bg);
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
  gap: 8px;
}

.pagination-dots.outside-right {
  display: flex;
  flex-direction: column;
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

.partners-section {
  width: 100%;
  max-width: 1400px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.publication-list {
  width: 100%;
  max-width: 1128px;
  display: flex;
  flex-direction: column;
  gap: 25px;
  align-items: center;
}

@media (max-width: 768px) {
  .achievement-layout {
    flex-direction: column;
  }

  .pagination-dots.outside-right {
    flex-direction: row;
    margin-top: 20px;
  }
}
</style>
