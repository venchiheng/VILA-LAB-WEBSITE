<template>
    <v-app>

        <v-navigation-drawer app permanent width="220">
            <v-list nav dense>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-h6">Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>


                <v-list-item v-for="item in menuItems" :key="item.title" :to="item.route" link
                    :active-class="'v-list-item--active'">
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>


        <v-main>
            <v-container fluid>
                <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: 'DashboardLayout',
    data() {
        return {
            menuItems: [
                { title: 'Home', route: '/admin/home' },
                { title: 'Users', route: '/admin/users' },
                { title: 'Settings', route: '/admin/settings' },
            ],
        };
    },
};
</script>

<style scoped>
.v-list-item--active {
    background-color: rgba(0, 150, 136, 0.2);
}
</style>
