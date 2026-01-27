import axios from 'axios'

export const API_BASE_URL = 'http://localhost:8000/api'
export const BEARER_TOKEN = '84|JIG4Y9fXJD0486L7pdB4YBKPeWIR0sUahHUkgnX25c211c0a'

// Axios instance with token
export const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    Authorization: `Bearer ${BEARER_TOKEN}`,
  },
})
