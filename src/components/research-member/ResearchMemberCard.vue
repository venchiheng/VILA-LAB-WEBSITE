<template>
  <div class="member-card">
    <!-- Image section -->
    <div class="image-wrapper">
      <img :src="image" :alt="name" />

      <!-- Program badge -->
      <div class="program-badge">
        {{ program }}
      </div>
    </div>

    <!-- Content -->
    <div class="info">
      <p class="name">{{ name }}</p>
      <p class="description">{{ description }}</p>

      <button class="explore-btn" @click="onExplore">
        <img
          src="@/assets/icons/ic-baseline-message.png"
          alt="message"
          class="btn-icon"
        />
        <span>Explore more</span>
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  name: {
    type: String,
    required: true
  },
  program: {
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

const emit = defineEmits(['explore'])

const onExplore = () => {
  emit('explore')
}
</script>

<style scoped>
.member-card {
  width: 100%;
  height: 100%;
  max-width: 288px;
  max-height: 494px;
  background-color: var(--color-bg);
  box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
  border-radius: 40px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

/* Image */
.image-wrapper {
  position: relative;
  width: 100%;
  height: 286px;
  overflow: hidden;
}

.image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Program badge (top ribbon style) */
.program-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background-color: var(--color-primary);
  color: var(--color-bg);
  padding: 6px 12px;
  border-radius: 100px;
  font-size: 14px;
  font-weight: 600;
}

/* Content */
.info {
  padding: 16px 18px 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  flex: 1; 
}

.name {
  color: var(--color-text);
  text-align: left;
  font-weight: bold;
}

.description {
  font-size: 12px;
  color: var(--color-text);
  text-align: left;
  letter-spacing: -0.02em;
  line-height: 1.2;
}
/* Button */
.explore-btn {
  margin-top: auto; /* key line */
  align-self: flex-start;
  background-color: var(--color-secondary);
  color: var(--color-text);
  padding: 6px 15px;
  border-radius: 100px;
  font-size: 14px;
  font-weight: bold;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: background-color 0.2s ease;
}

.btn-icon {
  width: 20px;
  height: 20px;
  object-fit: contain;
}

.explore-btn:hover {
  background-color: var(--color-primary);
  color: var(--color-bg);
}
</style>
