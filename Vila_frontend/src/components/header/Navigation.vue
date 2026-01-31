<template>
  <nav class="bg-blue-600 px-6 py-4 flex items-center justify-between shadow-lg">
    
    <div class="flex items-center space-x-2">
      <img src="@/assets/Logo/VilaLab.png" alt="Vila Lab Logo" class="w-68 h-57 roun object-cover" />
      <span class="text-white font-bold text-xl">Vila Lab</span>
    </div>

    <!-- Navigation Links -->
    <ul class="flex space-x-8">
      <li><a href="/" class="text-white hover:text-blue-200 transition-colors">Home</a></li>
      <li><a href="/about" class="text-white hover:text-blue-200 transition-colors">About Lab</a></li>
      <li><a href="/achievements" class="text-white hover:text-blue-200 transition-colors">Achievements</a></li>
      <li><a href="/projects" class="text-white hover:text-blue-200 transition-colors">Projects</a></li>
      <li><a href="/contact" class="text-white hover:text-blue-200 transition-colors">Contact Us</a></li>
    </ul>

    <!-- Right Side: Settings and Button -->
    <div class="flex items-center space-x-4">
      <button class="text-white hover:text-blue-200 transition-colors p-2">
        <img 
            src="@/assets/logo/VilaLab.png" 
            alt="Settings Icon" 
            class="w-6 h-6"
        />
      </button>
      <a href="/join" class="bg-white text-blue-600 px-4 py-2 rounded-md font-semibold hover:bg-gray-100 transition-colors">Become a Member</a>
    </div>
  </nav>
</template>

<script setup>

</script>

