<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" :rail="rail" permanent app class="grey lighten-4">
            <v-list-item class="px-4">
                <v-list-item-avatar>
                    <v-img :src="logo" />
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title>John Leider</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list nav dense>
                <v-list-item v-for="item in menuItems" :key="item.title" :to="item.route" link>
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title v-if="!rail">{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main app>
            <v-container fluid>
                <slot />
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import { ref } from 'vue'
import logo from '@/assets/logo/VilaLab.png'
const drawer = ref(true)
const rail = ref(false)

const menuItems = [
    { title: 'Home', icon: 'mdi-home-city', route: '/admin/home' },
    { title: 'My Account', icon: 'mdi-account', route: '/admin/account' },
    { title: 'Users', icon: 'mdi-account-group-outline', route: '/admin/users' },
]
</script>

<style scoped>
.v-navigation-drawer {
    width: 250px;
}
</style>
