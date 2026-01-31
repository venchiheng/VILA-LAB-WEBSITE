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
                  Member Login
                </h1>
                <p class="text-body-1 mb-10 text-medium-emphasis">
                  Enter your credentials to book equipment
                </p>

                <v-form @submit.prevent="handleLogin">
                  <v-text-field v-model="memberId" variant="outlined" placeholder="Member ID"
                    class="mb-6" hide-details />

                  <v-text-field v-model="password" variant="outlined" placeholder="Password"
                    type="password" class="mb-8" hide-details />

                  <v-btn :loading="loading" style="background-color: var(--color-primary); color: var(--color-bg);" size="large" block rounded="pill" 
                    class="text-capitalize py-6 text-h6" type="submit">
                    Log in
                  </v-btn>

                  <p v-if="error" class="text-red-500 mt-4">{{ error }}</p>
                </v-form>

              </div>
            </v-card>
          </v-col>

          <v-col cols="12" md="6" class="d-none d-md-flex justify-center align-center image-side">
            <div class="image-frame">
              <img src="/src/assets/login.png" alt="Login Image" style="width: 70%; height: auto;"/>
            </div>
          </v-col>
        </v-row>
        <button style="color: gray;" @click="goToAdmin">Log in as Admin?</button>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

const memberId = ref('')
const password = ref('')
const loading = computed(() => auth.loading)
const error = computed(() => auth.error)

const handleLogin = async () => {
  try {
    const loginResponse = await auth.login(memberId.value, password.value, { role: 'member' && 'admin'})
    console.log('Token:', loginResponse.token) // ensure token exists

    // Now navigate
    await router.push('/equipments')
  } catch (err) {
    console.error(err)
  }
}
const goToAdmin = () => {
  router.push('/admin/login')
}
</script>
