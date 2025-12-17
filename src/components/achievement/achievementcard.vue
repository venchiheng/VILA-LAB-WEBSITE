<template>
  <v-card class="container">
    <v-img
      :src="imagePreview"
      class="image"
      cover
    />

    <div class="content">
      <h2>{{ title }}</h2>

      <p>{{ description }}</p>

      <div class="meta">
        <span>{{ event }}</span>
        <span>{{ year }}</span>
      </div>
    </div>
  </v-card>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  title: String,
  description: String,
  event: String,
  year: String,
  image: [String, File],
})

const imagePreview = ref('')

watch(
  () => props.image,
  (val) => {
    if (!val) return
    imagePreview.value = val instanceof File ? URL.createObjectURL(val) : val
  },
  { immediate: true }
)
</script>

<style scoped>
/* SAME STRUCTURE AS HOL_Card.vue */
.container {
  display: flex;
  flex-direction: row;
  /* width control */
  width: 1128px;
  min-height: 450px;
  border-radius: 40px;
}

/* IMAGE SIZE */
.image {
  width: 100%;
  height: 100%;
  border-radius: 40px;
}

/* CONTENT AREA */
.content {
  display: flex;
  flex-direction: column;
  gap: 16px;
  width: calc(100% - 450px);
}

h2 {
  color: var(--color-primary);
}

.meta {
  margin-top: auto;
  display: flex;
  justify-content: space-between;
  font-size: 14px;
  opacity: 0.7;
}
</style>
