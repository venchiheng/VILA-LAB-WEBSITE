<template>
    <v-dialog v-model="dialog" max-width="50%" persistent>
        <v-card rounded="xl" class="pa-4">
            <div class="d-flex justify-space-between align-center mb-6">
                <h2>Add this item to cart</h2>
                <button @click="close">
                    <Icon icon="material-symbols:close-rounded" style="color: black; width: 20px; height: 20px;" />
                </button>
            </div>

            <FormInput v-model:fullName="form.fullName" v-model:memberId="form.memberId"
                v-model:purpose="form.purpose" />

            <QuantitySelector v-model="form.quantity" />

            <v-row>
                <v-col cols="12" md="6">
                    <DatePicker label="Select Borrow Date" v-model="form.borrowDate" />
                </v-col>
                <v-col cols="12" md="6">
                    <DatePicker label="Select Return Date" v-model="form.returnDate" />
                </v-col>
            </v-row>

            <div class="d-flex justify-end mt-8">
                <button class="sb-btn" @click="confirmBooking">Confirm Booking</button>
            </div>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { reactive, computed } from 'vue'
import FormInput from './formInput.vue'
import QuantitySelector from './quantity-selector.vue'
import DatePicker from './datePicker.vue'
import { Icon } from '@iconify/vue'
import api from '../../services/api'
import { useRouter, useRoute } from 'vue-router'
import { ro } from 'vuetify/locale'

const router = useRouter()
const route = useRoute()

const props = defineProps({
    modelValue: Boolean,
    equipment: Object
})

const emit = defineEmits(['update:modelValue', 'confirm'])

const dialog = computed({
    get: () => props.modelValue,
    set: val => emit('update:modelValue', val)
})

const form = reactive({
    fullName: '',
    memberId: '',
    purpose: '',
    quantity: 1,
    borrowDate: null,
    returnDate: null
})

const close = () => (dialog.value = false)

const confirmBooking = async () => {
    if (!props.equipment?.id) {
        alert('Please select equipment before booking!')
        return
    }
    const formatDateAtNineAM = (date) => {
    if (!date) return null
    const d = new Date(date)
    const yyyy = d.getFullYear()
    const mm = String(d.getMonth() + 1).padStart(2, '0')
    const dd = String(d.getDate()).padStart(2, '0')
    
    // Always set time to 09:00:00
    const hh = '09'
    const min = '00'
    const ss = '00'

    return `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss}`
    }


    const payload = {
        equipment_id: props.equipment.id,
        // full_name: form.fullName,
        // member_id: form.memberId,
        purpose: form.purpose,
        quantity: form.quantity,
        booking_date: formatDateAtNineAM(form.borrowDate),
        return_date: formatDateAtNineAM(form.returnDate)
    }

    const res = await api.post('/equipment-bookings', payload)
    emit('confirm', res.data)
    dialog.value = false
    router.push('/equipments/booking')
}
</script>

<style scoped>
.sb-btn {
    width: 100%;
    background-color: var(--color-primary);
    color: white;
    border: none;
    border-radius: 40px;
    padding: 12px 24px;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
}
</style>