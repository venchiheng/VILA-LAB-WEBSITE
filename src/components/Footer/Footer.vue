<template>
<div class="container">
    <div class="content">
        <img class="logo" src="/src/assets/logo/FooterVila.png" alt="logo">
        <div class="links">
            <h4>Quick Links</h4>
            <div class="link-list">
                <router-link class="link" to="/home">Home</router-link>
                <router-link class="link" to="/aboutlab">About Lab</router-link>
                <router-link class="link" to="/achievements">Achievements</router-link>
                <router-link class="link" to="/projects">Projects</router-link>
                <router-link class="link" to="/contactus">Contact Us</router-link>
            </div>
        </div>
        <div class="tc">
            <h4>Terms & Conditions</h4>
            <div class="link-list">
                <router-link class="link" to="/privacy-policy">Privacy policy</router-link>
                <router-link class="link" to="/FAQs">FAQs</router-link>
            </div>

        </div>
        <div class="contact">
            <h4>Contact Us</h4>
            <div class="link-list">
                <div class="ti">
                    <Icon icon="ic:round-email" class="icon" />
                    <a href="mailto:dona@itc.edu.kh">dona@itc.edu.kh</a>
                </div>
                <div class="ti">
                    <Icon icon="weui:location-filled" class="icon" />
                    <a href="https://maps.app.goo.gl/WPJ3PRVh1HCW6184A" target="_blank" rel="noopener noreferrer">610I, Institute of Technology of Cambodia, PO Box 86, Russian Conf. Blvd., Phnom Penh, Cambodia</a>
                </div>
            </div>
            <h4>Social Media</h4>
            <div class="ti">
                <a href="https://web.facebook.com/vilalabitc" target="_blank" rel="noopener noreferrer"><Icon icon="ic:baseline-facebook" class="icon2"/></a>
            </div>
        </div>
    </div>
    <div class="hl"></div>
    <p>Copyright © 2025 - ViLa Lab</p>
</div>
</template>

<script setup>
import { Icon } from '@iconify/vue';


</script>

<style scoped>
.container {
    background-color: var(--color-primary);
    color: white;
    padding: 40px 20px;
    text-align: center;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
}
.content{
    display: flex;
    width: 95%;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 20px;
}
.logo{
    width: 20%;
    height: 17%;
}
.icon{
    width: 20px;
    height: 20px;
}
.icon2{
    width: 30px;
    height: 30px;
    color: white;
}
.links, .tc, .contact {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 26px;
    max-width: 30%;
    text-align: left;
}
.link-list{
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.link, a{
    color: white;
    text-decoration: none;
}
.link:hover, a:hover{
    color: var(--color-secondary);
}
.ti{
    display: flex;
    align-items: center;
    gap: 8px;
}
.hl{
    display: flex;
    height: 1px;
    background-color: white;
    width: 95%;
    margin-bottom: 16px;
}
</style>
