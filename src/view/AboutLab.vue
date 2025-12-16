<template>
    <HOL_Card />    
    <OurVision />

</template>

<script setup>
import OurVision from '@/components/about-us/our-vision.vue'
import HOL_Card from '../components/about-us/HOL_Card.vue';
const components = {
    OurVision,
    HOL_Card
}
</script>