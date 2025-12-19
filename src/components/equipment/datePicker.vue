<template>
  <div>
    <h3>{{ label }}</h3>
    <v-date-picker
      :model-value="modelValue"
      @update:model-value="$emit('update:modelValue', $event)"
    />
  </div>
</template>

<script setup>

const props = defineProps({
  label: String,
  modelValue: [String, Date, Object, null]
})

const emit = defineEmits(['update:modelValue'])
</script>
