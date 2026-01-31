<template>
<div class="wrapper">
    <h1 style="color: var(--color-primary);">Head of Laboratory</h1>
    <div class="container">
        <img src="/src/assets/about-us/hol.png" alt="hol">
        <div class="content">
            <h1>Dr. Dona Valy</h1>
            <div class="info">
                <div class="detail">
                    <h4>Education</h4>
                    <li>PhD in Engineering Science and Technology from Université Catholique de Louvain, Belgium</li>
                </div>
                <div class="detail">
                    <h4>Current Role</h4>
                    <li>Head of Mechatronics of Information Technology Research Unit (MIT) and Computer Vision & Natural Language Processing Laboratory (ViLa Lab) at Institute of Technology of Cambodia</li>
                </div>
                <div class="detail">
                    <h4>Research Interests</h4>
                    <li>Computer Vision, Natural Language Processing, Machine Learning, and Deep Learning.</li>
                </div>
            </div>
        </div>   
    </div>
</div>
</template>

<script setup>
</script>

<style scoped>
.wrapper{
    margin-top: 40px;
    margin-bottom: 156px;
    padding-inline: 156px;
    display: flex;
    flex-direction: column;
    gap: 40px;
}
.container{
    display: flex;
    flex-direction: row;
    padding: 20px;
    border-radius: 0px 40px 40px 0px;
    background-color: var(--color-secondary);
    gap: 66px;
}
.content{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 70%;
    gap: 24px;
}
.info{
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.detail li{
    margin-left: 20px;
    font-size: 16px;
    line-height: 160%;
    margin: 8px 0px 0px 20px;
}
</style>