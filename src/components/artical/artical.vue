<template>
  <div class="article-card">
    <div class="image-container" :style="{ backgroundColor: image ? 'transparent' : 'var(--color-secondary)' }">
      <img v-if="image" :src="image" :alt="title" class="article-image" />
    </div>
    
    <div class="content">
      <h3 class="title">{{ title }}</h3>
      
      <p class="description">
        {{ description }}
      </p>
      
      <div class="tags">
        <span v-for="(tag, index) in tagsList" :key="index">
          {{ tag }}<span v-if="index < tagsList.length - 1">, </span>
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  image: {
    type: String,
    default: ''
  },
  title: {
    type: String,
    required: true,
    default: 'Project Title'
  },
  description: {
    type: String,
    default: 'Project description goes here.'
  },
  tags: {
    type: [Array, String],
    default: () => []
  }
})

const tagsList = computed(() => {
  if (Array.isArray(props.tags)) return props.tags
  if (typeof props.tags === 'string') return props.tags.split(',').map(tag => tag.trim())
  return []
})
</script>

<style scoped>
.article-card {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 16px;
  border-radius: 16px; /* Rounded card implicit in modern designs, though image handles top */
  /* background-color: var(--color-bg); Optional: if card needs background */
}

.image-container {
  width: 100%;
  aspect-ratio: 4/3; /* Standard card image ratio, adjust if needed */
  border-radius: 16px;
  overflow: hidden;
  background-color: var(--color-secondary);
  display: flex;
  justify-content: center;
  align-items: center;
}

.article-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.content {
  display: flex;
  flex-direction: column;
  gap: 8px;
  text-align: left;
  align-items: flex-start;
}

.title {
  font-size: 16px; /* Matches h3 in style.css */
  font-weight: 500;
  color: var(--color-text);
  line-height: 120%;
  margin: 0;
}

.description {
  font-size: 13px; /* Matches p in style.css */
  font-weight: 400;
  color: var(--color-text);
  line-height: 1.5; /* Default line-height from root, p in css snippet didn't specify line-height but root is 1.5 */
  margin: 0;
}

.tags {
  margin-top: 8px;
  font-size: 13px; /* Matches span in style.css */
  font-weight: 400;
  color: var(--color-primary);
}
</style>
