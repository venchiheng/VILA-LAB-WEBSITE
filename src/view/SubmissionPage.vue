<template>
  <div class="submission-page">
    <header class="header">
      <h1>Member Registration Form</h1>
      <p style="text-align: left; margin-top: 40px;"> Our lab is committed to providing a supportive environment for undergraduate and master's students to conduct research in Computer Vision and Natural Language Processing. Through mentorship and collaboration, we aim to equip our students with the skills and knowledge needed to become successful researchers and practitioners in these fields. </p> 
      <p style="text-align: left; margin-top: 20px;"> Any interested candidate can apply by filling in the form below: </p>
    </header>
    <div class="content">
      <Icon icon="ix:certificate-success-filled" class="icon" />
      <h1>Submission Completed</h1>
      <p>Thank you for joining us. We'll reach out once your application is confirmed. Please check your email for further updates.</p>
      <router-link to="/home" class="btn">Back to home page</router-link>
    </div>
  </div>
</template>
<script setup>
import { Icon } from '@iconify/vue';
</script>
<style scoped>
.icon{
    background-color: var(--color-secondary);
    color: var(--color-primary);
    padding: 10px;
    font-size: 58px;
    border-radius: 50%;
    margin-bottom: 30px;
}
.header {
  background: var(--color-primary);
  color: white;
  padding: 40px;
  text-align: center;
  padding-inline: 10%;
  border-bottom-right-radius: 40px;
  border-bottom-left-radius: 40px;
}

.content {
  padding-top: 60px;
  height: 80vh;
  padding-inline: 25%;
  display: flex;
  flex-direction: column;
  text-align: left;
}

.content h1 {
  font-size: 36px;
  margin-bottom: 20px;
}

.content p {
  font-size: 18px;
  margin-bottom: 40px;
}

.btn {
  background: var(--color-primary);
  color: white;
  padding: 14px 30px;
  border-radius: 30px;
  text-decoration: none;
  width: fit-content;
}
</style>
