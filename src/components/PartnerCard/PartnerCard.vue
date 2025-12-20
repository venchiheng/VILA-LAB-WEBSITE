<template>
  <div class="circle-logo" @click="triggerUpload">
    <input
      ref="fileInput"
      type="file"
      accept="image/*"
      class="hidden-input"
      @change="onFileChange"
    />

    <v-img
      v-if="imagePreview"
      :src="imagePreview"
      contain
      class="logo-img"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  image: {
    type: [String, Object],
    default: ''
  }
})

const emit = defineEmits(['update:image'])

const fileInput = ref(null)

const imagePreview = computed(() => {
  if (!props.image) return ''
  return typeof props.image === 'string'
    ? props.image
    : URL.createObjectURL(props.image)
})

const triggerUpload = () => {
  fileInput.value.click()
}

const onFileChange = (e) => {
  const file = e.target.files[0]
  if (file) emit('update:image', file)
}
</script>

<style scoped>
.circle-logo {
  width: 200px;
  height: 200px;
  background: var(--color-secondary);
  border-radius: 50%;
  padding: 20px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.circle-logo:hover {
  transform: scale(1.08);
}

.logo-img {
  max-width: 85%;
  max-height: 85%;
}

.placeholder-text {
  font-weight: 600;
  color: #222;
  text-align: center;
}

.hidden-input {
  display: none;
}

/* Mobile */
@media (max-width: 600px) {
  .circle-logo {
    width: 140px;
    height: 140px;
  }
}
</style>
