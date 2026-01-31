<template>
<div>
 <NavigationBar style="position: fixed; z-index: 100000; margin-bottom: 90px;" v-if="!isAdminRoute && !isLoginRoute" />
  <div class="page-content"  :class="{ 'with-navbar': !isAdminRoute && !isLoginRoute }">
      <router-view />
    </div>
  <Footer v-if="!isAdminRoute && !isLoginRoute"/>
  </div>
</template>

<

<script setup>
import { useRoute } from 'vue-router'
import Footer from './components/Footer/Footer.vue'
import NavigationBar from './components/header/NavigationBar.vue'

const route = useRoute()

import { computed } from 'vue'
const isAdminRoute = computed(() => route.path.startsWith('/admin'))
const isLoginRoute = computed(() => route.path.startsWith('/login'))


</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
}
.page-content.with-navbar {
  padding-top: 76px; /* Adjust based on your navbar height */
}
</style>
