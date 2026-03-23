<template>
  <div>
    <!-- 导航条2：滚动显示/隐藏导航条 -->
  <nav class="navbar navbar-expand-md navbar-light fixed-top" :style="navbarStyle" id="navbar-scroll">
    <div class="container-fluid" style="padding: 0 1.5rem;">
      <!-- Logo -->
      <router-link to="/" class="navbar-brand font-weight-bold d-flex align-items-center" style="background-clip: text; -webkit-background-clip: text; color: transparent; background-image: linear-gradient(to right, var(--color-primary), var(--color-secondary-yellow)); font-size: 1.8rem;">
        <img src="/school.ico" alt="校园百事屋" class="mr-2" style="height: 55px; width: auto;" />
        校园百事屋
      </router-link>

        <!-- 移动端汉堡菜单按钮 -->
        <button class="navbar-toggler" type="button" @click="toggleMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- 桌面端导航菜单 -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <router-link to="/" class="nav-link text-text-primary hover:text-primary transition-colors font-weight-bold" style="font-size: 1.1rem;">
                <i class="fa fa-home mr-1"></i> 首页
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/campus-hot" class="nav-link text-text-primary hover:text-primary transition-colors font-weight-bold" style="font-size: 1.1rem;">
                <i class="fa fa-bullhorn mr-1"></i> 校园热点
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/lostfound" class="nav-link text-text-primary hover:text-primary transition-colors font-weight-bold" style="font-size: 1.1rem;">
                <i class="fa fa-search mr-1"></i> 失物招领
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/secondhand" class="nav-link text-text-primary hover:text-primary transition-colors font-weight-bold" style="font-size: 1.1rem;">
                <i class="fa fa-shopping-cart mr-1"></i> 二手交易
              </router-link>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-text-primary hover:text-primary transition-colors font-weight-bold" href="#" id="campusActivitiesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.1rem;">
                <i class="fa fa-calendar-check-o mr-1"></i> 校园活动
              </a>
              <div class="dropdown-menu" aria-labelledby="campusActivitiesDropdown">
                <router-link to="/campus-activities" class="dropdown-item">校园活动</router-link>
                <router-link to="/campus-activities?tab=to-dream" class="dropdown-item">到梦活动</router-link>
                <router-link to="/campus-activities?tab=xuexitong" class="dropdown-item">学习通</router-link>
                <router-link to="/campus-activities?tab=volunteer" class="dropdown-item">志愿者</router-link>
                <div class="dropdown-divider"></div>
                <router-link to="/campus-activities?tab=about" class="dropdown-item">关于我们</router-link>
                <router-link to="/campus-activities?tab=contact" class="dropdown-item">联系我们</router-link>
              </div>
            </li>
          </ul>

          <!-- 右侧操作区 -->
          <div class="ml-auto d-flex align-items-center">
            <!-- 消息中心图标 -->
            <router-link 
              to="/chat" 
              class="btn btn-link mr-3" 
              style="font-size: 1.2rem; color: var(--color-primary);"
            >
              <i class="fa fa-bell"></i>
            </router-link>
            
            <div v-if="!isLogin" class="d-flex">
              <button class="btn btn-outline-secondary mr-2" @click="showAuthModal = true" style="font-size: 1rem; padding: 0.5rem 1.25rem;">登录</button>
              <button class="btn btn-primary" @click="showAuthModal = true" style="font-size: 1rem; padding: 0.5rem 1.25rem;">注册</button>
            </div>

            <!-- 用户菜单 -->
            <div v-else class="dropdown d-inline-block">
              <button 
                class="btn btn-link dropdown-toggle" 
                type="button" 
                id="userDropdown" 
                data-toggle="dropdown" 
                aria-haspopup="true" 
                aria-expanded="false"
                style="font-size: 1.1rem;"
              >
                <div class="d-flex align-items-center">
                  <div class="rounded-circle text-white font-weight-bold text-center w-10 h-10 mr-2" style="background: linear-gradient(135deg, #fb923c, #fbbf24);">
                    {{ user.name?.charAt(0) || 'U' }}
                  </div>
                  <span>{{ user.name }}</span>
                </div>
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <router-link 
                  to="/profile" 
                  class="dropdown-item" 
                >
                  <i class="fa fa-user mr-2"></i> 个人中心
                </router-link>
                <div class="dropdown-divider"></div>
                <button 
                  class="dropdown-item" 
                  @click="handleLogout"
                >
                  <i class="fa fa-sign-out mr-2"></i> 退出登录
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    
    <!-- 移动端侧边菜单 -->
    <div class="mobile-side-menu" :class="{ 'open': isMobileMenuOpen }">
      <div class="mobile-menu-header">
        <h3 class="mb-0">菜单</h3>
        <button class="close-btn" @click="toggleMobileMenu">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="mobile-menu-content">
        <ul class="mobile-nav-list">
          <li class="mobile-nav-item">
            <router-link to="/" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-home mr-2"></i> 首页
            </router-link>
          </li>
          <li class="mobile-nav-item">
            <router-link to="/campus-hot" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-bullhorn mr-2"></i> 校园热点
            </router-link>
          </li>
          <li class="mobile-nav-item">
            <router-link to="/lostfound" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-search mr-2"></i> 失物招领
            </router-link>
          </li>
          <li class="mobile-nav-item">
            <router-link to="/secondhand" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-shopping-cart mr-2"></i> 二手交易
            </router-link>
          </li>
          <li class="mobile-nav-item">
            <router-link to="/campus-activities" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-calendar-check-o mr-2"></i> 校园活动
            </router-link>
          </li>
          <li class="mobile-nav-item">
            <router-link to="/campus-activities?tab=to-dream" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-trophy mr-2"></i> 到梦活动
            </router-link>
          </li>
          <li class="mobile-nav-item">
            <router-link to="/campus-activities?tab=xuexitong" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-book mr-2"></i> 学习通
            </router-link>
          </li>
          <li class="mobile-nav-item">
            <router-link to="/campus-activities?tab=volunteer" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-heart mr-2"></i> 志愿者
            </router-link>
          </li>
          <li class="mobile-nav-item" v-if="!userStore.isLogin">
            <button class="mobile-nav-link btn-link" @click="showAuthModal = true; toggleMobileMenu()">
              <i class="fa fa-sign-in mr-2"></i> 登录/注册
            </button>
          </li>
          <li class="mobile-nav-item" v-else>
            <router-link to="/profile" class="mobile-nav-link" @click="toggleMobileMenu">
              <i class="fa fa-user mr-2"></i> 个人中心
            </router-link>
          </li>
          <li class="mobile-nav-item" v-if="userStore.isLogin">
            <button class="mobile-nav-link btn-link text-danger" @click="handleLogout; toggleMobileMenu()">
              <i class="fa fa-sign-out mr-2"></i> 退出登录
            </button>
          </li>
        </ul>
      </div>
    </div>
    
    <!-- 侧边菜单遮罩层 -->
    <div class="mobile-menu-overlay" v-if="isMobileMenuOpen" @click="toggleMobileMenu"></div>
    
    <!-- 导航条占位元素，避免内容重叠 -->
  <div id="navbar-placeholder" style="height: 70px;"></div>
    
    <!-- 登录注册模态框 -->
    <AuthModal 
      v-if="showAuthModal" 
      @close="showAuthModal = false" 
      @success="handleAuthSuccess"
    />
    

  </div>
</template>

<style scoped>
/* 移动端侧边菜单样式 */
.mobile-side-menu {
  position: fixed;
  top: 0;
  left: -300px;
  width: 300px;
  height: 100vh;
  background-color: white;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
  z-index: 1050;
  transition: left 0.3s ease;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

.mobile-side-menu.open {
  left: 0;
}

.mobile-menu-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #e0e0e0;
}

.mobile-menu-header h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #333;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  color: #666;
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.close-btn:hover {
  color: #333;
}

.mobile-menu-content {
  flex: 1;
  padding: 1rem 0;
}

.mobile-nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.mobile-nav-item {
  border-bottom: 1px solid #f0f0f0;
}

.mobile-nav-link {
  display: flex;
  align-items: center;
  padding: 1rem 1.5rem;
  color: #333;
  text-decoration: none;
  transition: all 0.3s ease;
  font-weight: 500;
}

.mobile-nav-link:hover {
  background-color: #f5f5f5;
  color: #ff6b6b;
  text-decoration: none;
}

.mobile-nav-item:last-child {
  border-bottom: none;
}

/* 侧边菜单遮罩层 */
.mobile-menu-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1049;
  transition: opacity 0.3s ease;
}

/* 响应式设计 */
@media (min-width: 768px) {
  .mobile-side-menu {
    display: none;
  }
  
  .mobile-menu-overlay {
    display: none;
  }
}
</style>

<script setup>
import { ref, onMounted, onUnmounted, reactive, watch, computed, watchEffect } from 'vue'
import { useUserStore } from '@/stores/modules/user'
import { useRouter } from 'vue-router'
import AuthModal from '@/components/auth/AuthModal.vue'

const userStore = useUserStore()
// 使用computed属性确保user状态响应式更新，注意：userStore中的state属性是userInfo，不是user
const user = computed(() => userStore.userInfo)
// 登录状态计算属性
const isLogin = computed(() => userStore.isLogin)
const router = useRouter()
const showAuthModal = ref(false)
// 移动端菜单状态
const isMobileMenuOpen = ref(false)



// 切换移动端菜单
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

// 导航条样式
const navbarStyle = reactive({
  backgroundColor: 'rgba(255, 255, 255, 0.85)',
  backdropFilter: 'blur(10px)',
  WebkitBackdropFilter: 'blur(10px)',
  boxShadow: '0 4px 20px rgba(0, 0, 0, 0.1)',
  transition: 'all 0.3s ease',
  transform: 'translateY(0)',
  opacity: '1',
  height: '70px',
  padding: '0.5rem 1rem'
})

// 记录上次滚动位置
let lastScrollTop = 0

// 滚动监听处理函数
const handleScroll = () => {
  const scrollTop = window.scrollY
  
  // 计算滚动距离
  const scrollDiff = scrollTop - lastScrollTop
  
  // 向下滚动，隐藏导航条
  if (scrollDiff > 5 && scrollTop > 50) {
    navbarStyle.transform = 'translateY(-100%)'
    navbarStyle.opacity = '0'
  } 
  // 向上滚动，显示导航条
  else if (scrollDiff < -5) {
    navbarStyle.transform = 'translateY(0)'
    navbarStyle.opacity = '1'
    
    // 根据滚动位置调整导航条样式
    if (scrollTop > 50) {
      navbarStyle.backgroundColor = 'rgba(255, 255, 255, 0.95)'
      navbarStyle.boxShadow = '0 6px 30px rgba(0, 0, 0, 0.15)'
    } else {
      navbarStyle.backgroundColor = 'rgba(255, 255, 255, 1)'
      navbarStyle.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)'
    }
  }
  
  // 更新上次滚动位置
  lastScrollTop = scrollTop
}

// 检查是否需要显示登录模态框
const checkAuthModal = () => {
  // 获取当前路由查询参数
  const query = router.currentRoute.value.query
  if (query.redirect) {
    // 显示登录模态框
    showAuthModal.value = true
  }
}

// 监听路由变化，检查是否需要显示登录模态框
watch(
  () => router.currentRoute.value,
  (newRoute) => {
    checkAuthModal()
  },
  { immediate: true }
)

// 组件挂载时添加滚动监听和检查登录模态框
onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  checkAuthModal()
})

// 组件卸载时移除滚动监听
onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

// 处理登录/注册成功
const handleAuthSuccess = () => {
  // 刷新用户信息
  userStore.getUserInfo()
  
  // 检查是否有重定向地址
  const query = router.currentRoute.value.query
  if (query.redirect) {
    // 跳转到重定向地址
    router.push(query.redirect)
  }
}

// 处理退出登录
const handleLogout = () => {
  userStore.logout()
}
</script>