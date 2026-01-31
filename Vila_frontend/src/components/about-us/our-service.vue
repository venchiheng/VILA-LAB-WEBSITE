<template>
  <section class="our-service-section">
    <div class="container">
      <h1 class="section-title">Our Service</h1>
      
      <div class="services-grid">
        <div v-for="(service, index) in services" :key="index" class="service-card">
          <div class="image-wrapper">
            <img :src="service.image" :alt="service.title" />
          </div>
          <div class="text-content">
            <p>{{ service.title }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  services: {
    type: Array,
    required: true,
    default: () => []
  }
})
</script>

<style scoped>
.our-service-section {
  padding: 40px 24px;
  background-color: var(--color-bg);
  display: flex;
  justify-content: center;
}

.container {
  max-width: 1200px;
  width: 100%;
}

.section-title {
  text-align: center;
  color: var(--color-primary);
  font-size: 39px; /* From style.css h1 */
  font-weight: 700;
  margin-bottom: 60px;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 32px;
}

@media (min-width: 768px) {
  .services-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.service-card {
  display: flex;
  flex-direction: column;
  border-radius: 20px;
  overflow: hidden;
  /* box-shadow? Design shows clean edges, maybe subtle? Left clean for now as per design image which looks flat/clean */
}

.image-wrapper {
  width: 100%;
  aspect-ratio: 4/3; /* Adjust based on image actual ratio */
  background-color: #f0f0f0; /* Placeholder color before load */
}

.image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.text-content {
  background-color: var(--color-secondary);
  padding: 32px 24px;
  flex-grow: 1; /* Ensure equal height text areas if desired */
  display: flex;
  align-items: center; /* Center text vertically if short? Design looks top aligned but padding handles it */
}

.text-content p {
  margin: 0;
  color: var(--color-text);
  font-size: 16px; /* From style.css p */
  font-weight: 400;
  line-height: 1.5;
  text-align: left; /* Based on user preference for left align generally, and visual check */
}
</style>
