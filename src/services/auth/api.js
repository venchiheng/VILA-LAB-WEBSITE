import api from '../api.js'

export const loginApi = async (memberId, password) => {
  const response = await api.post('/login', { member_id: memberId, password })
  return response.data
}

export const logoutApi = async () => {
  const response = await api.post('/logout')
  return response.data
}

export const changePasswordApi = async (current_password, new_password, new_password_confirmation) => {
  const response = await api.put('/change-password', { current_password, new_password, new_password_confirmation })
  return response.data
}
