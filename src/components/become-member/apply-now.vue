<template>
<div class="container">
    <button class="apply-btn" @click="apply()">Apply Now</button>
</div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const apply = () => {
  router.push({ name: 'ApplyMember' })
}
</script>

<style scoped>
.container {
    display: flex;
    justify-content: flex-start;
    align-items: flex-end;
    background-image: url('/src/assets/become-member/apply.png');
    background-position: left;
    background-size: cover;
    background-repeat: no-repeat;
    min-height:  700px;
    width: 100%;
    padding-bottom: 5%;
    padding-inline: 12%;
    margin-block: 76px;
}
.apply-btn{
    border-radius: 100px;
    padding: 32px 48px 32px 48px;
    background-color: white;
    color: black;
    font-weight: 700;
}
.apply-btn:hover{
    background-color: var(--color-primary);
    color: white;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

@media (max-width: 1024px) {
  .container {
    min-height: 420px;
    padding-inline: 8%;
    margin-block: 56px;
  }

  .apply-btn {
    padding: 24px 40px;
    font-size: 1rem;
  }
}
@media (max-width: 768px) {
  .container {
    min-height: 360px;
    padding-inline: 6%;
    justify-content: center; /* center button */
    align-items: center;
  }

  .apply-btn {
    padding: 18px 32px;
    font-size: 0.95rem;
  }
}
@media (max-width: 480px) {
  .container {
    min-height: 300px;
    padding-inline: 5%;
    margin-block: 40px;
  }

  .apply-btn {
    padding: 14px 24px;
    font-size: 0.9rem;
  }
}
</style>