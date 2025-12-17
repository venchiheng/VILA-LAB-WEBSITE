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
        />
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
import AchievementCard from '@/components/achievement/achievementcard.vue'

const achievements = [
  {
    image: '/src/assets/achievement/achievementcard1.png',
  },
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