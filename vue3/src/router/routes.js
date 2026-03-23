// 路由规则列表
import { createRouter, createWebHistory } from 'vue-router'
const routes = [
  {
    path: '/',
    redirect: '/home' // 默认跳转到首页
  },
  {
    path: '/login',
    name: 'Login',
    redirect: '/', // 将登录页面重定向到首页，通过首页的导航条模态框登录
    meta: { title: '登录', requiresAuth: false }
  },
  // 首页
  {
    path: '/home',
    name: 'Home',
    component: () => import('../views/Home/index.vue'),
    meta: { requiresAuth: false } // 未登录也能看首页
  },
  // 商品详情页
  {
    path: '/product/:id',
    name: 'ProductDetail',
    component: () => import('../views/ProductDetail/index.vue'),
    meta: { requiresAuth: false }
  },
  // 发布商品页（需要登录）
  {
    path: '/publish',
    name: 'PublishProduct',
    component: () => import('../views/PublishProduct/index.vue'),
    meta: { requiresAuth: true } // 需登录才能访问
  },
  // 个人中心（需要登录）
  {
    path: '/profile',
    name: 'Profile',
    component: () => import('../views/Profile/index.vue'),
    meta: { requiresAuth: true }
  },
  // 聊天页面（需要登录）
  {
    path: '/chat',
    name: 'Chat',
    component: () => import('../views/Chat/index.vue'),
    meta: { requiresAuth: true }
  },
  // 校园热点
  {
    path: '/campus-hot',
    name: 'campus-hot',
    component: () => import('../views/Forum/ForumPage.vue'),
    meta: { requiresAuth: false, title: '校园热点' }
  },
  // 校园趣事
  {
    path: '/campus-fun',
    name: 'campus-fun',
    component: () => import('../views/Forum/ForumPage.vue'),
    meta: { requiresAuth: false, title: '校园趣事' }
  },
  // 校园闲聊
  {
    path: '/forum',
    name: 'forum',
    component: () => import('../views/Forum/ForumPage.vue'),
    meta: { requiresAuth: false }
  },
  // 论坛话题详情
  {
    path: '/forum/topic/:id',
    name: 'ForumDetail',
    component: () => import('../views/Forum/ForumDetail.vue'),
    meta: { requiresAuth: false }
  },
  // 失物招领
  {
    path: '/lostfound',
    name: 'lostfound',
    component: () => import('../views/LostFound/LostFoundPage.vue'),
    meta: { requiresAuth: false, title: '失物招领' }
  },
  // 失物招领详情
  {
    path: '/lostfound/:id',
    name: 'LostFoundDetail',
    component: () => import('../views/LostFound/LostFoundDetail.vue'),
    meta: { requiresAuth: false }
  },
  // 二手交易
  {
    path: '/secondhand',
    name: 'secondhand',
    component: () => import('../views/SecondHand/SecondHandPage.vue'),
    meta: { requiresAuth: false, title: '二手交易' }
  },
  // 校园活动
  {
    path: '/campus-activities',
    name: 'campus-activities',
    component: () => import('../views/CampusActivities/CampusActivitiesPage.vue'),
    meta: { requiresAuth: false, title: '校园活动' }
  },
  // 更多（包含联系我们、关于我们）
  {
    path: '/more',
    name: 'more',
    component: () => import('../views/More/MorePage.vue'),
    meta: { requiresAuth: false },
    children: [
      {
        path: 'contact',
        name: 'contact',
        component: () => import('../views/More/ContactUs.vue'),
        meta: { title: '联系我们' }
      },
      {
        path: 'about',
        name: 'about',
        component: () => import('../views/More/AboutUs.vue'),
        meta: { title: '关于我们' }
      }
    ]
  },
  // 管理员后台
  {
    path: '/admin',
    redirect: '/admin/products',
    meta: { requiresAuth: true }
  },
  {
    path: '/admin',
    name: 'Admin',
    component: () => import('../views/Admin/Index.vue'),
    meta: { title: '管理员后台', requiresAuth: true },
    children: [
      {
        path: 'products',
        name: 'AdminProducts',
        component: () => import('../views/Admin/Products.vue'),
        meta: { title: '商品管理', requiresAuth: true }
      },
      {
        path: 'users',
        name: 'AdminUsers',
        component: () => import('../views/Admin/Users.vue'),
        meta: { title: '用户管理', requiresAuth: true }
      }
    ]
  },
  // 404页面
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('../views/NotFound/index.vue'),
    meta: { title: '页面不存在' }
  }
]
export default routes