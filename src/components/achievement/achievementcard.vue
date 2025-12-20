<template>
<div class="achievement-card">
    <img v-if="image" :src="imagePreview" alt="Achievement" class="card-image" />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  image: { type: [String, Object], default: '' }
})

const imagePreview = computed(() => {
  if (!props.image) return ''
  return typeof props.image === 'string' ? props.image : URL.createObjectURL(props.image)
})
</script>

<style scoped>
.achievement-card {
  width: 100%;
  height: 100%;
  display: flex;
}

.card-image {
  width: 100%;
  height: 100%;
  object-fit: cover; /* or contain, depending on if we want to crop */
  display: block;
}
</style>
