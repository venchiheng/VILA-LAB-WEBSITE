<template>
    <HOL_Card />    
    <OurVision />
    <OurService :services="servicesData" />
</template>

<script setup>
import OurVision from '@/components/about-us/our-vision.vue'
import HOL_Card from '../components/about-us/HOL_Card.vue';
import OurService from '@/components/about-us/our-service.vue';

// Import assets for services
import service1 from '@/assets/our-service/service1.png'
import service2 from '@/assets/our-service/service2.png'
import service3 from '@/assets/our-service/service3.png'

const servicesData = [
    { 
        image: service1, 
        title: "Consultation on AI solutions for businesses and institutions" 
    },
    { 
        image: service2, 
        title: "AI skills training on Machine Learning, Deep Learning, Computer Vision, and NLP" 
    },
    { 
        image: service3, 
        title: "AI application development in sectors such as education, agriculture, and healthcare" 
    }
]

const components = {
    OurVision,
    HOL_Card,
    OurService
}
</script>