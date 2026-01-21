import axios from 'axios'

export const API_BASE_URL = 'http://localhost:8000/api'
export const BEARER_TOKEN = '4|pUv7cU4DrNSgGZFZZNtcbUs3jHzW5hzdrqkGAY6Uba86c328'

// Axios instance with token
export const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    Authorization: `Bearer ${BEARER_TOKEN}`,
  },
})
