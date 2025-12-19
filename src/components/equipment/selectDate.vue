<template>
    <v-dialog v-model="dialog" max-width="50%" persistent>
        <v-card rounded="xl" class="pa-8">
            <div class="d-flex justify-space-between align-center mb-6">
                <h2>Add this item to cart</h2>
                <button
                    style="width: 32px; height: 32px; border-radius: 100px; background: lightgray; display: flex; align-items: center; justify-content: center;"
                    @click="close">
                    <Icon icon="mdi-close" />
                </button>
            </div>

            <FormInput v-if="dialog" v-model:fullName="form.fullName" v-model:memberId="form.memberId"
                v-model:purpose="form.purpose" />

            <div class="mt-6" v-if="dialog">
                <QuantitySelector v-model="form.quantity" />
            </div>

            <v-row class="mt-6" v-if="dialog">
                <v-col cols="12" md="6">
                    <DatePicker label="Select Borrow Date" v-model="form.borrowDate" />
                </v-col>
                <v-col cols="12" md="6">
                    <DatePicker label="Select Return Date" v-model="form.returnDate" />
                </v-col>
            </v-row>

            <div class="d-flex justify-end mt-8" v-if="dialog">
                <button class="sb-btn" @click="confirmBooking">Confirm Booking</button>
            </div>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { reactive, watch, computed } from 'vue'
import FormInput from './formInput.vue'
import QuantitySelector from './quantity-selector.vue'
import DatePicker from './datePicker.vue'
import { Icon } from '@iconify/vue'

const props = defineProps({
    modelValue: Boolean,
    equipment: Object
})

const emit = defineEmits(['update:modelValue', 'confirm'])

const dialog = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
})

const form = reactive({
    fullName: '',
    memberId: '',
    purpose: '',
    quantity: 1,
    borrowDate: null,
    returnDate: null
})

const resetForm = () => {
    form.fullName = ''
    form.memberId = ''
    form.purpose = ''
    form.quantity = 1
    form.borrowDate = null
    form.returnDate = null
}

const close = () => {
    dialog.value = false
}

const confirmBooking = () => {
    console.log('Form submitted:', {
        equipment: props.equipment,
        ...form
    })
    emit('confirm', {
        equipment: props.equipment,
        ...form
    })
    close()
}

watch(
    () => props.modelValue,
    (open) => {
        if (!open) resetForm()
    }
)
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