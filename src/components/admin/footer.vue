<template>
  <footer class="dashboard-footer">
    <div class="footer-content">
      <div class="footer-left">
        <div class="admin-info">
          <div class="admin-name">{{ admin.name }}</div>
          <div class="admin-email">{{ admin.email }}</div>
        </div>
      </div>
      <div class="footer-right">
        <div class="footer-links">
          <a href="#" class="footer-link">Privacy Policy</a>
          <a href="#" class="footer-link">Terms of Service</a>
          <a href="#" class="footer-link">Support</a>
        </div>
        <div class="copyright">
          © 2024 Viliab. All rights reserved.
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
const admin = {
  name: 'Admin User',
  email: 'admin@viliab.com'
}
</script>

<style scoped>
.dashboard-footer {
  margin-top: 3rem;
  padding: 1.5rem 0;
  border-top: 1px solid #e5e7eb;
}

.dark-mode .dashboard-footer {
  border-color: #374151;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.admin-info {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.admin-name {
  font-weight: 600;
}

.admin-email {
  font-size: 0.875rem;
  color: #6b7280;
}

.dark-mode .admin-email {
  color: #9ca3af;
}

.footer-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 0.5rem;
}

.footer-links {
  display: flex;
  gap: 1.5rem;
}

.footer-link {
  color: #6b7280;
  text-decoration: none;
  font-size: 0.875rem;
  transition: color 0.2s;
}

.dark-mode .footer-link {
  color: #9ca3af;
}

.footer-link:hover {
  color: #4f46e5;
}

.copyright {
  font-size: 0.75rem;
  color: #9ca3af;
}
</style>