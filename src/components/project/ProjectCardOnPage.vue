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
      
      <!-- Tags section -->
      <div class="tags-container" v-if="tags && tags.length">
        <span class="tag" v-for="(tag, index) in tags" :key="index">
          {{ tag }}<span v-if="index < tags.length - 1" class="separator">, </span>
        </span>
      </div>
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
    required: true
  },
  tags: {
    type: Array,
    default: () => []
  }
})

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
  height: 100%;
  max-width: 380px; 
  background-color: transparent; 
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease;
}

.project-card:hover {
  transform: translateY(-8px);
}

/* Image wrapper */
.image-wrapper {
  position: relative;
  width: 100%;
  aspect-ratio: 16/10; 
  overflow: hidden;
  background-color: var(--color-secondary); /* Placeholder matches light blue theme */
  border-radius: 20px; /* Rounded corners on the image only */
  margin-bottom: 0; 
}

.image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Bottom section */
.bottom-section {
  padding: 16px 0 0 0; /* Top padding only, align text to left edge */
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.project-name {
  font-weight: 700; /* h4 or bold */
  font-size: 20px;
  margin: 0;
  text-align: left;
  color: var(--color-text);
}

.description {
  font-size: 16px;
  line-height: 1.5;
  text-align: left;
  margin: 0;
  color: var(--color-text);
  font-weight: 400;
}

.tags-container {
  display: flex;
  align-items: center;
  flex-wrap: wrap; /* Allow tags to wrap */
  gap: 4px; /* Reduced gap since we have commas */
  margin-top: 4px;
}

.separator {
  color: var(--color-text); /* Standard text color for comma */
}

.tag {
    font-size: 14px;
    font-weight: 500;
    color: var(--color-primary); /* Blue text for tags */
}
</style>