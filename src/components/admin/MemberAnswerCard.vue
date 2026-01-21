<template>
  <div class="answer-card">
    <h3 class="name">{{ application.full_name }}</h3>

    <div class="answer-row" v-if="application.motivation">
      <span class="label">Motivation:</span>
      <span class="value">{{ application.motivation }}</span>
    </div>

    <div class="answer-row" v-if="application.time_management">
      <span class="label">Time Management:</span>
      <span class="value">{{ application.time_management }}</span>
    </div>

    <div class="answer-row" v-if="application.availability">
      <span class="label">Availability:</span>
      <span class="value">{{ application.availability }}</span>
    </div>

    <div class="answer-row" v-if="application.qualification">
      <span class="label">Qualification:</span>
      <span class="value">{{ application.qualification }}</span>
    </div>

    <div class="answer-row" v-if="application.faculty">
      <span class="label">Faculty:</span>
      <span class="value">{{ application.faculty }}</span>
    </div>

    <div class="answer-row" v-if="application.year">
      <span class="label">Year:</span>
      <span class="value">{{ application.year }}</span>
    </div>

    <div class="answer-row" v-if="application.stu_id">
      <span class="label">Student ID:</span>
      <span class="value">{{ application.stu_id }}</span>
    </div>

    <div class="answer-row" v-if="application.cv_path">
      <span class="label">CV:</span>
      <a :href="application.cv_path" target="_blank" class="cv-link">View CV</a>
    </div>

    <div class="answer-row" v-if="application.review_notes">
      <span class="label">Review Notes:</span>
      <span class="value">{{ application.review_notes }}</span>
    </div>
  </div>
</template>

<script setup>
defineProps({
  application: Object
})
</script>

<style scoped>
.answer-card {
  background: #f9fafb;
  border-radius: 0.5rem;
  padding: 1rem;
  margin-bottom: 1rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.name {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.answer-row {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 0.25rem;
}

.label {
  font-weight: 500;
  color: #6b7280;
  min-width: 120px;
}

.value {
  font-weight: 400;
  color: #111827;
}

.cv-link {
  color: #3b82f6;
  text-decoration: underline;
}
</style>
