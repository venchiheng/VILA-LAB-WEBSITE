<script setup>
import Logo from './Logo.vue'
import NavLink from './NavLink.vue'
import SettingsButton from './SettingsButton.vue'
import CTAButton from './CTAButton.vue'
import { useNavStore } from '../../stores/navStore'
import { useScreenStore } from '../../stores/responsiveStore'
const navStore = useNavStore()
const screenStore = useScreenStore()
const navItems = [
  { label: 'Home', path: '/', isActive: true },
  { label: 'About Lab', path: '/aboutlab', isActive: false },
  { label: 'Achievements', path: '/achievements', isActive: false },
  { label: 'Projects', path: '/projects', isActive: false },
  { label: 'Contact Us', path: '/contactus', isActive: false }
]

</script>

<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <Logo :size="80" :fontSize="20" label="ViLa Lab" />


      <div class="nav-links" v-if="!screenStore.isSmallScreen">
        <NavLink v-for="(item, i) in navItems" :key="i" :to="item.path" :label="item.label"
          :isActive="i === navStore.activeIndex" @click.prevent="navStore.setActive(i)" />
      </div>


      <div class="nav-actions">
        <SettingsButton :size="40" />
        <CTAButton />
      </div>
    </div>


    <div class="nav-links-mobile" v-if="screenStore.isSmallScreen">
      <NavLink v-for="(item, i) in navItems" :key="'m-' + i" :to="item.path" :label="item.label"
        :isActive="i === navStore.activeIndex" @click.prevent="navStore.setActive(i)" />
    </div>
  </nav>
</template>

<style scoped>
.navbar {
  width: 100%;
  background-color: var(--color-primary);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.navbar-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 16px;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.nav-links {
  display: flex;
  gap: 16px;
  align-items: center;
}

.nav-actions {
  display: flex;
  gap: 16px;
  align-items: center;
}

.nav-links-mobile {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  justify-content: center;
  padding: 12px 0;
}
</style>
