<template>
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-content" :class="{ 'is-loading': loading }">
      <!-- Fixed Header -->
      <div class="modal-header">
        <div class="header-title">
          <h2>{{ project ? 'Edit Project' : 'Add New Project' }}</h2>
          <div class="title-line"></div>
        </div>
        <button class="close-btn" @click="$emit('close')" aria-label="Close modal">
          <Icon icon="mdi:close" />
        </button>
      </div>

      <!-- Scrollable Body -->
      <div class="form-body custom-scrollbar">
        <form id="projectForm" @submit.prevent="save">
          <div class="form-section">
            <div class="form-group">
              <label for="title">Project Title</label>
              <input 
                id="title"
                v-model="form.title" 
                type="text" 
                placeholder="Ex: Autonomous Drone Navigation" 
                required 
                :disabled="loading"
              />
            </div>

            <div class="form-group">
              <label for="category">Category</label>
              <div class="select-wrapper">
                <select id="category" v-model="form.category" required :disabled="loading">
                  <option value="" disabled>Select a research area</option>
                  <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
                <Icon icon="mdi:chevron-down" class="select-icon" />
              </div>
            </div>

            <div class="form-group">
              <div class="label-with-count">
                <label for="description">Description</label>
                <span class="char-count" :class="{ 'limit': form.description.length > 500 }">
                  {{ form.description.length }}/500
                </span>
              </div>
              <textarea 
                id="description"
                v-model="form.description" 
                rows="4" 
                placeholder="Briefly describe the research objectives and impact..." 
                required
                :disabled="loading"
                maxlength="500"
              ></textarea>
            </div>

            <div class="form-group">
              <label>Tags</label>
              <div class="tags-input-wrapper" :class="{ 'focused': tagInputFocused }">
                <div class="tag-chips">
                  <span v-for="(tag, index) in form.tags" :key="index" class="tag-chip">
                    {{ tag }}
                    <Icon icon="mdi:close" @click="removeTag(index)" class="remove-tag" />
                  </span>
                </div>
                <input 
                  type="text" 
                  v-model="tagInput" 
                  @keydown.enter.prevent="addTag" 
                  @focus="tagInputFocused = true"
                  @blur="tagInputFocused = false"
                  placeholder="Type tag and press Enter"
                  :disabled="loading"
                />
                <button 
                  type="button" 
                  class="add-tag-btn" 
                  @click="addTag" 
                  v-if="tagInput.trim()"
                  title="Add tag"
                >
                  <Icon icon="mdi:plus" />
                </button>
              </div>
            </div>

            <div class="form-group">
              <label for="imageUrl">Project Image URL</label>
              <div class="image-input-group">
                <input 
                  id="imageUrl"
                  v-model="form.image" 
                  type="text" 
                  placeholder="https://example.com/image.jpg" 
                  :disabled="loading"
                />
                <div class="image-preview-container" v-if="form.image">
                  <div class="preview-overlay">
                    <Icon icon="mdi:eye-outline" /> Preview
                  </div>
                  <img :src="form.image" alt="Project Preview" @error="handleImageError" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Fixed Footer -->
      <div class="modal-footer">
        <button type="button" class="cancel-btn" @click="$emit('close')" :disabled="loading">
          Cancel
        </button>
        <button 
          type="submit" 
          form="projectForm" 
          class="save-btn" 
          :disabled="loading || !isFormValid"
        >
          <Icon v-if="loading" icon="mdi:loading" class="animate-spin" />
          {{ loading ? 'Saving...' : (project ? 'Update Project' : 'Create Project') }}
        </button>
      </div>

      <!-- Loading Overlay -->
      <div v-if="loading" class="loading-state-overlay"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';

const props = defineProps({
  project: {
    type: Object,
    default: null
  },
  loading: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['close', 'save']);

const categories = ["Artificial Intelligence", "Computer Vision", "Data Science", "NLP"];
const tagInput = ref('');
const tagInputFocused = ref(false);

const form = ref({
  title: '',
  category: '',
  description: '',
  tags: [],
  image: ''
});

const isFormValid = computed(() => {
  return form.value.title && form.value.category && form.value.description;
});

onMounted(() => {
  if (props.project) {
    form.value = { 
      ...props.project, 
      tags: props.project.tags ? [...props.project.tags] : [],
      description: props.project.description || ''
    };
  }
});

const addTag = () => {
  const tag = tagInput.value.trim();
  if (tag && !form.value.tags.includes(tag)) {
    form.value.tags.push(tag);
    tagInput.value = '';
  }
};

const removeTag = (index) => {
  form.value.tags.splice(index, 1);
};

const handleImageError = (e) => {
  // Silent fail or set a placeholder
  e.target.src = 'https://via.placeholder.com/400x250?text=Invalid+Image+URL';
};

const save = () => {
  if (isFormValid.value) {
    emit('save', { ...form.value });
  }
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  backdrop-filter: blur(12px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
  padding: 20px;
}

.modal-content {
  background: var(--color-bg);
  width: 100%;
  max-width: 650px;
  max-height: 85vh; /* Slightly smaller to ensure it doesn't hit edges */
  border-radius: 28px;
  display: flex;
  flex-direction: column;
  position: relative;
  overflow: hidden; /* Important to contain the fixed header/footer rounded corners */
  box-shadow: 0 40px 100px rgba(0, 73, 175, 0.2);
  border: 1px solid rgba(186, 214, 235, 0.5); /* var(--color-secondary) with opacity */
  animation: modalEnter 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  text-align: left;
}

@keyframes modalEnter {
  from { opacity: 0; transform: translateY(30px) scale(0.98); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

/* Fixed Header */
.modal-header {
  padding: 28px 40px;
  background: var(--color-bg);
  border-bottom: 1px solid var(--color-secondary);
  display: flex;
  justify-content: space-between;
  align-items: center;
  z-index: 10;
}

.header-title h2 {
  margin: 0;
  font-size: 28px;
  font-weight: 800;
  color: var(--color-text);
  letter-spacing: -0.5px;
}

.title-line {
  width: 40px;
  height: 4px;
  background: var(--color-primary);
  border-radius: 2px;
  margin-top: 4px;
}

.close-btn {
  background: var(--color-secondary);
  border: none;
  color: var(--color-primary);
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.close-btn:hover {
  background: var(--color-error);
  color: white;
  transform: rotate(90deg);
}

/* Scrollable Body */
.form-body {
  flex: 1;
  overflow-y: auto;
  padding: 40px;
  background: linear-gradient(to bottom, var(--color-bg), #fcfdff);
}

.form-section {
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.form-group label {
  font-weight: 700;
  font-size: 15px;
  color: var(--color-text);
  margin-left: 4px;
}

.label-with-count {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.char-count {
  font-size: 12px;
  font-weight: 600;
  color: #999;
}

.char-count.limit {
  color: var(--color-error);
}

/* Inputs Styling */
input, select, textarea {
  padding: 16px 20px;
  border-radius: 16px;
  border: 1.5px solid var(--color-secondary);
  font-family: inherit;
  font-size: 16px;
  color: var(--color-text);
  background: white;
  transition: all 0.25s ease;
}

input:focus, select:focus, textarea:focus {
  outline: none;
  border-color: var(--color-primary);
  box-shadow: 0 0 0 5px rgba(0, 73, 175, 0.1);
  background: white;
}

input::placeholder, textarea::placeholder {
  color: #bbb;
}

/* Custom Select */
.select-wrapper {
  position: relative;
}

.select-wrapper select {
  width: 100%;
  appearance: none;
  cursor: pointer;
}

.select-icon {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--color-primary);
  pointer-events: none;
  font-size: 24px;
}

/* Tags Input */
.tags-input-wrapper {
  border: 1.5px solid var(--color-secondary);
  border-radius: 16px;
  padding: 8px 12px;
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  background: white;
  transition: all 0.25s ease;
}

.tags-input-wrapper.focused {
  border-color: var(--color-primary);
  box-shadow: 0 0 0 5px rgba(0, 73, 175, 0.1);
}

.tag-chips {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.tag-chip {
  background: var(--color-primary);
  color: white;
  padding: 8px 14px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  animation: tagScale 0.2s ease-out;
}

@keyframes tagScale {
  from { transform: scale(0.8); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

.remove-tag {
  cursor: pointer;
  font-size: 16px;
  opacity: 0.8;
  transition: opacity 0.2s;
}

.remove-tag:hover {
  opacity: 1;
}

.tags-input-wrapper input {
  border: none;
  padding: 8px;
  flex: 1;
  min-width: 180px;
  background: transparent;
}

.tags-input-wrapper input:focus {
  box-shadow: none;
}

.add-tag-btn {
  background: var(--color-primary);
  color: white;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  cursor: pointer;
  align-self: center;
  transition: all 0.2s;
  animation: fadeInOut 0.3s ease;
}

.add-tag-btn:hover {
  transform: scale(1.1);
  filter: brightness(1.2);
}

@keyframes fadeInOut {
  from { opacity: 0; transform: scale(0.8); }
  to { opacity: 1; transform: scale(1); }
}

/* Image Preview */
.image-input-group {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.image-preview-container {
  width: 100%;
  height: 220px;
  border-radius: 20px;
  overflow: hidden;
  border: 1px solid var(--color-secondary);
  position: relative;
  background: #f0f4f8;
}

.image-preview-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.preview-overlay {
  position: absolute;
  top: 12px;
  right: 12px;
  background: rgba(0, 73, 175, 0.8);
  color: white;
  padding: 6px 14px;
  border-radius: 100px;
  font-size: 12px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 6px;
  z-index: 1;
}

/* Fixed Footer */
.modal-footer {
  padding: 24px 40px;
  background: var(--color-bg);
  border-top: 1px solid var(--color-secondary);
  display: flex;
  justify-content: flex-end;
  gap: 16px;
  z-index: 10;
}

.cancel-btn {
  background: #f0f3f7;
  color: #555;
  padding: 14px 28px;
  border-radius: 100px;
  font-weight: 600;
  transition: all 0.2s;
}

.cancel-btn:hover {
  background: #e2e7ee;
  color: var(--color-text);
}

.save-btn {
  background: var(--color-primary);
  color: white;
  padding: 14px 36px;
  border-radius: 100px;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 10px;
  box-shadow: 0 10px 20px rgba(0, 73, 175, 0.2);
}

.save-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 15px 30px rgba(0, 73, 175, 0.3);
}

.save-btn:active:not(:disabled) {
  transform: translateY(0);
}

.save-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  box-shadow: none;
}

.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
  width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: var(--color-secondary);
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: var(--color-primary);
  opacity: 0.5;
}

/* Loading Overlay */
.loading-state-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5);
  z-index: 15;
  cursor: wait;
}

/* Responsiveness */
@media (max-width: 640px) {
  .modal-overlay {
    padding: 0;
  }
  
  .modal-content {
    max-height: 100vh;
    border-radius: 0;
    height: 100%;
  }
  
  .modal-header, .form-body, .modal-footer {
    padding: 24px;
  }
  
  .header-title h2 {
    font-size: 24px;
  }
  
  .save-btn, .cancel-btn {
    flex: 1;
    justify-content: center;
  }
}
</style>


