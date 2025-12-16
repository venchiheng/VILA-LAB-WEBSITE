<template>
<div class="container">
    <img class="robot" src="/src/assets/about-us/robothand.png" alt="robot">
    <div class="content">
        <h1>Our Vision</h1>
        <p>Be the leading Khmer Natural Language Processing Lab in Cambodia.</p>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.container{
    position: relative;
    width: 100%;
    margin-top: 76px;
    min-height: 300px;
    background-image: url('src/assets/about-us/visionbg.png');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 76px;
}
.robot{
    position: absolute;
    left: 0px;
    bottom: 0;
    height: 120%;
    max-width: none;
    z-index: 1;
}
.content{
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    padding: 20px;
}
p{
    margin-top: 40px;
    font-size: 20px;
}
</style>
