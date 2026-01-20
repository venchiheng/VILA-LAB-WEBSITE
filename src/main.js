import generatedRoutes from 'virtual:generated-pages'
import { createRouter, createWebHistory } from 'vue-router' 
import { createVuestic } from 'vuestic-ui'
import 'vuestic-ui/css'
import { createPinia } from 'pinia'
import { createApp } from 'vue'
import './style.css'
import { createVuetify } from 'vuetify'
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { Icon } from '@iconify/vue'
import App from './App.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    ...generatedRoutes,
    {
      path: '/Equipments/:id',
      name: 'EquipmentDetail',
      component: () => import('@/view/Equipments.vue')
    }
  ],
})

const vuetify = createVuetify({
  components,
  directives,
})

const app = createApp(App)
const pinia = createPinia()
app.component('Icon', Icon)
app.use(createVuestic())
app.use(vuetify)
app.use(router)
app.use(pinia)
app.mount('#app')