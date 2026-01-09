<template>
    <v-app>
        <v-main>
            <v-container class="fill-height d-flex align-center justify-center">
                <v-card class="pa-12 text-center">
                    <h1 class="text-h3 font-weight-bold mb-4">403 - Forbidden</h1>
                    <p class="mb-6">You do not have permission to access this page.</p>
                    <v-btn color="blue" @click="$router.push('/')">Go Back Home</v-btn>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
</script>
