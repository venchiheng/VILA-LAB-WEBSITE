import { createRouter,createWebHistory } from 'vue-router'
import generatedRoutes from 'virtual:generated-pages'
import { createVuestic } from 'vuestic-ui'
import 'vuestic-ui/css'

import { createApp } from 'vue'
import './style.css'
import App from './App.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: generatedRoutes,
})
const app = createApp(App)
app.use(createVuestic())
app.use(router)
app.mount('#app')
