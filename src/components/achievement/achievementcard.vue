<template>
  <div class="achievement-card" :style="cardStyle">
    <img
      v-if="imagePreview"
      :src="imagePreview"
      :alt="alt"
      class="card-image"
      :style="{ objectFit: fit }"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  image: {
    type: [String, File, Blob],
    default: null
  },
  alt: {
    type: String,
    default: 'Achievement image'
  },
  width: {
    type: String,
    default: '100%'
  },
  height: {
    type: String,
    default: '100%'
  },
  fit: {
    type: String,
    default: 'cover' 
  },
  radius: {
    type: String,
    default: '12px'
  }
})

const imagePreview = computed(() => {
  if (!props.image) return ''
  return typeof props.image === 'string'
    ? props.image
    : URL.createObjectURL(props.image)
})

const cardStyle = computed(() => ({
  width: props.width,
  height: props.height,
  borderRadius: props.radius
}))
</script>

<style scoped>
.achievement-card {
  background-color: var(--color-bg);
  border-radius: inherit;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

.card-image {
  width: 100%;
  height: 100%;
  display: block;
}
</style>
