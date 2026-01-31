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
    <div class="action-buttons" v-if="application.status === 'pending' || !application.status">
      <button @click="handleAction('approve')" class="accept-btn">Approve</button>
      <button @click="handleAction('reject')" class="reject-btn">Reject</button>
    </div>

    <div class="status-label" v-else>
      Status: <span :class="application.status">{{ application.status }}</span>
    </div>
  </div>
</template>

<script setup>
// import { api } from '@/lib/api.js'
import api from '../../services/api'

const props = defineProps({
  application: Object
})

const handleAction = async (action) => {
  const app = props.application

  // Get rejection notes BEFORE async call
  let reviewNotes = ''
  if (action === 'reject') {
    reviewNotes = prompt('Please enter rejection notes (optional):') || ''
  }

  try {
    const url = `http://44.223.137.10:8000/api/membership-applications/${app.id}/${action}`
    const payload = action === 'reject' ? { review_notes: reviewNotes } : {}

    await api.put(url, payload)

    // Update local status immediately
    if (action === 'approve') {
      app.status = 'approved'
      app.reviewed_by = 'Admin'
    } else {
      app.status = 'rejected'
      app.review_notes = reviewNotes
      app.reviewed_by = 'Admin'
    }

    alert(`Application ${app.status.toLowerCase()} successfully!`)

    // Open email client immediately
    const subject = encodeURIComponent(
      action === 'approve'
        ? 'Congratulations on Membership Approval'
        : 'Membership Application Update'
    )

    const body = encodeURIComponent(
      action === 'approve'
        ? `Dear ${app.full_name},\n\nCongratulations! Your membership application has been approved. Welcome to ViLa Lab! The Orientation Session details will be sent to you shortly.\n\nBest regards,\nViLa Lab Team`
        : `Dear ${app.full_name},\n\nWe regret to inform you that your membership application has been rejected.\n\nNotes: ${reviewNotes || 'N/A'}\n\nThank you for your interest in ViLa Lab.\n\nBest regards,\nViLa Lab Team`
    )

    window.open(`mailto:${app.email}?subject=${subject}&body=${body}`, '_blank')

  } catch (err) {
    console.error(err)
    alert('Something went wrong. Please try again.')
  }
}

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

.status-label .approved {
  color: #22c55e;
}

.status-label .rejected {
  color: #ef4444;
}
</style>
