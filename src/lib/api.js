import axios from 'axios'

export const API_BASE_URL = 'http://localhost:8000/api'
export const BEARER_TOKEN = '78|bIkkVrh5radkhH3B9N3CJNbHmiNuyV64G10LspIMbbc76484'

// Axios instance with token
export const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    Authorization: `Bearer ${BEARER_TOKEN}`,
  },
})
