import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from '@/router'
import App from './App.vue'

// 全局样式
import '@/assets/styles/common.scss'
import '@/assets/styles/colors.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'font-awesome/css/font-awesome.min.css'

// Bootstrap JS dependencies
import 'jquery'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

// 创建Vue实例
const app = createApp(App)

// 安装插件
const pinia = createPinia()
app.use(pinia)
app.use(router)

// 初始化用户登录状态监听
import { useUserStore } from '@/stores/modules/user'
const userStore = useUserStore()
userStore.initLoginState()

// 挂载到DOM
app.mount('#app')