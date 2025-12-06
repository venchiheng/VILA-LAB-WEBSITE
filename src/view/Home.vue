<script setup>
import ProjectSection from '@/components/showcase/ProjectShowcase.vue'
import NavigationBar from '../components/header/NavigationBar.vue';
</script>

<template>
  <div>
    <div>
      <NavigationBar />
    </div>

    <div class="flex justify-center items-center min-h-screen bg-gray-50">
      <ProjectSection title="Our Projects"
        description="Explore our amazing projects showcasing creativity and innovation." :boxes="[
          { topColor: 'bg-gray-300', bottomColor: 'bg-blue-700' },
          { topColor: 'bg-gray-300', bottomColor: 'bg-green-500' }
        ]" />
    </div>


  </div>


</template>
