<template>
  <div class="laboratory-card">
    <!-- Image section -->
    <div class="image-wrapper">
      <img
        :src="image"
        :alt="name"
      />
    </div>

    <!-- Info section (optional) -->
    <div class="info" v-if="name">
      <p class="title">{{ name }}</p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  name: {
    type: String,
    default: ''
  },
  image: {
    type: String,
    required: true
  }
})
</script>

<style scoped>
.laboratory-card {
  width: 100%;
  height: 100%;
  max-width: 552px;
  max-height: 356px;
  background-color: var(--color-bg);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

/* Image section */
.image-wrapper {
  position: relative;
  width: 100%;
  aspect-ratio: 15 / 10;
  border-radius: 40px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover effect */
.image-wrapper:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

@media (max-width: 640px) {
  .laboratory-card {
    border-radius: 28px;
  }
}

.image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Info section */
.info {
  margin-top: 12px;
  display: flex;
  flex-direction: column;
}

.title {
  color: var(--color-text);
  text-align: left;
  font-size: 16px;
  font-weight: 500;
}
</style>