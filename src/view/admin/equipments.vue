<template>
    <DashboardLayout>
        <template #default>
            <h1 class="text-2xl font-bold mb-4">Admin Home</h1>
            <p>Welcome, {{ auth.user.name }}!</p>
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
