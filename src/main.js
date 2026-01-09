import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createRouter, createWebHistory } from 'vue-router'
import generatedRoutes from 'virtual:generated-pages'

import App from './App.vue'
import { useAuthStore } from '@/stores/auth'

// UI libs
import { createVuestic } from 'vuestic-ui'
import 'vuestic-ui/css'
import { createVuetify } from 'vuetify'
import 'vuetify/styles'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { Icon } from '@iconify/vue'
import './style.css'

// 1️⃣ Create App and Pinia
const app = createApp(App)
const pinia = createPinia()
app.use(pinia)

// 2️⃣ Add 403 route manually
generatedRoutes.push({
  path: '/403',
  component: () => import('@/view/Forbidden.vue'),
})

// 3️⃣ Create Router
const router = createRouter({
  history: createWebHistory(),
  routes: generatedRoutes,
})
// router.beforeEach((to, from, next) => {
//   const auth = useAuthStore()

//   const isLoginPage = to.path === '/admin/login'
//   const isAdminRoute = to.path.startsWith('/admin') && !isLoginPage

//   // 1️⃣ If going to login page → logout first
//   if (isLoginPage) {
//     if (auth.isAuthenticated()) {
//       auth.logout() // clear token, user, session
//     }
//     return next() // allow login page
//   }

//   // 2️⃣ Not logged in → redirect to login
//   if (isAdminRoute && !auth.isAuthenticated()) {
//     return next('/admin/login')
//   }

//   // 3️⃣ Logged in but NOT admin → redirect to 403
//   if (isAdminRoute && !auth.isAdmin) {
//     return next('/403')
//   }

//   next()
// })


// 5️⃣ Vuetify & Plugins
const vuetify = createVuetify({ components, directives })
app.component('Icon', Icon)
app.use(router)
app.use(createVuestic())
app.use(vuetify)

// 6️⃣ Mount
app.mount('#app')
