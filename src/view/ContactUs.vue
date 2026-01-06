<template>
    <div class="test-admin-view">
        <AdminProjects />
    </div>
</template>

<script setup>
import AdminProjects from '@/view/admin/projects.vue';
</script>

<style scoped>
.test-admin-view {
    padding-top: 80px; /* Space for navbar */
    min-height: 100vh;
    background: #f8f9fa;
}
</style>
