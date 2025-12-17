<template>
  <div class="wrapper">
    <h1 style="color: var(--color-primary);">Achievements</h1>

    <v-row>
      <v-col
        v-for="(item, index) in achievements"
        :key="index"
        cols="12"
        md="6"
        lg="4"
      >
        <AchievementCard
          :title="item.title"
          :description="item.description"
          :event="item.event"
          :year="item.year"
          :image="item.image"
          :authors="item.authors"
          :journal="item.journal"
          :pdf="item.pdf"
          :doi="item.doi"
        />
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
import AchievementCard from '@/components/achievement/AchievementCard.vue'

const achievements = [
  {
    title: 'Generative Adversarial Networks for Realistic Image Synthesis',
    description: 'A brief description of the achievement.',
    event: 'Vision Conference',
    year: 2023,
    image: '/src/assets/achievement/achievementcard1.png',
    authors: 'J. Doe, A. Smith, B. Johnson',
    journal: 'Journal of Vision and Learning, 2023',
    pdf: '/files/paper.pdf', // uploaded file path
    doi: 'https://doi.org/10.1234/example'
  },
  // add more achievements here
]
</script>

<style scoped>
.wrapper {
  margin-top: 40px;
  padding-inline: 156px;
  display: flex;
  flex-direction: column;
  gap: 32px;
}
</style>
