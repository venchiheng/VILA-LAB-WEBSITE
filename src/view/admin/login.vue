<template>
    <v-app>
        <v-main>
            <v-container fluid class="pa-0 fill-height ma-0">
                <v-row no-gutters class="fill-height">

                    <v-col cols="12" md="6" class="d-flex align-center justify-center bg-white">
                        <v-card flat max-width="480" width="100%" class="pa-8 pa-md-12">
                            <div class="text-center">

                                <v-avatar size="120" class="mb-8 user-avatar">
                                    <Icon icon="mdi:account-circle" class="user-avatar-icon" />
                                </v-avatar>

                                <h1 class="text-h4 font-weight-bold mb-3">
                                    Login to your account
                                </h1>
                                <p class="text-body-1 mb-10 text-medium-emphasis">
                                    Enter your detail information
                                </p>

                                <v-form @submit.prevent="handleLogin">
                                    <v-text-field v-model="memberId" variant="outlined" placeholder="Enter your ID"
                                        class="mb-6" hide-details />

                                    <v-text-field v-model="password" variant="outlined" placeholder="Enter password"
                                        type="password" class="mb-8" hide-details />

                                    <v-btn :loading="loading" color="blue" size="large" block rounded="pill"
                                        class="text-capitalize py-6 text-h6" type="submit">
                                        Log in
                                    </v-btn>

                                    <p v-if="error" class="text-red-500 mt-4">{{ error }}</p>
                                </v-form>

                                <p class="text-caption mt-12 text-medium-emphasis">
                                    Copyright © 2025 - VLa Lab
                                </p>
                            </div>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="6" class="d-none d-md-flex justify-center align-center image-side">
                        <div class="image-frame">
                            <v-img :src="holImage" height="100%" width="100%" cover position="center" />
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import { ref, computed } from 'vue'
import holImage from '@/assets/admin/image.png'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

// Form fields
const memberId = ref('')
const password = ref('')

// Reactive state from auth store
const loading = computed(() => auth.loading)
const error = computed(() => auth.error)

// Handle login
const handleLogin = async () => {
    try {
        await auth.login(memberId.value, password.value, router)
        console.log(loginResponse.data.token);
    } catch (err) {
        // error is already handled in the store
    }
}
</script>

<style scoped>
html,
body,
#app {
    height: 100%;
    margin: 0;
}

.user-avatar {
    background-color: var(--color-secondary, #BAD6EB) !important;
}

.user-avatar-icon {
    width: 80px;
    height: 80px;
    color: #1565C0;
}

.image-side {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 16px;
    height: 100%;
}

.image-frame {
    width: 700px;
    height: 684px;
    border-radius: 40px;
    margin-top: 16px;
    overflow: hidden;
}
</style>
