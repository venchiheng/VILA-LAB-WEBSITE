import axios from 'axios';

const token = localStorage.getItem('token');

export const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    Authorization: token ? `Bearer ${token}` : '',
    'Content-Type': 'application/json'
  }
});
