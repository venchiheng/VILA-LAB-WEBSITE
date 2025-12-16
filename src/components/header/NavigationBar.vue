<template>
  <nav class="navbar">
    <div class="navbar-inner">
      <Logo :size="80" :fontSize="20" label="ViLa Lab" />

      <div class="nav-links" v-if="!screenStore.isSmallScreen">
        <NavLink v-for="(item, i) in navItems" :key="i" :to="item.path" :label="item.label"
          :isActive="i === navStore.activeIndex" @click.prevent="navStore.setActive(i)" />
      </div>

      <div class="nav-actions">
        <SettingsButton :isActive="false"/>
        <CTAButton />
      </div>
    </div>

    <div class="nav-links-mobile" v-if="screenStore.isSmallScreen">
      <NavLink v-for="(item, i) in navItems" :key="'m-' + i" :to="item.path" :label="item.label"
        :isActive="i === navStore.activeIndex" @click.prevent="navStore.setActive(i)" />
    </div>
  </nav>
</template>

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
  { label: 'Home', path: '/home', isActive: true },
  { label: 'About Lab', path: '/aboutlab', isActive: false },
  { label: 'Achievements', path: '/achievements', isActive: false },
  { label: 'Projects', path: '/projects', isActive: false },
  { label: 'Contact Us', path: '/contactus', isActive: false }
]

</script>

<style scoped>
.navbar {
  width: 100%;
  background-color: var(--color-primary);
  height: 76px;
  padding: 0px 64px 0px 64px;
  display: flex;
  align-items: center;
}

.navbar-inner {
  width: 100%;
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
