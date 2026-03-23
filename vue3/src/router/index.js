import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes'
import { useUserStore } from '@/stores/modules/user'

// 创建路由实例（适配Vite 4.5）
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL), // Vite 4.5需用import.meta.env
  routes,
  scrollBehavior: () => ({ top: 0, left: 0 }) // 4.5版本滚动行为优化
})

// 将路由实例挂载到window上，以便在request.js中使用
window.router = router

// 路由守卫
router.beforeEach((to, from) => {
  // 设置页面标题
  if (to.meta.title) {
    document.title = `${to.meta.title} - 毕业作品`
  }
  // 登录验证
  const userStore = useUserStore()
  if (to.meta.requiresAuth && !userStore.token) {
    return { path: '/', query: { redirect: to.fullPath } } // 直接重定向到首页，通过导航条模态框登录
  }
  // 允许通过
  return true
})

export default router