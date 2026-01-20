<template>
  <div class="page">
    <!-- HEADER -->
    <header class="header">
      <h1>Member Registration Form</h1>
      <p style="text-align: left; margin-top: 40px;"> Our lab is committed to providing a supportive environment for undergraduate and master's students to conduct research in Computer Vision and Natural Language Processing. Through mentorship and collaboration, we aim to equip our students with the skills and knowledge needed to become successful researchers and practitioners in these fields. </p> 
      <p style="text-align: left; margin-top: 20px;"> Any interested candidate can apply by filling in the form below: </p>
    </header>

    <form class="form">
      <!-- PERSONAL INFO -->
      <section class="section">
        <div class="section-title">
          <Icon icon="bi:person-arms-up" class="icon" />
          <h2>Your Personal Information</h2>
        </div>
        <p class="section-des">Enter your basic contact and identification details.</p>

        <input v-model="formData.name" placeholder="Enter your name" />
        <span v-if="errors.name" class="error">{{ errors.name }}</span>

        <select v-model="formData.gender">
          <option disabled value="">Select your gender</option>
          <option>male</option>
          <option>female</option>
          <option>Other</option>
        </select>
        <span v-if="errors.gender" class="error">{{ errors.gender }}</span>

        <input v-model="formData.email" placeholder="Enter your email" />
        <span v-if="errors.email" class="error">{{ errors.email }}</span>

        <input v-model="formData.phone" placeholder="Enter your phone number" />
        <span v-if="errors.phone" class="error">{{ errors.phone }}</span>
      </section>

      <!-- ACADEMIC -->
      <section class="section">
        <div class="section-title">
          <Icon icon="tdesign:education-filled" class="icon" />
          <h2>Academic Background</h2>
        </div>
        <p class="section-des">Enter essential qualifications for research member position.</p>


        <input v-model="formData.studentId" placeholder="Enter your ID (e.g. e2025.... )" />
        <span v-if="errors.studentId" class="error">{{ errors.studentId }}</span>

        <input v-model="formData.faculty" placeholder="Enter your faculty / department" />
        <span v-if="errors.faculty" class="error">{{ errors.faculty }}</span>

        <input v-model="formData.year" placeholder="Enter your current year" />
        <span v-if="errors.year" class="error">{{ errors.year }}</span>

        <!-- FILE UPLOAD -->
        <div class="file-upload">
          <span>{{ formData.cv?.name || 'Upload your CV (Please submit in a single PDF file)' }}</span>
          <input type="file" id="cv" hidden @change="handleFileChange" />
          <label for="cv" class="file-btn">Add File</label>
        </div>
        <span v-if="errors.cv" class="error">{{ errors.cv }}</span>
      </section>

      <!-- RESEARCH -->
      <section class="section">
        <div class="section-title">
          <Icon icon="streamline:star-2-solid" class="icon" />
          <h2>Research Interests</h2>
        </div>
        <p class="section-des">Describe your dedication and motivation.</p>

        <textarea v-model="formData.motivation" placeholder="Why would you like to join this lab?" />
        <span v-if="errors.motivation" class="error">{{ errors.motivation }}</span>

        <textarea v-model="formData.timeManagement" placeholder="How do you manage time?" />
        <span v-if="errors.timeManagement" class="error">{{ errors.timeManagement }}</span>

        <textarea v-model="formData.availability" placeholder="How many days per week (hours per day) are you willing to dedicate your time for lab activities?" />
        <span v-if="errors.availability" class="error">{{ errors.availability }}</span>
      </section>

      <button type="button" class="submit" @click="submitForm">
        Submit
      </button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { Icon } from '@iconify/vue'
import { useRouter } from 'vue-router'
import { useMembershipStore } from '../stores/member_registration'
const membershipStore = useMembershipStore()

/* ======================
   FORM STATE
====================== */
// const formData = reactive({
//   name: '',
//   gender: '',
//   email: '',
//   phone: '',
//   studentId: '',
//   faculty: '',
//   year: '',
//   cv: null as File | null,
//   motivation: '',
//   timeManagement: '',
//   availability: ''
// })

const formData = membershipStore.formData
const errors = membershipStore.errors
// const errors = reactive<Record<string, string>>({})

/* ======================
   FILE HANDLER
====================== */
function handleFileChange(e) {
  const file = e.target.files[0]
  if (!file) return

  if (file.type !== 'application/pdf') {
    errors.cv = 'CV must be a PDF file'
    return
  }

  membershipStore.setFile(file)
}

/* ======================
   VALIDATION
====================== */
function validateForm() {
  Object.keys(errors).forEach(key => delete errors[key])
  let valid = true

  if (!formData.name) {
    errors.name = 'Name is required'
    valid = false
  }

  if (!formData.gender) {
    errors.gender = 'Gender is required'
    valid = false
  }

  if (!formData.email) {
    errors.email = 'Email is required'
    valid = false
  } else if (!/.+@.+\..+/.test(formData.email)) {
    errors.email = 'Invalid email format'
    valid = false
  }

  if (!formData.phone) {
    errors.phone = 'Phone number is required'
    valid = false
  }

  if (!formData.studentId) {
    errors.studentId = 'Student ID is required'
    valid = false
  }

  if (!formData.faculty) {
    errors.faculty = 'Faculty is required'
    valid = false
  }

  if (!formData.year) {
    errors.year = 'Current year is required'
    valid = false
  }

  if (!formData.cv) {
    errors.cv = 'CV is required'
    valid = false
  }

  if (!formData.motivation) {
    errors.motivation = 'This field is required'
    valid = false
  }

  if (!formData.timeManagement) {
    errors.timeManagement = 'This field is required'
    valid = false
  }

  if (!formData.availability) {
    errors.availability = 'This field is required'
    valid = false
  }

  return valid
}

/* ======================
   SUBMIT
====================== */
async function submitForm() {
  try {
    await membershipStore.submitForm()
    alert('Application submitted successfully!')
    router.push('/submissionpage')
  } catch (e) {
    console.log(errors)
  }
}
</script>

<style scoped>
.page {
  margin-bottom: 60px;
}

.header {
  background: var(--color-primary);
  color: white;
  padding: 40px;
  text-align: center;
  padding-inline: 10%;
}

.form {
  padding: 40px 20%;
}

.section {
  margin-bottom: 40px;
}

.section-title {
  display: flex;
  align-items: center;
  gap: 10px;
}

.section-des {
  margin-top: 15px;
  margin-bottom: 30px;
  text-align: left;
}

.icon {
  color: var(--color-primary);
  background-color: var(--color-secondary);
  padding: 10px;
  border-radius: 50%;
  width: 38px;
  height: 38px;
}

input,
select,
textarea {
  width: 100%;
  padding: 20px;
  margin-top: 10px;
  border-radius: 50px;
  border: 1px solid #ccc;
  font-size: 15px;
  color: var(--color-text);
}

textarea {
  border-radius: 16px;
  color: var(--color-text);
}

input::placeholder,
textarea::placeholder { 
  color: var(--color-text);  
}

.file-upload {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 1px solid #ccc;
  padding: 10px 16px;
  border-radius: 25px;
  margin-top: 10px;
}

.file-btn {
  background: #0a4fb3;
  color: white;
  padding: 6px 14px;
  border-radius: 20px;
  cursor: pointer;
}

.submit {
  background: #0a4fb3;
  color: white;
  padding: 14px 30px;
  border-radius: 30px;
  border: none;
  float: right;
}

.error {
  color: var(--color-error);
  font-size: 13px;

}
</style>
