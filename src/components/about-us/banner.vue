<template>
<div class="hero-section">
    <transition-group name="fade" tag="div" class="background-container">
      <div
        v-for="(banner, index) in banners"
        :key="index"
        v-show="currentSlide === index"
        class="background-slide"
        :style="{ backgroundImage: `url(${banner})` }"
      ></div>
    </transition-group>

    <div class="hero-overlay"></div>
    
    <div class="hero-content container mx-auto px-16">
      <div class="buttons-container">
        <button class="btn-primary">
          <svg class="mr-2" width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 12V10.425C0 9.70833 0.366667 9.125 1.1 8.675C1.83333 8.225 2.8 8 4 8C4.21667 8 4.425 8.00417 4.625 8.0125C4.825 8.02083 5.01667 8.04167 5.2 8.075C4.96667 8.425 4.79167 8.79167 4.675 9.175C4.55833 9.55833 4.5 9.95833 4.5 10.375V12H0ZM6 12V10.375C6 9.84167 6.14583 9.35417 6.4375 8.9125C6.72917 8.47083 7.14167 8.08333 7.675 7.75C8.20833 7.41667 8.84583 7.16667 9.5875 7C10.3292 6.83333 11.1333 6.75 12 6.75C12.8833 6.75 13.6958 6.83333 14.4375 7C15.1792 7.16667 15.8167 7.41667 16.35 7.75C16.8833 8.08333 17.2917 8.47083 17.575 8.9125C17.8583 9.35417 18 9.84167 18 10.375V12H6ZM19.5 12V10.375C19.5 9.94167 19.4458 9.53333 19.3375 9.15C19.2292 8.76667 19.0667 8.40833 18.85 8.075C19.0333 8.04167 19.2208 8.02083 19.4125 8.0125C19.6042 8.00417 19.8 8 20 8C21.2 8 22.1667 8.22083 22.9 8.6625C23.6333 9.10417 24 9.69167 24 10.425V12H19.5ZM8.125 10H15.9C15.7333 9.66667 15.2708 9.375 14.5125 9.125C13.7542 8.875 12.9167 8.75 12 8.75C11.0833 8.75 10.2458 8.875 9.4875 9.125C8.72917 9.375 8.275 9.66667 8.125 10ZM4 7C3.45 7 2.97917 6.80417 2.5875 6.4125C2.19583 6.02083 2 5.55 2 5C2 4.43333 2.19583 3.95833 2.5875 3.575C2.97917 3.19167 3.45 3 4 3C4.56667 3 5.04167 3.19167 5.425 3.575C5.80833 3.95833 6 4.43333 6 5C6 5.55 5.80833 6.02083 5.425 6.4125C5.04167 6.80417 4.56667 7 4 7ZM20 7C19.45 7 18.9792 6.80417 18.5875 6.4125C18.1958 6.02083 18 5.55 18 5C18 4.43333 18.1958 3.95833 18.5875 3.575C18.9792 3.19167 19.45 3 20 3C20.5667 3 21.0417 3.19167 21.425 3.575C21.8083 3.95833 22 4.43333 22 5C22 5.55 21.8083 6.02083 21.425 6.4125C21.0417 6.80417 20.5667 7 20 7ZM12 6C11.1667 6 10.4583 5.70833 9.875 5.125C9.29167 4.54167 9 3.83333 9 3C9 2.15 9.29167 1.4375 9.875 0.8625C10.4583 0.2875 11.1667 0 12 0C12.85 0 13.5625 0.2875 14.1375 0.8625C14.7125 1.4375 15 2.15 15 3C15 3.83333 14.7125 4.54167 14.1375 5.125C13.5625 5.70833 12.85 6 12 6ZM12 4C12.2833 4 12.5208 3.90417 12.7125 3.7125C12.9042 3.52083 13 3.28333 13 3C13 2.71667 12.9042 2.47917 12.7125 2.2875C12.5208 2.09583 12.2833 2 12 2C11.7167 2 11.4792 2.09583 11.2875 2.2875C11.0958 2.47917 11 2.71667 11 3C11 3.28333 11.0958 3.52083 11.2875 3.7125C11.4792 3.90417 11.7167 4 12 4Z" fill="white"/>
          </svg>
          Become a member
        </button>
        <button class="btn-secondary">
          Booking Equipment
          <svg class="ml-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.8834 0C15.2244 0 15.5514 0.135459 15.7926 0.376577C16.0337 0.617695 16.1691 0.944722 16.1691 1.28571V3.32229H17.9434C18.6254 3.32229 19.2795 3.5932 19.7617 4.07544C20.2439 4.55768 20.5149 5.21173 20.5149 5.89371V7.66971H22.6046C22.9456 7.66971 23.2726 7.80517 23.5137 8.04629C23.7548 8.28741 23.8903 8.61444 23.8903 8.95543C23.8903 9.29642 23.7548 9.62345 23.5137 9.86457C23.2726 10.1057 22.9456 10.2411 22.6046 10.2411H20.5131V13.5497H22.6046C22.9456 13.5497 23.2726 13.6852 23.5137 13.9263C23.7548 14.1674 23.8903 14.4944 23.8903 14.8354C23.8903 15.1764 23.7548 15.5034 23.5137 15.7446C23.2726 15.9857 22.9456 16.1211 22.6046 16.1211H20.5131V17.892C20.5131 18.574 20.2422 19.228 19.76 19.7103C19.2778 20.1925 18.6237 20.4634 17.9417 20.4634H16.1709V22.5771C16.1709 22.9181 16.0354 23.2452 15.7943 23.4863C15.5532 23.7274 15.2261 23.8629 14.8851 23.8629C14.5442 23.8629 14.2171 23.7274 13.976 23.4863C13.7349 23.2452 13.5994 22.9181 13.5994 22.5771V20.4634H10.2909V22.5771C10.2909 22.9181 10.1554 23.2452 9.91428 23.4863C9.67316 23.7274 9.34614 23.8629 9.00514 23.8629C8.66415 23.8629 8.33712 23.7274 8.09601 23.4863C7.85489 23.2452 7.71943 22.9181 7.71943 22.5771V20.4634H5.94514C5.26316 20.4634 4.6091 20.1925 4.12687 19.7103C3.64463 19.228 3.37371 18.574 3.37371 17.892V16.1194H1.28571C0.944722 16.1194 0.617695 15.984 0.376577 15.7429C0.135459 15.5017 0 15.1747 0 14.8337C0 14.4927 0.135459 14.1657 0.376577 13.9246C0.617695 13.6835 0.944722 13.548 1.28571 13.548H3.37371V10.2394H1.28571C0.944722 10.2394 0.617695 10.104 0.376577 9.86285C0.135459 9.62173 0 9.29471 0 8.95371C0 8.61272 0.135459 8.2857 0.376577 8.04458C0.617695 7.80346 0.944722 7.668 1.28571 7.668H3.37371V5.89543C3.37371 5.21344 3.64463 4.55939 4.12687 4.07715C4.6091 3.59492 5.26316 3.324 5.94514 3.324H7.71943V1.28571C7.71943 0.944722 7.85489 0.617695 8.09601 0.376577C8.33712 0.135459 8.66415 0 9.00514 0C9.34614 0 9.67316 0.135459 9.91428 0.376577C10.1554 0.617695 10.2909 0.944722 10.2909 1.28571V3.32229H13.5994V1.28571C13.5994 0.944722 13.7349 0.617695 13.976 0.376577C14.2171 0.135459 14.5442 0 14.8851 0M10.6474 7.76229C10.9491 6.384 12.9103 6.37543 13.224 7.752L13.2377 7.812L13.2651 7.932C13.4271 8.61682 13.7862 9.23916 14.298 9.72207C14.8099 10.205 15.4521 10.5273 16.1451 10.6491C17.5851 10.8994 17.5851 12.9634 16.1451 13.2137C15.448 13.3364 14.8025 13.6618 14.2894 14.1494C13.7762 14.6369 13.4182 15.2649 13.26 15.9549L13.224 16.1109C12.9103 17.4874 10.9491 17.4789 10.6474 16.1006L10.6166 15.9651C10.4654 15.2724 10.1112 14.6405 9.59907 14.1501C9.08699 13.6597 8.44033 13.3331 7.74171 13.212C6.30514 12.9617 6.30514 10.9011 7.74171 10.6509C8.4379 10.5301 9.08252 10.2053 9.59375 9.71753C10.105 9.22979 10.4598 8.60117 10.6131 7.91143L10.6354 7.81371L10.6474 7.76229Z" fill="currentColor"/>
          </svg>
        </button>
      </div>
    </div>
    
    <div class="scroll-indicator">
      <div class="scroll-circle">
        <Icon icon="mdi:chevron-down" width="24" height="24" />
      </div>
    </div>
  </div>
</template>
<script setup>  
import { ref, onMounted, onUnmounted } from 'vue'
import { Icon } from '@iconify/vue'
import banner1 from '@/assets/home/banner1.png'
import banner2 from '@/assets/home/banner2.png'
import banner3 from '@/assets/home/banner3.png'
import banner4 from '@/assets/home/banner4.png'
import banner5 from '@/assets/home/banner5.png'

const banners = [banner1, banner2, banner3, banner4, banner5]
const currentSlide = ref(0)
let slideInterval = null

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % banners.length
}

onMounted(() => {
  slideInterval = setInterval(nextSlide, 5000) // Change slide every 5 seconds
})

onUnmounted(() => {
  if (slideInterval) clearInterval(slideInterval)
})

</script>

<style scoped>
.hero-section {
  position: relative;
  width: 100%;
  height: calc(100vh - 76px);
  overflow: hidden; /* Ensure slides don't overflow */
  display: flex;
  align-items: flex-end;
  padding-bottom: 80px;
}

.background-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
}

.background-slide {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
}

/* Fade Transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  /* Optional: gradient to make text buttons pop if needed */
  background: linear-gradient(to bottom, rgba(0,0,0,0) 70%, rgba(0,0,0,0.2) 100%);
  pointer-events: none;
}

.hero-content {
  position: relative;
  z-index: 10;
  width: 100%;
  display: flex;
  justify-content: flex-start;
}

.buttons-container {
  display: flex;
  gap: 16px;
}

.btn-primary {
  background-color: var(--color-primary);
  color: var(--color-bg);
  border-radius: 100px;
  padding: 12px 24px;
  display: flex;
  align-items: center;
  font-weight: 500;
  border: none;
  transition: all 0.3s ease;
  cursor: pointer;
}

.btn-primary:hover {
  background-color: var(--color-secondary);
  color: var(--color-text); /* Ensure contrast on lighter secondary */
  transform: translateY(-2px);
}

.btn-secondary {
  background-color: var(--color-bg);
  color: var(--color-text);
  border-radius: 100px;
  padding: 12px 24px;
  display: flex;
  align-items: center;
  font-weight: 500;
  border: none;
  transition: all 0.3s ease;
  cursor: pointer;
}

.btn-secondary:hover {
  background-color: var(--color-secondary);
  transform: translateY(-2px);
}

.scroll-indicator {
  position: absolute;
  bottom: 24px;
  width: 100%;
  display: flex;
  justify-content: center;
  z-index: 10;
}

.scroll-circle {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  border: 1px solid var(--color-bg);
  display: flex;
  justify-content: center;
  align-items: center;
  color: var(--color-bg);
  cursor: pointer;
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-10px);
  }
  60% {
    transform: translateY(-5px);
  }
}

</style>