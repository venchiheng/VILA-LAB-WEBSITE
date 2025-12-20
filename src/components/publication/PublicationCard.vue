<template>
  <div class="publication-card">
    <h4 class="title">{{ title }}</h4>

    <p class="authors">{{ authors }}</p>

    <p class="journal">
      {{ journal }}, {{ year }}
    </p>

    <div class="links">
      <!-- DOI -->
      <span class="link" @click="triggerUpload('doi')">
        DOI
      </span>

      <!-- PDF -->
      <span class="link" @click="triggerUpload('pdf')">
        PDF
      </span>

      <!-- Extra DOI -->
      <span class="link" @click="triggerUpload('doi2')">
        DOI
      </span>

      <!-- hidden input -->
      <input
        ref="fileInput"
        type="file"
        class="hidden-input"
        @change="handleFileUpload"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  title: String,
  authors: String,
  journal: String,
  year: Number
})

const emit = defineEmits(['upload'])

const fileInput = ref(null)
const uploadType = ref(null)

const triggerUpload = (type) => {
  uploadType.value = type
  fileInput.value.click()
}

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (!file) return

  emit('upload', {
    type: uploadType.value,
    file
  })

  event.target.value = ''
}
</script>

<style scoped>
.publication-card {
  background-color: var(--color-secondary);
  border-radius: 10px;
  width: 100%;
  height: 100%;
  max-width: 1128px;
  max-height: 175px;
  padding: 20px 25px;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.title {
  font-weight: bold;
  color: var(--color-text);
  text-align: left;
}

.authors {
  color: var(--color-text);
  text-align: left;
}

.journal {
  text-align: left;
  color: var(--color-text);
}

.links {
  margin-top: 8px;
  display: flex;
  gap: 16px;
}

.link {
  font-weight: bold;
  color: var(--color-primary);
  cursor: pointer;
}

.link:hover {
  text-decoration: underline;
}

.hidden-input {
  display: none;
}
</style>
