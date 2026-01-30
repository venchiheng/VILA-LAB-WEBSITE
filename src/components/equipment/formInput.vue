<template>
  <form>
    <!-- Row 1 -->
    <!-- <div class="form-row">
      <div class="form-group">
        <input
          type="text"
          :value="fullName"
          @input="$emit('update:fullName', $event.target.value)"
          placeholder="Enter your full name"
          class="input-field"
        />
      </div>

      <div class="form-group">
        <input
          type="text"
          :value="memberId"
          @input="$emit('update:memberId', $event.target.value)"
          placeholder="Enter your member ID"
          class="input-field"
        />
      </div>
    </div> -->

    <!-- Row 2 -->
    <div class="form-row">
      <div class="form-group full-width">
        <textarea
          :value="purpose"
          @input="$emit('update:purpose', $event.target.value)"
          placeholder="Enter your purpose"
          class="textarea-field"
        ></textarea>
      </div>
    </div>
  </form>
</template>

<script setup>
const props = defineProps({
  fullName: String,
  memberId: String,
  purpose: String
})

const emit = defineEmits(['update:fullName', 'update:memberId', 'update:purpose'])
</script>

<style scoped>
.form-row {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
  flex-wrap: wrap;
}

.form-group {
  flex: 1;
  min-width: 200px;
  display: flex;
  flex-direction: column;
}

.full-width {
  flex: 1 1 100%;
}

.input-field,
.textarea-field {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 0.75rem;
  border: 1px solid #ccc;
  font-size: 1rem;
  outline: none;
  transition: border 0.2s;
}

.input-field:focus,
.textarea-field:focus {
  border-color: #3b82f6; /* blue focus */
}

.textarea-field {
  min-height: 120px;
  resize: vertical;
}
</style>
