<template>
  <div class="stat-card">
    <div class="stat-header">
      <h3 class="stat-title">{{ title }}</h3>
      <div class="stat-change" :class="changeType">
        {{ change }}
      </div>
    </div>
    <div class="stat-content">
      <div class="stat-value">{{ value }}</div>
      <div class="stat-subtext">from {{ from }}</div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  value: String,
  change: String,
  changeType: String,
  from: String
})
</script>

<style scoped>
.stat-card {
  background: white;
  padding: 1.5rem;
  border-radius: 0.75rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
}

.dark-mode .stat-card {
  background: #2d3748;
}

.stat-card:hover {
  transform: translateY(-2px);
}

.stat-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.stat-title {
  font-size: 0.875rem;
  color: #6b7280;
  font-weight: 500;
}

.dark-mode .stat-title {
  color: #9ca3af;
}

.stat-change {
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.25rem 0.5rem;
  border-radius: 9999px;
}

.stat-change.positive {
  background: #d1fae5;
  color: #065f46;
}

.stat-change.negative {
  background: #fee2e2;
  color: #991b1b;
}

.dark-mode .stat-change.positive {
  background: #064e3b;
  color: #a7f3d0;
}

.dark-mode .stat-change.negative {
  background: #7f1d1d;
  color: #fca5a5;
}

.stat-content {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
}

.dark-mode .stat-value {
  color: #f9fafb;
}

.stat-subtext {
  font-size: 0.75rem;
  color: #6b7280;
}

.dark-mode .stat-subtext {
  color: #9ca3af;
}
</style>