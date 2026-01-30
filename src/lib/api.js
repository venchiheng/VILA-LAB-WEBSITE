// import axios from 'axios'

// export const API_BASE_URL = 'http://localhost:8000/api'
// export const BEARER_TOKEN = '20|sJG3a5anMvi5O2WEyJcnmsxjlU29gEeUkVi6PRZn1b7ebb4a'

// // Axios instance with token
// export const api = axios.create({
//   baseURL: API_BASE_URL,
//   headers: {
//     Authorization: `Bearer ${BEARER_TOKEN}`,
//   },
// })
import axios from 'axios'
import { useAuthStore } from '../stores/auth'

export const api = axios.create({
  baseURL: 'http://localhost:8000/api',
})

api.interceptors.request.use((config) => {
  const auth = useAuthStore()
  if (auth.token) {
    config.headers.Authorization = `Bearer ${auth.token}`
  }
  return config
})