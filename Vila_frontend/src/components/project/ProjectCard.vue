<template>
  <div class="project-card">
    <!-- Image section -->
    <div class="image-wrapper">
      <img :src="imagePreview" :alt="projectName" />
    </div>

    <!-- Bottom section -->
    <div class="bottom-section">
      <p class="project-name">{{ projectName }}</p>
      <p class="description">{{ description }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

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
    default: null
  }
})

// Compute the full URL of the image
const imagePreview = computed(() => {
  if (!props.image) return ''
  return typeof props.image === 'string'
    ? props.image
    : URL.createObjectURL(props.image)
})
</script>

<style scoped>
.project-card {
  width: 100%;
  max-width: 288px;
  max-height: 494px;
  background-color: var(--color-bg, #fff);
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
  width: 100%;
  height: 329px;
  overflow: hidden;
}

.image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* Bottom section */
.bottom-section {
  background-color: var(--color-primary, #3b82f6);
  color: var(--color-bg, #fff);
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
