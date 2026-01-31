<template>
  <div class="news-card">
    <div class="news-card-content">
      <p class="news-source">{{ source }}</p>
      <h3 class="news-title">{{ title }}</h3>
      <p class="news-date">{{ date }}</p>
      <a :href="link" class="read-more-link">
        Read more
        <v-icon size="small" class="arrow-icon">mdi-arrow-right</v-icon>
      </a>
    </div>
  </div>
</template>

<script setup>
defineProps({
  source: {
    type: String,
    required: true
  },
  title: {
    type: String,
    required: true
  },
  date: {
    type: String,
    required: true
  },
  link: {
    type: String,
    required: true
  }
})
</script>

<style scoped>
.news-card {
  background: var(--color-secondary);
  border-radius: 10px;
  padding: 32px;
  min-height: 175px;
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.news-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.news-card-content {
  display: flex;
  flex-direction: column;
  gap: 12px;
  height: 100%;
}

.news-source {
  font-size: 14px;
  font-weight: 600;
  color: #ACA8B0;
  margin: 0;
  text-transform: uppercase;
  text-align: start;
  letter-spacing: 0.5px;
}

.news-title {
  font-size: 14px;
  font-weight: 600;
  color: var(--color-text);
  line-height: 1.5;
  margin: 0;
  flex-grow: 1;
  text-align: start;
}

.news-date {
  font-size: 14px;
  color: #ACA8B0;
  text-align: start;
  margin: 0;
}

.read-more-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: var(--color-primary);
  font-size: 15px;
  font-weight: 600;
  text-decoration: none;
  margin-top: auto;
  transition: gap 0.2s ease;
}

.read-more-link:hover {
  gap: 10px;
}

.arrow-icon {
  transition: transform 0.2s ease;
}

.read-more-link:hover .arrow-icon {
  transform: translateX(4px);
}

@media (max-width: 640px) {
  .news-card {
    padding: 24px;
  }

  .news-title {
    font-size: 16px;
  }
}
</style>