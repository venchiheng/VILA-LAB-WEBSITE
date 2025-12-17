<template>
  <div class="equipment-card">
    <!-- Image section -->
    <div class="image-wrapper">
      <span
        v-if="status"
        class="status-badge"
        :class="statusClass"
      >
        {{ status }}
      </span>

      <img
        :src="image"
        :alt="name"
      />
    </div>

    <!-- Info section -->
    <div class="info">
      <p class="title">{{ name }}</p>
      <p class="spec">{{ specification }}</p>

      <button class="detail-btn" @click="onViewDetail">
        View Detail
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  specification: {
    type: String,
    required: true
  },
  image: {
    type: String,
    required: true
  },
  status: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['view-detail'])

const onViewDetail = () => {
  emit('view-detail')
}

/* Dynamic badge color */
const statusClass = computed(() => {
  return props.status.toLowerCase() === 'available'
    ? 'available'
    : 'booked'
})
</script>

<style scoped>
.equipment-card {
  width: 100%;
  max-width: 360px;
  background-color: var(--color-bg);
  /* box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08); */
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
}

@media (max-width: 640px) {
  .equipment-card {
    border-radius: 28px;
  }
}

.image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Status badge */
.status-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  padding: 6px 16px;
  border-radius: 999px;
  font-size: 13px;
  font-weight: 500;
  color: var(--color-bg);
}

.status-badge.available {
  background-color: var(--color-success);
}

.status-badge.booked {
  background-color: var(--color-warning);
}

/* Info section */
.info {
  margin-top: 12px;
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.title {
  color: var(--color-text);
  text-align: left;
}

.spec {
  font-size: 14px;
  color: #6b7280;
  text-align: left;
}

/* Button */
.detail-btn {
  position:absolute;
  margin-top: 5px;
  align-self: flex-end;
  background-color: var(--color-primary);
  color: var(--color-bg);
  border: none;
  border-radius: 100px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.detail-btn:hover {
  background-color: #747bff;
}
</style>
