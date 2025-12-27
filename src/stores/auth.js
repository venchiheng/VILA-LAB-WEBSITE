import { defineStore } from 'pinia'
import { ref } from 'vue'
import { loginApi, logoutApi } from '@/services/auth/api.js'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('token') || null)
  const loginTime = ref(localStorage.getItem('loginTime') || null) 
  const loading = ref(false)
  const error = ref(null)

  const SESSION_DURATION = 30 * 60 * 1000 

  const login = async (memberId, password, router) => {
    loading.value = true
    error.value = null
    try {
      const data = await loginApi(memberId, password)
      user.value = data.user
      token.value = data.user.token
      localStorage.setItem('token', data.user.token)


      loginTime.value = Date.now()
      localStorage.setItem('loginTime', loginTime.value)

      if (router) router.push('/admin/home')
      return data
    } catch (err) {
      error.value = err.response?.data?.message || 'Login failed'
      throw err
    } finally {
      loading.value = false
    }
  }

  const logout = async (router) => {
    try {
      await logoutApi()
    } catch (err) {
      console.error('Logout error:', err)
    } finally {
      user.value = null
      token.value = null
      loginTime.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('loginTime')
      if (router) router.push('/login')
    }
  }

  const isAuthenticated = () => {
    if (!token.value || !loginTime.value) return false
    const now = Date.now()
    return now - loginTime.value < SESSION_DURATION
  }

  return {
    user,
    token,
    loading,
    error,
    login,
    logout,
    isAuthenticated
  }
})
