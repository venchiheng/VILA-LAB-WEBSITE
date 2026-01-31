import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { loginApi, logoutApi } from '@/services/auth/api.js'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user')) || null)
  const token = ref(localStorage.getItem('token') || null)
  const loginTime = ref(Number(localStorage.getItem('loginTime')) || null)
  const loading = ref(false)
  const error = ref(null)

  const SESSION_DURATION = 30 * 60 * 1000 // 30 minutes

  /* ================= LOGIN ================= */
  const login = async (memberId, password, router) => {
    loading.value = true
    error.value = null

    try {
      const data = await loginApi(memberId, password)

      // 🔒 Block non-admin login
      // if (data.user.role !== 'admin') {
      //   throw new Error('Access denied. Admin only.')
      // }
      if (!['admin', 'member'].includes(data.user.role)) {
        throw new Error('Access denied.')
      }

      user.value = data.user
      token.value = data.user.token

      localStorage.setItem('user', JSON.stringify(data.user))
      localStorage.setItem('token', data.user.token)

      loginTime.value = Date.now()
      localStorage.setItem('loginTime', loginTime.value)

      if (router) {
        if (data.user.role === 'admin') {
          router.push('/admin/home')
        } else if (data.user.role === 'researcher') {
          router.push('/equipments')
        }
      }
      return data
    } catch (err) {
      error.value = err.message || err.response?.data?.message || 'Login failed'
      throw err
    } finally {
      loading.value = false
    }
  }

  /* ================= LOGOUT ================= */
  const logout = async (router) => {
    try {
      await logoutApi()
    } catch (err) {
      console.error('Logout error:', err)
    } finally {
      user.value = null
      token.value = null
      loginTime.value = null

      localStorage.removeItem('user')
      localStorage.removeItem('token')
      localStorage.removeItem('loginTime')

      if (router) router.push('/login')
    }
  }

  /* ================= AUTH CHECK ================= */
  const isAuthenticated = () => {
    if (!token.value || !loginTime.value) return false

    const now = Date.now()
    const isValid = now - loginTime.value < SESSION_DURATION

    if (!isValid) {
      logout()
      return false
    }

    return true
  }

  /* ================= ROLE CHECK ================= */
  const isAdmin = computed(() => {
    return user.value?.role === 'admin'
  })

  return {
    user,
    token,
    loading,
    error,
    login,
    logout,
    isAuthenticated,
    isAdmin,
  }
})
