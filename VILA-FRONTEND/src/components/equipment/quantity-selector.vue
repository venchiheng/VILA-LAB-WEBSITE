<template>
    <h4>Quantity</h4>
    <div class="container">
        <button :disabled="quantity <= min" @click="decrease" class="btn">
            <Icon icon="ic:round-minus" />
        </button>

        <h4>{{ quantity }}</h4>

        <button :disabled="quantity >= max" @click="increase" class="btn">
            <Icon icon="ic:round-add" />
        </button>
    </div>
</template>

<script setup>
import { watch, toRef } from 'vue'
import { Icon } from '@iconify/vue'

const props = defineProps({
  modelValue: { type: Number, default: 1 },
  min: { type: Number, default: 1 },
  max: { type: Number, default: 10 }
})

const emit = defineEmits(['update:modelValue'])

// Use a ref tied to modelValue
const quantity = toRef(props, 'modelValue')

const increase = () => {
  if (quantity.value < props.max) {
    emit('update:modelValue', quantity.value + 1)
  }
}

const decrease = () => {
  if (quantity.value > props.min) {
    emit('update:modelValue', quantity.value - 1)
  }
}
</script>


<style scoped>
.container {
    display: flex;
    align-items: center;
    gap: 24px;
    height: 48px;
}

.btn {
    background: lightgray;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 100px;
    padding: 0;
}

.btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}
</style>
