<template>
  <div class="wrapper">
    <div class="container">
      <h1 class="title">Expected Applications</h1>
      <div class="applications-grid">
        <div v-for="(app, index) in applications" :key="index" class="app-card">
          <p class="app-text">{{ app }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const applications = [
  "Khmer OCR Tool",
  "Khmer Text to Speech",
  "Khmer Speech Recognition",
  "Khmer Romanization Tool"
]
</script>

<style scoped>
.wrapper {
  margin-top: 36px; 
  margin-bottom: 80px;
  width: 100%;
  display: flex;
  justify-content: center;
  padding-inline: 24px;
}

.container {
  width: 100%;
  max-width: 1200px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.title {
  font-size: 39px; /* Matches style.css h1 */
  color: var(--color-primary);
  font-weight: 700; /* Matches style.css h1 */
  margin-bottom: 60px;
  text-align: center;
}

.applications-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 32px;
  width: 80%; 
}

.app-card {
  background-color: var(--color-secondary);
  border-radius: 20px;
  padding: 32px 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100px;
  transition: transform 0.2s;
}

.app-card:hover {
  transform: translateY(-2px);
}

.app-text {
  font-size: 16px; /* Matches style.css p */
  font-weight: 400; /* Matches style.css p */
  color: var(--color-text);
  margin: 0;
  text-align: center;
}


@media (max-width: 1024px) {
  .applications-grid {
    width: 100%;
  }
}

@media (max-width: 768px) {
  .applications-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  
  .title {
    font-size: 31px; /* h2 size for mobile if needed, or keep h1 */
    margin-bottom: 40px;
  }
}
</style>
