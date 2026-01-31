import { defineStore } from 'pinia'
import axios from 'axios'

export const useContactMessageStore = defineStore('contactMessage', {
    state: () => ({
        messages: []
    }),
    actions: {
        async postMessage(data) {
            try {
                const response = await axios.post('https://52.87.185.116:8000/api/contact-messages', {
                    name: data.message_fullname,
                    email: data.message_email,
                    phone_number: data.message_phNum,
                    message: data.message_detail
                })
                return response.data
            } catch (error) {
                console.error('Failed to post contact message:', error)
                throw error
            }
        },
        async fetchMessages() {
            try {
                const response = await axios.get('https://52.87.185.116:8000/api/contact-messages')
                this.messages = response.data
            } catch (error) {
                console.error('Failed to fetch contact messages:', error)
            }
        }
    }
})
