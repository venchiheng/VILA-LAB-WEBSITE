import api from '../api.js'

export const getEquipmentListApi = async () => {
  const response = await api.get('/equipment')
  return response.data
}
