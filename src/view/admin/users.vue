<template>
    <DashboardLayout>
        <template #default>
            <h1 class="text-2xl font-bold mb-4">Admin Users</h1>
            <p>Only admins can see this page.</p>
        </template>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '@/components/admin/DashboardLayout.vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
</script>

<route>
{
  "meta": {
    "requiresAuth": true,
    "requiresAdmin": true
  }
}
</route>
