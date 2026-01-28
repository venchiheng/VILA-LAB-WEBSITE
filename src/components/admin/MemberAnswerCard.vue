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

    <!-- Accept / Reject Buttons -->
    <div class="action-buttons" v-if="!application.status">
      <button @click="markApplication('approve')" class="accept-btn">Accept</button>
      <button @click="markApplication('reject')" class="reject-btn">Reject</button>
    </div>

    <div class="status-label" v-else>
      Status: <span :class="application.status">{{ application.status }}</span>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';

defineProps({
  application: Object
});

const markApplication = async (action) => {
  try {
    // Use the exact API URL
    const url = `http://localhost:8000/api/membership-applications/${application.id}/${action}`;
    await axios.put(url);

    // Update local status immediately for UI
    application.status = action === 'approve' ? 'Accepted' : 'Rejected';
    alert(`Application ${application.status.toLowerCase()} successfully!`);
  } catch (err) {
    console.error(err);
    alert('Something went wrong. Please try again.');
  }
};
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

.action-buttons {
  margin-top: 1rem;
  display: flex;
  gap: 0.5rem;
}

.accept-btn {
  background-color: #22c55e;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
}

.reject-btn {
  background-color: #ef4444;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
}

.accept-btn:hover {
  background-color: #16a34a;
}

.reject-btn:hover {
  background-color: #dc2626;
}

.status-label {
  margin-top: 1rem;
  font-weight: 500;
}

.status-label .Accepted {
  color: #22c55e;
}

.status-label .Rejected {
  color: #ef4444;
}
</style>
