<!-- src/components/PartnerCard/PartnerCard.vue -->
<template>
  <div class="partner-card">
    <div class="circle-logo" :style="logoStyle">
      <v-img
        v-if="imagePreview"
        :src="imagePreview"
        class="logo-img"
        :contain="fit === 'contain'"
        :cover="fit === 'cover'"
      />
    </div>

    <div class="partner-info">
      <h3 v-if="name" class="partner-name">{{ name }}</h3>
      <p v-if="title" class="partner-title">{{ title }}</p>

      <a
        v-if="link"
        :href="link"
        target="_blank"
        class="partner-link"
        rel="noopener"
      >
        {{ linkText }}
      </a>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  image: {
    type: [String, File, Blob],
    default: null
  },
  name: {
    type: String,
    default: ''
  },
  title: {
    type: String,
    default: ''
  },
  link: {
    type: String,
    default: ''
  },
  linkText: {
    type: String,
    default: 'Visit'
  },
  size: {
    type: Number,
    default: 180
  },
  fit: {
    type: String,
    default: 'cover' // cover | contain
  }
})

const imagePreview = computed(() => {
  if (!props.image) return ''
  return typeof props.image === 'string'
    ? props.image
    : URL.createObjectURL(props.image)
})

const logoStyle = computed(() => ({
  width: `${props.size}px`,
  height: `${props.size}px`
}))
</script>

<style scoped>
.partner-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.circle-logo {
  border-radius: 50%;
  background-color: var(--color-bg);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  transition: transform 0.3s ease;
  margin-bottom: 12px;
}

.circle-logo:hover {
  transform: scale(1.08);
}

.logo-img {
  width: 100%;
  height: 100%;
}

.partner-name {
  font-weight: 600;
  font-size: 18px;
  margin: 4px 0;
  color: var(--color-text);
}

.partner-title {
  font-size: 14px;
  font-weight: 400;
  color: var(--color-text);
  margin-bottom: 6px;
}

.partner-link {
  font-size: 14px;
  font-weight: 500;
  color: var(--color-primary);
  text-decoration: none;
  transition: color 0.25s;
}

.partner-link:hover {
  color: var(--color-secondary);
  text-decoration: underline;
}
</style>
