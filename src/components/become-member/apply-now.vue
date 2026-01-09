<template>
<div class="container">
    <button class="apply-btn" @click="apply()">Apply Now</button>
</div>
</template>

<script setup>

</script>

<style scoped>
.container {
    display: flex;
    justify-content: flex-start;
    align-items:flex-end;
    background-image: url('/src/assets/become-member/apply.png');
    background-position: center;
    background-size: cover;
    bottom: 0;
    background-repeat: no-repeat;
    height: 700px;
    width: 100%;
    padding-bottom: 5%;
    padding-inline: 12%;
    margin-bottom: 76px;
    margin-top: 76px;
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
</style>