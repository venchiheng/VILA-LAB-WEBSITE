<template>
  <div class="project-card">
    <!-- Image section -->
    <div class="image-wrapper">
      <img :src="image" />
    </div>

    <!-- Bottom section -->
    <div class="bottom-section">
      <p class="project-name">{{ projectName }}</p>
      <p class="description">{{ description }}</p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  projectName: {
    type: String,
    required: true
  },
  description: {
    type: String,
    required: true
  },
  image: {
    type: String,
    required: true
  }
})
</script>

<style scoped>
.project-card {
  width: 100%;
  height: 100%;
  max-width: 288px;
  max-height: 494px;
  background-color: var(--color-bg);
  box-shadow: 0 10px 28px rgba(0, 0, 0, 0.12);
  border-radius: 40px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.project-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.18);
}

/* Image wrapper */
.image-wrapper {
  position: relative;
  width: 100%;
  height: 329px;
  overflow: hidden;
}

.image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Bottom section */
.bottom-section {
  background-color: var(--color-primary);
  color: var(--color-bg);
  padding: 20px 24px 24px;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.project-name {
  font-weight: bold;
  margin: 0;
  text-transform: uppercase;
  text-align: left;
}

.description {
  font-size: 13px;
  line-height: 1.5;
  text-align: left;
  margin: 0;
  opacity: 0.95;
}
</style>