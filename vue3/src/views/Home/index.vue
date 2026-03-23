<template>
  <div class="min-h-screen bg-white relative overflow-hidden d-flex flex-column">
    <!-- 左侧固定导航菜单 -->
    <div 
      class="left-fixed-nav"
      :style="{ opacity: isPositioningBarVisible ? 1 : 0, visibility: isPositioningBarVisible ? 'visible' : 'hidden' }"
    >
      <ul class="nav-list">
        <li 
          v-for="(section, index) in positioningSections" 
          :key="index"
          :class="{ 'active': currentSection.value === index }"
          @click="scrollToSection(index)"
        >
          <span class="nav-label">{{ section.label }}</span>
        </li>
      </ul>
    </div>
    

    
    <!-- 主内容容器，添加左内边距避开固定导航 -->
    <div class="main-content-container">
    <!-- 巨幕部分 -->
    <div class="jumbotron-section" id="jumbotron-section">
      <div class="h-100 w-100 d-flex align-items-center justify-content-center p-4">
        <div class="card overflow-hidden h-100 w-100 max-w-6xl shadow-lg" style="border: 2px solid transparent; background: linear-gradient(white, white) padding-box, linear-gradient(45deg, #FF8A5C, #FFD93D, #FF8A5C) border-box; position: relative; overflow: hidden;">
          <!-- 内部流光效果 -->
          <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(45deg, transparent, rgba(255, 138, 92, 0.3), transparent); animation: borderGlow 3s linear infinite;"></div>
          <div class="row no-gutters h-100">
            <div class="col-md-5">
              <div class="card-body p-10 d-flex flex-column justify-center">
                <h1 class="display-3 font-bold mb-6" style="font-size: 3.5rem; background-clip: text; -webkit-background-clip: text; color: transparent; background-image: linear-gradient(to right, #FF8A5C, #FFD93D);">
                  书香伴纸鸢 · 青春正当时
                </h1>
                <p class="lead mb-8 text-text-secondary" style="font-size: 1.25rem; line-height: 1.8;">
                  阳光洒落书页，纸飞机载着梦想飞向远方。<br>
                  在淡粉、淡蓝与淡黄的色彩里，遇见最清新的校园时光。
                </p>
              </div>
            </div>
            <div class="col-md-7">
              <div class="relative h-100">
                <img 
                  src="@/assets/images/jumbotron.jpg" 
                  alt="巨幕图片" 
                  class="img-fluid h-100 w-100 object-cover"
                  style="animation: float 4s ease-in-out infinite;"
                />
                <!-- 使用用户提供的透明背景纸飞机图片 -->
                <img
                  id="paperPlane"
                  class="absolute"
                  src="@/assets/images/jumu.png"
                  alt="纸飞机"
                  style="
                    top: 0;
                    left: 0;
                    width: 150px;
                    height: auto;
                    z-index: 1000;
                    pointer-events: none;
                    opacity: 1;
                    position: absolute;
                  "
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- 核心功能区 -->
    <div class="core-features-section" id="core-features-section">
      <div class="h-100 w-100 d-flex align-items-center justify-content-center py-12 bg-white">
        <div class="container">
          <h2 class="text-center display-4 font-bold mb-10 text-text-primary">核心功能</h2>
          <div class="row h-100">
            <!-- 校园热点 -->
            <div class="col-sm-6 mb-8">
              <router-link 
                to="/campus-hot" 
                class="text-decoration-none text-dark d-block h-100"
              >
                <div class="core-feature-card h-100 d-flex flex-column align-items-center justify-center p-8 rounded-lg shadow-sm hover:shadow-xl" style="transition: all 0.5s ease; transform: translateY(0); background-color: #fff; border: 1px solid #e3f2fd;">
                  <div class="feature-icon mb-6 text-primary" style="font-size: 5rem;">
                    <i class="fa fa-bullhorn"></i>
                  </div>
                  <h3 class="card-title font-weight-bold text-primary mb-3 text-2xl">校园热点</h3>
                  <p class="card-text text-text-secondary text-center" style="font-size: 1.1rem;">了解校园最新动态，关注热点事件</p>
                </div>
              </router-link>
            </div>
            
            <!-- 失物招领 -->
            <div class="col-sm-6 mb-8">
              <router-link 
                to="/lostfound" 
                class="text-decoration-none text-dark d-block h-100"
              >
                <div class="core-feature-card h-100 d-flex flex-column align-items-center justify-center p-8 rounded-lg shadow-sm hover:shadow-xl" style="transition: all 0.5s ease; transform: translateY(0); background-color: #fff; border: 1px solid #e3f2fd;">
                  <div class="feature-icon mb-6 text-primary" style="font-size: 5rem;">
                    <i class="fa fa-search"></i>
                  </div>
                  <h3 class="card-title font-weight-bold text-primary mb-3 text-2xl">失物招领</h3>
                  <p class="card-text text-text-secondary text-center" style="font-size: 1.1rem;">寻找丢失物品，发布招领信息</p>
                </div>
              </router-link>
            </div>
            
            <!-- 二手交易 -->
            <div class="col-sm-6 mb-8">
              <router-link 
                to="/secondhand" 
                class="text-decoration-none text-dark d-block h-100"
              >
                <div class="core-feature-card h-100 d-flex flex-column align-items-center justify-center p-8 rounded-lg shadow-sm hover:shadow-xl" style="transition: all 0.5s ease; transform: translateY(0); background-color: #fff; border: 1px solid #e3f2fd;">
                  <div class="feature-icon mb-6 text-primary" style="font-size: 5rem;">
                    <i class="fa fa-shopping-cart"></i>
                  </div>
                  <h3 class="card-title font-weight-bold text-primary mb-3 text-2xl">二手交易</h3>
                  <p class="card-text text-text-secondary text-center" style="font-size: 1.1rem;">买卖二手物品，资源循环利用</p>
                </div>
              </router-link>
            </div>
            
            <!-- 校园活动 -->
            <div class="col-sm-6 mb-8">
              <router-link 
                to="/campus-activities" 
                class="text-decoration-none text-dark d-block h-100"
              >
                <div class="core-feature-card h-100 d-flex flex-column align-items-center justify-center p-8 rounded-lg shadow-sm hover:shadow-xl" style="transition: all 0.5s ease; transform: translateY(0); background-color: #fff; border: 1px solid #e3f2fd;">
                  <div class="feature-icon mb-6 text-primary" style="font-size: 5rem;">
                    <i class="fa fa-calendar-check-o"></i>
                  </div>
                  <h3 class="card-title font-weight-bold text-primary mb-3 text-2xl">校园活动</h3>
                  <p class="card-text text-text-secondary text-center" style="font-size: 1.1rem;">参与校园活动，丰富校园生活</p>
                </div>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    

    
    <!-- 热点话题框 -->
    <div id="hot-topics-section" class="py-8 bg-background-light">
      <div class="container">
        <h2 class="text-center display-4 font-bold mb-5 text-text-primary">热点话题</h2>
        <div class="row">
          <!-- 校园热点 -->
          <div class="col-lg-6 mb-4">
            <div class="card shadow-sm hover:shadow-lg transition-all duration-300">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold">校园热点</h3>
              </div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li v-for="i in 3" :key="`hot-${i}`" class="mb-4">
                    <div class="d-flex align-items-start">
                      <div class="bg-primary text-white rounded-circle w-10 h-10 flex-shrink-0 d-flex align-items-center justify-center font-weight-bold mr-3">
                        {{ i }}
                      </div>
                      <div class="flex-grow-1">
                        <h4 class="font-weight-medium text-text-primary hover:text-primary cursor-pointer transition-colors">校园热点话题标题{{ i }}</h4>
                        <p class="text-sm text-text-secondary">2024-03-20 · 123阅读</p>
                      </div>
                    </div>
                  </li>
                </ul>
                <div class="text-center">
                  <router-link 
                    to="/campus-hot" 
                    class="text-primary font-weight-medium"
                  >
                    查看更多 <i class="fa fa-arrow-right ml-1"></i>
                  </router-link>
                </div>
              </div>
            </div>
          </div>
          
          <!-- 校园活动 -->
          <div class="col-lg-6 mb-4">
            <div class="card shadow-sm hover:shadow-lg transition-all duration-300">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold">校园活动</h3>
              </div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li v-for="i in 3" :key="`activity-${i}`" class="mb-4">
                    <div class="d-flex align-items-start">
                      <div class="bg-primary text-white rounded-circle w-10 h-10 flex-shrink-0 d-flex align-items-center justify-center font-weight-bold mr-3">
                        {{ i }}
                      </div>
                      <div class="flex-grow-1">
                        <h4 class="font-weight-medium text-text-primary hover:text-primary cursor-pointer transition-colors">校园活动标题{{ i }}</h4>
                        <p class="text-sm text-text-secondary">2024-03-20 · 123人参与</p>
                      </div>
                    </div>
                  </li>
                </ul>
                <div class="text-center">
                  <router-link 
                    to="/campus-activities" 
                    class="text-primary font-weight-medium"
                  >
                    查看更多 <i class="fa fa-arrow-right ml-1"></i>
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- 商品列表（热门商品） -->
    <div id="popular-products-section" class="py-8 bg-white">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="display-4 font-bold text-text-primary">热门商品</h2>
          <router-link 
            to="/secondhand" 
            class="text-primary font-weight-medium"
          >
            查看全部 <i class="fa fa-arrow-right ml-1"></i>
          </router-link>
        </div>
        
        <!-- 商品网格 -->
        <div class="row">
          <div v-for="product in productList" :key="product.id" class="col-sm-6 col-md-4 col-lg-3 mb-4 product-card-item d-flex">
            <div class="w-100">
              <ProductCard 
                :product="product" 
                :is-favorite="favoriteStatusMap[product.id] || false"
                @favorite-change="handleFavoriteChange"
              />
            </div>
          </div>
        </div>
        
        <!-- 空状态 -->
        <div v-if="productList.length === 0 && !loading" class="card shadow-sm p-5 text-center">
          <div class="text-text-secondary">暂无商品</div>
        </div>
        
        <!-- 加载状态 -->
        <div v-if="loading" class="card shadow-sm p-5 text-center">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
    
    <!-- 校园活动 -->
    <div id="campus-activities-section" class="py-12 bg-background-light">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-8">
          <h2 class="display-4 font-bold text-text-primary">校园活动</h2>
          <router-link 
            to="/campus-activities" 
            class="text-primary font-weight-medium"
          >
            查看全部 <i class="fa fa-arrow-right ml-1"></i>
          </router-link>
        </div>
        
        <!-- 活动横向滚动容器 -->
        <div class="activity-scroll-container">
          <!-- 活动卡片组 -->
          <div class="activity-card-group d-flex overflow-x-auto pb-4">
            <!-- 活动卡片 -->
            <div 
              v-for="activity in activityList" 
              :key="activity.id" 
              class="activity-card flex-shrink-0 mr-6 w-72 bg-white rounded-lg overflow-hidden hover:shadow-xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100"
              @click="goToActivity(activity.url)"
            >
              <!-- 活动图标 -->
              <div class="relative w-full aspect-square overflow-hidden bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                <!-- 直接使用活动指定的图标 -->
                <div class="activity-icon text-4xl text-primary">
                  <i 
                    class="fa" 
                    :class="activity.icon"
                  ></i>
                </div>
              </div>
              <!-- 活动信息 -->
              <div class="p-4 flex flex-col h-36">
                <h3 class="font-medium text-gray-800 text-lg mb-2 hover:text-orange-500 transition-colors duration-300 text-center">
                  {{ activity.title }}
                </h3>
                <div class="flex justify-center mt-auto mb-2">
                  <span class="bg-blue-50 px-3 py-1 rounded-full text-blue-600 font-medium text-sm">{{ activity.category }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- 空状态 -->
        <div v-if="activityList.length === 0" class="card shadow-sm p-8 text-center bg-white rounded-lg mt-8">
          <div class="text-text-secondary text-lg">暂无活动</div>
        </div>
      </div>
    </div>
    
    <!-- 页脚 -->
    <footer class="py-10" style="background: linear-gradient(135deg, #2C3E50, #34495E); color: white; margin-top: auto; box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);">
      <div class="container">
        <div class="row">
          <div class="col-md-8 offset-md-2 text-center">
            <h3 class="font-weight-bold mb-5" style="font-size: 1.5rem; color: #FFD93D;">重要提示</h3>
            <p class="mb-6" style="line-height: 1.8; font-size: 1rem; color: rgba(255, 255, 255, 0.9);">
              本站仅为个人毕业设计作品，所有商品信息均由用户自行发布。<br />
              请务必在交易前仔细核实对方身份及商品信息，谨防网络诈骗。<br />
              任何用户之间的交易纠纷及违法行为均与本站无关。<br />
              如发现违规信息，请联系本人处理。
            </p>
            <div class="mb-6">
              <router-link to="/campus-activities?tab=about" class="mx-4" style="font-size: 1.1rem; color: #FFD93D; text-decoration: none; transition: all 0.3s ease;">
                关于我们
              </router-link>
              <router-link to="/campus-activities?tab=contact" class="mx-4" style="font-size: 1.1rem; color: #FFD93D; text-decoration: none; transition: all 0.3s ease;">
                联系我们
              </router-link>
              <button @click="showPrivacyPolicy" class="mx-4 btn btn-link" style="font-size: 1.1rem; color: #FFD93D; text-decoration: none; transition: all 0.3s ease; background: none; border: none; padding: 0;">
                隐私政策
              </button>
              <button @click="showTermsOfUse" class="mx-4 btn btn-link" style="font-size: 1.1rem; color: #FFD93D; text-decoration: none; transition: all 0.3s ease; background: none; border: none; padding: 0;">
                使用条款
              </button>
            </div>
            <p style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.8);">© 2024 校园百事屋. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
    </div>

    <!-- 返回顶部按钮 -->
    <button 
      class="btn btn-orange btn-floating" 
      style="position: fixed; right: 30px; bottom: 30px; z-index: 999; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 12px rgba(255, 138, 92, 0.3); transition: all 0.3s ease;" 
      @click="scrollToTop"
      :style="{ display: showBackToTop ? 'flex' : 'none' }"
    >
      <i class="fa fa-arrow-up"></i>
    </button>
    
    <!-- 用户协议模态框（用于显示隐私政策和使用条款） -->
    <AuthModal 
      v-if="showTermsModal" 
      :show-terms-directly="true"
      @close="showTermsModal = false" 
    />
  </div>
</template>

<script setup>
import { ref, onMounted, watch, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import ProductCard from '@/components/ProductCard.vue'
import AuthModal from '@/components/auth/AuthModal.vue'
import { productApi } from '@/api/modules/product'
import { favoriteApi } from '@/api/modules/favorite'
import { useUserStore } from '@/stores/modules/user'

// 初始化路由
const router = useRouter()

// 用户状态
const userStore = useUserStore()

// 轮播图数据已移除，改为固定大幕形式

// 分类列表
const categoryList = ref([
  { id: 0, name: '全部' },
  { id: 1, name: '数码产品' },
  { id: 2, name: '生活用品' },
  { id: 3, name: '学习资料' },
  { id: 4, name: '服饰鞋包' },
  { id: 5, name: '其他' }
])

// 商品列表相关
const productList = ref([])
const loading = ref(false)
const pageNum = ref(1)
const pageSize = ref(12)
const total = ref(0)
const currentCategory = ref(0)
const searchKeyword = ref('')
// 收藏状态映射表，key: productId, value: boolean
const favoriteStatusMap = ref({})

// 校园活动数据 - 更新为新的内容
const activityList = ref([
  {
    id: 1,
    title: '到梦活动',
    category: '活动',
    icon: 'fa-calendar-check-o',
    url: '/campus-activities?tab=to-dream'
  },
  {
    id: 2,
    title: '学习通',
    category: '学习',
    icon: 'fa-book',
    url: '/campus-activities?tab=xuexitong'
  },
  {
    id: 3,
    title: '志愿者',
    category: '公益',
    icon: 'fa-heart',
    url: '/campus-activities?tab=volunteer'
  },
  {
    id: 4,
    title: '关于我们',
    category: '信息',
    icon: 'fa-info-circle',
    url: '/campus-activities?tab=about'
  },
  {
    id: 5,
    title: '联系我们',
    category: '信息',
    icon: 'fa-envelope',
    url: '/campus-activities?tab=contact'
  }
])

// 滚动相关
let isScrolling = false
const currentSection = ref(0)
const sections = ref([])
let scrollTimeout = null
let wheelTimeout = null

// 左侧定位条相关
const isPositioningBarVisible = ref(false)
const positioningSections = ref([
  { id: 0, label: '首页', elementId: 'jumbotron-section' },
  { id: 1, label: '核心功能', elementId: 'core-features-section' },
  { id: 2, label: '热点话题', elementId: 'hot-topics-section' },
  { id: 3, label: '热门商品', elementId: 'popular-products-section' },
  { id: 4, label: '校园活动', elementId: 'campus-activities-section' }
])

// 返回顶部按钮显示状态
const showBackToTop = ref(false)

// 显示用户协议模态框状态
const showTermsModal = ref(false)

// 显示隐私政策（复用用户协议模态框）
const showPrivacyPolicy = () => {
  showTermsModal.value = true
}

// 显示使用条款（复用用户协议模态框）
const showTermsOfUse = () => {
  showTermsModal.value = true
}

// 移除 tsParticles，改为使用原生 Canvas 实现粒子效果

// 绘制抽象枫叶形状的函数
function drawMapleLeaf(ctx, x, y, size, rotation) {
  ctx.save();
  ctx.translate(x, y);
  ctx.rotate(rotation);
  
  // 绘制枫叶路径（抽象5瓣枫叶）
  ctx.beginPath();
  
  // 主叶脉
  ctx.moveTo(0, 0);
  ctx.lineTo(0, -size * 0.8);
  
  // 左1瓣
  ctx.moveTo(0, 0);
  ctx.quadraticCurveTo(-size * 0.3, -size * 0.2, -size * 0.5, -size * 0.4);
  ctx.quadraticCurveTo(-size * 0.6, -size * 0.2, -size * 0.3, 0);
  
  // 左2瓣
  ctx.moveTo(0, 0);
  ctx.quadraticCurveTo(-size * 0.2, size * 0.2, -size * 0.3, size * 0.5);
  ctx.quadraticCurveTo(-size * 0.1, size * 0.4, 0, 0);
  
  // 右1瓣
  ctx.moveTo(0, 0);
  ctx.quadraticCurveTo(size * 0.3, -size * 0.2, size * 0.5, -size * 0.4);
  ctx.quadraticCurveTo(size * 0.6, -size * 0.2, size * 0.3, 0);
  
  // 右2瓣
  ctx.moveTo(0, 0);
  ctx.quadraticCurveTo(size * 0.2, size * 0.2, size * 0.3, size * 0.5);
  ctx.quadraticCurveTo(size * 0.1, size * 0.4, 0, 0);
  
  ctx.closePath();
  ctx.restore();
}

// 粒子系统类 - 枫叶版
class Particle {
  constructor(canvas) {
    this.canvas = canvas;
    this.reset();
  }
  
  reset() {
    // 初始化粒子位置（从画布顶部进入）
    this.x = Math.random() * this.canvas.width;
    this.y = -Math.random() * 100; // 从顶部外部进入
    // 粒子大小：3-8px（枫叶需要一定大小才明显）
    this.size = 3 + Math.random() * 5;
    // 流动速度：0.8-1.5px/帧（适中，更自然）
    this.speedX = (Math.random() - 0.5) * 1; // 左右飘动
    this.speedY = 0.8 + Math.random() * 0.7; // 向下飘落
    // 旋转速度
    this.rotationSpeed = (Math.random() - 0.5) * 0.02;
    this.rotation = Math.random() * Math.PI * 2; // 初始旋转角度
    // 透明度：0.3-0.6（适中，可见但不刺眼）
    this.opacity = 0.3 + Math.random() * 0.3;
    // 颜色：枫叶红橙黄渐变（秋季主题）
    const hue = 0 + Math.random() * 40; // 0-40度，红橙黄色系
    this.color = `hsla(${hue}, 70%, 50%, ${this.opacity})`;
    // 光晕大小
    this.glow = this.size * 2;
    // 拖尾长度
    this.trailLength = 6;
    // 拖尾数组
    this.trail = [];
  }
  
  update() {
    // 更新拖尾
    this.trail.push({ x: this.x, y: this.y, rotation: this.rotation });
    if (this.trail.length > this.trailLength) {
      this.trail.shift();
    }
    
    // 移动粒子
    this.x += this.speedX;
    this.y += this.speedY;
    this.rotation += this.rotationSpeed;
    
    // 添加轻微的随机飘动效果
    this.speedX += (Math.random() - 0.5) * 0.1;
    if (this.speedX > 1.5) this.speedX = 1.5;
    if (this.speedX < -1.5) this.speedX = -1.5;
    
    // 超出边界后重置
    if (this.x < -50 || this.x > this.canvas.width + 50 || this.y > this.canvas.height + 50) {
      this.reset();
    }
  }
  
  draw(ctx) {
    // 绘制拖尾
    for (let i = 0; i < this.trail.length; i++) {
      const trailPoint = this.trail[i];
      const progress = i / this.trail.length;
      const trailOpacity = this.opacity * progress * 0.6;
      const trailSize = this.size * progress;
      
      // 拖尾枫叶
      ctx.fillStyle = this.color.replace(this.opacity, trailOpacity);
      drawMapleLeaf(ctx, trailPoint.x, trailPoint.y, trailSize, trailPoint.rotation);
      ctx.fill();
    }
    
    // 绘制粒子核心
    // 枫叶光晕
    const gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.glow);
    gradient.addColorStop(0, this.color.replace(this.opacity, this.opacity * 0.8));
    gradient.addColorStop(0.5, this.color.replace(this.opacity, this.opacity * 0.3));
    gradient.addColorStop(1, this.color.replace(this.opacity, 0));
    
    ctx.fillStyle = gradient;
    drawMapleLeaf(ctx, this.x, this.y, this.size * 1.5, this.rotation);
    ctx.fill();
    
    // 枫叶核心
    ctx.fillStyle = this.color;
    drawMapleLeaf(ctx, this.x, this.y, this.size, this.rotation);
    ctx.fill();
  }
}

// 粒子系统管理类 - 优化版
class ParticleSystem {
  constructor() {
    this.canvas = null;
    this.ctx = null;
    this.particles = [];
    this.animationId = null;
    this.isRunning = false;
  }
  
  init() {
    // 获取或创建 Canvas 元素
    let canvasElement = document.getElementById('particleCanvas');
    if (!canvasElement) {
      canvasElement = document.createElement('canvas');
      canvasElement.id = 'particleCanvas';
      canvasElement.style.position = 'fixed';
      canvasElement.style.top = '0';
      canvasElement.style.left = '0';
      canvasElement.style.width = '100%';
      canvasElement.style.height = '100%';
      canvasElement.style.zIndex = '1'; // 保持在内容下方
      canvasElement.style.pointerEvents = 'none';
      canvasElement.style.opacity = '1';
      document.body.appendChild(canvasElement);
    }
    
    this.canvas = canvasElement;
    this.ctx = this.canvas.getContext('2d');
    if (!this.ctx) {
      return;
    }
    
    this.resizeCanvas();
    
    // 创建30-40个粒子（枫叶形状更复杂，减少数量以保持性能）
    const particleCount = 30 + Math.floor(Math.random() * 11);
    this.particles = [];
    for (let i = 0; i < particleCount; i++) {
      this.particles.push(new Particle(this.canvas));
    }
    
    // 启动动画
    this.isRunning = true;
    this.animate();
    
    // 监听窗口大小变化
    window.addEventListener('resize', this.resizeCanvas.bind(this));
  }
  
  resizeCanvas() {
    if (!this.canvas) return;
    this.canvas.width = window.innerWidth;
    this.canvas.height = window.innerHeight;
    console.log(`Canvas resized to ${this.canvas.width}x${this.canvas.height}`);
  }
  
  animate() {
    if (!this.isRunning || !this.ctx) return;
    
    // 清空画布
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    
    // 更新和绘制所有粒子
    for (const particle of this.particles) {
      particle.update();
      particle.draw(this.ctx);
    }
    
    // 请求下一帧
    this.animationId = requestAnimationFrame(this.animate.bind(this));
  }
  
  destroy() {
    console.log('Destroying particle system...');
    this.isRunning = false;
    if (this.animationId) {
      cancelAnimationFrame(this.animationId);
      this.animationId = null;
    }
    window.removeEventListener('resize', this.resizeCanvas.bind(this));
    // 移除 Canvas 元素
    if (this.canvas && this.canvas.parentNode) {
      this.canvas.parentNode.removeChild(this.canvas);
    }
    this.canvas = null;
    this.ctx = null;
    this.particles = [];
  }
}

// 初始化粒子系统
const particleSystem = new ParticleSystem();

// 纸飞机动画控制
let planeAnimationId = null;
let planeProgress = 0;

// 纸飞机动画函数
const animatePlane = () => {
  const plane = document.getElementById('paperPlane');
  if (!plane) return;
  
  // 更新进度 - 减慢飞行速度
  planeProgress += 0.005;
  if (planeProgress > 1) planeProgress = 0;
  
  // 计算位置（从左下角到右上角）
  const startX = 50; // 图片左下角内部
  const endX = 600; // 图片右上角外部
  const startY = 350; // 图片左下角内部
  const endY = 50; // 图片右上角内部
  
  // 使用缓动函数使飞行更自然
  const x = startX + (endX - startX) * planeProgress;
  const y = startY + (endY - startY) * planeProgress;
  
  // 计算旋转和缩放
  const rotation = -15; // 保持固定角度，更平稳
  const scale = 1; // 保持固定大小
  
  // 保持完全可见
  let opacity = 1;
  
  // 应用变换
  plane.style.transform = `translate(${x}px, ${y}px) rotate(${rotation}deg) scale(${scale})`;
  plane.style.opacity = opacity;
  plane.style.transition = 'none'; // 禁用过渡，确保动画流畅
  
  // 请求下一帧
  planeAnimationId = requestAnimationFrame(animatePlane);
};



// 获取商品列表
const getProductList = async () => {
  try {
    loading.value = true
    
    const params = {
      pageNum: pageNum.value,
      pageSize: pageSize.value,
      categoryId: currentCategory.value,
      keyword: searchKeyword.value
    }
    
    const res = await productApi.getProductList(params)
    
    if (res.code === 200) {
      productList.value = res.data.list || []
      total.value = res.data.total || 0
      
      // 如果用户已登录，批量检查收藏状态
      if (userStore.isLogin && productList.value.length > 0) {
        await checkBatchFavoriteStatus()
      }
    }
  } catch (err) {
    console.error('获取商品列表失败:', err)
  } finally {
    loading.value = false
  }
}

// 批量检查收藏状态
const checkBatchFavoriteStatus = async () => {
  try {
    const productIds = productList.value.map(product => product.id)
    if (productIds.length === 0) return
    
    const res = await favoriteApi.batchCheckFavorite(productIds)
    if (res.code === 200) {
      // 更新收藏状态映射表
      favoriteStatusMap.value = res.data
    }
  } catch (err) {
    console.error('批量检查收藏状态失败:', err)
  }
}

// 搜索商品
const handleSearch = () => {
  pageNum.value = 1
  getProductList()
}

// 分类切换
const handleCategoryChange = (categoryId) => {
  currentCategory.value = categoryId
  pageNum.value = 1 // 重置页码
  getProductList()
}

// 监听分类变化
watch(currentCategory, () => {
  pageNum.value = 1
  getProductList()
})

// 滚动到指定区域
const scrollToSection = (index) => {
  if (isScrolling) return
  
  // 获取目标区域的元素ID
  const targetSectionId = positioningSections.value[index].elementId
  const targetSection = document.getElementById(targetSectionId)
  
  if (!targetSection) return
  
  isScrolling = true
  currentSection.value = index
  
  // 使用浏览器原生平滑滚动
  targetSection.scrollIntoView({
    behavior: 'smooth',
    block: 'start'
  })
  
  // 滚动结束后重置滚动状态
  const handleScrollEnd = () => {
    isScrolling = false
    window.removeEventListener('scroll', handleScrollEnd)
  }
  
  // 监听滚动结束事件
  window.addEventListener('scroll', handleScrollEnd)
  
  // 设置超时保险，确保滚动状态重置
  setTimeout(() => {
    isScrolling = false
    window.removeEventListener('scroll', handleScrollEnd)
  }, 1000)
}

// 获取当前滚动位置对应的区域索引
const getCurrentSectionIndex = () => {
  const scrollTop = window.scrollY
  const viewportHeight = window.innerHeight
  
  // 遍历所有区域，找到最匹配的
  for (let i = sections.value.length - 1; i >= 0; i--) {
    const section = sections.value[i]
    if (section) {
      const sectionTop = section.offsetTop
      const sectionHeight = section.offsetHeight
      const sectionBottom = sectionTop + sectionHeight
      
      // 简化检测逻辑：如果滚动位置在区域内，返回该区域
      if (scrollTop >= sectionTop - 50 && scrollTop < sectionBottom - 50) {
        return i
      }
    }
  }
  
  return 0
}

// 鼠标滚轮事件处理
const handleWheel = (e) => {
  // 添加防抖机制，防止频繁滚动造成卡顿
  if (wheelTimeout) {
    clearTimeout(wheelTimeout)
  }
  
  wheelTimeout = setTimeout(() => {
    if (isScrolling) return
    
    const scrollTop = window.scrollY
    const viewportHeight = window.innerHeight
    
    // 更新当前区域索引
    const currentIndex = getCurrentSectionIndex()
    currentSection.value = currentIndex
    
    // 获取当前区域
    const currentSectionEl = sections.value[currentIndex]
    if (!currentSectionEl) return
    
    const sectionTop = currentSectionEl.offsetTop
    const sectionHeight = currentSectionEl.offsetHeight
    const sectionBottom = sectionTop + sectionHeight
    const viewportBottom = scrollTop + viewportHeight
    
    // 检测滚动方向和是否到达区域边界
    if (e.deltaY > 0) {
      // 向下滚动
      // 只有当滚动到底部时才触发全屏滚动
      if (viewportBottom >= sectionBottom - 50) {
        e.preventDefault()
        if (currentIndex < sections.value.length - 1) {
          scrollToSection(currentIndex + 1)
        }
      }
    } else {
      // 向上滚动
      // 只有当滚动到顶部时才触发全屏滚动
      if (scrollTop <= sectionTop + 50) {
        e.preventDefault()
        if (currentIndex > 0) {
          scrollToSection(currentIndex - 1)
        }
      }
    }
  }, 50) // 50ms防抖，提高响应速度
}

// 窗口大小变化时重新计算区域位置
const handleResize = () => {
  // 更新区域引用
  sections.value = [
    document.getElementById('jumbotron-section'),
    document.getElementById('core-features-section'),
    document.getElementById('hot-topics-section'),
    document.getElementById('popular-products-section'),
    document.getElementById('campus-activities-section')
  ].filter(Boolean)
}

// 页面加载时获取数据
onMounted(() => {
  getProductList()
  
  // 初始化区域引用
  sections.value = [
    document.getElementById('jumbotron-section'),
    document.getElementById('core-features-section'),
    document.getElementById('hot-topics-section'),
    document.getElementById('popular-products-section'),
    document.getElementById('campus-activities-section')
  ].filter(Boolean)
  
  // 添加事件监听
  window.addEventListener('wheel', handleWheel, { passive: false })
  window.addEventListener('resize', handleResize)
  
  // 添加滚动事件监听，实时更新当前区域
  window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY
    
    // 获取巨幕图高度，用于判断返回顶部按钮的显示时机
    const jumbotronHeight = sections.value[0] ? sections.value[0].offsetHeight : 0
    
    // 实时更新定位条可见性：当滚动到第一个区域后显示
    isPositioningBarVisible.value = scrollTop >= 100
    
    // 返回顶部按钮显示逻辑：超过巨幕图后显示
    showBackToTop.value = scrollTop > jumbotronHeight
    
    // 只有在非滚动动画期间才更新当前区域
    if (!isScrolling) {
      currentSection.value = getCurrentSectionIndex()
    }
  })
  
  // 初始化粒子系统和纸飞机动画
  console.log('Home component mounted, initializing particles...');
  // 延迟一点时间，确保 DOM 完全渲染
  setTimeout(() => {
    particleSystem.init();
    // 启动纸飞机动画
    animatePlane();
  }, 100);
})

// 页面卸载时移除事件监听
onUnmounted(() => {
  window.removeEventListener('wheel', handleWheel)
  window.removeEventListener('resize', handleResize)
  window.removeEventListener('scroll', () => {})
  clearTimeout(scrollTimeout)
  clearTimeout(wheelTimeout)
  
  // 清理粒子系统和纸飞机动画
  particleSystem.destroy();
  // 停止纸飞机动画
  if (planeAnimationId) {
    cancelAnimationFrame(planeAnimationId);
    planeAnimationId = null;
  }
})

// 滚动到顶部
const scrollToTop = () => {
  scrollToSection(0)
}

// 处理收藏状态变化事件
const handleFavoriteChange = ({ productId, isFavorite }) => {
  // 更新收藏状态映射表
  favoriteStatusMap.value[productId] = isFavorite
}

// 根据活动分类获取对应的图标
const getActivityIcon = (category) => {
  const iconMap = {
    '科技': 'fa-microchip',
    '体育': 'fa-futbol-o',
    '文艺': 'fa-paint-brush',
    '就业': 'fa-briefcase',
    '学术': 'fa-graduation-cap',
    '公益': 'fa-heart',
    '其他': 'fa-calendar-check-o'
  }
  return iconMap[category] || 'fa-calendar-check-o'
}

// 跳转到活动页面
const goToActivity = (url) => {
  // 使用活动数据中的 URL 进行跳转
  router.push(url)
}
</script>

<style scoped>
/* 边框流光动画 */
@keyframes borderGlow {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* 纸飞机飞行动画 - 缓慢自然 */
@keyframes paperPlaneFly {
  0% {
    transform: translate(-150px, 50px) rotate(-30deg) scale(0.3);
    opacity: 0;
  }
  10% {
    opacity: 0.5;
    transform: translate(-120px, 60px) rotate(-25deg) scale(0.5);
  }
  20% {
    opacity: 1;
    transform: translate(-90px, 70px) rotate(-20deg) scale(0.7);
  }
  30% {
    transform: translate(-60px, 80px) rotate(-15deg) scale(0.85);
  }
  40% {
    transform: translate(-30px, 90px) rotate(-10deg) scale(0.95);
  }
  50% {
    transform: translate(0px, 100px) rotate(-5deg) scale(1.0);
  }
  60% {
    transform: translate(30px, 110px) rotate(0deg) scale(0.95);
  }
  70% {
    transform: translate(60px, 120px) rotate(5deg) scale(0.85);
  }
  80% {
    opacity: 1;
    transform: translate(90px, 130px) rotate(10deg) scale(0.7);
  }
  90% {
    opacity: 0.5;
    transform: translate(120px, 140px) rotate(15deg) scale(0.5);
  }
  100% {
    transform: translate(150px, 150px) rotate(20deg) scale(0.3);
    opacity: 0;
  }
}

/* 返回顶部按钮样式 */
.fixed-back-to-top {
  position: fixed;
  right: 40px;
  bottom: 60px;
  width: 50px;
  height: 50px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #FF6B9D, #FFD93D);
  color: #fff;
  border-radius: 50%;
  box-shadow: 0 4px 20px rgba(255, 107, 157, 0.3);
  transition: all 0.3s ease;
  cursor: pointer;
  font-size: 12px;
  padding: 5px;
  text-align: center;
  z-index: 9999;
  font-weight: bold;
}

.fixed-back-to-top:hover {
  transform: translateY(-5px) scale(1.1);
  box-shadow: 0 8px 30px rgba(255, 107, 157, 0.4);
}

/* 响应式设计 */
@media (max-width: 768px) {
  .fixed-back-to-top {
    width: 45px;
    height: 45px;
    right: 20px;
    bottom: 40px;
    font-size: 11px;
  }
  
  /* 小屏幕下调整区域高度 */
  .jumbotron-section,
  .core-features-section,
  #hot-topics-section,
  #popular-products-section {
    min-height: 100vh;
    height: auto;
  }
}

/* 巨幕样式 */
.jumbotron-section {
  min-height: 100vh; /* 全屏高度 */
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #fff;
  overflow: hidden;
  margin: 0;
  padding: 0;
  position: relative;
  transition: all 0.8s ease;
  margin-top: -70px; /* 负margin，与导航栏重叠，实现全屏效果 */
  padding-top: 70px; /* 补偿负margin，确保内容不被导航栏遮挡 */
}

/* 核心功能区域样式 */
.core-features-section {
  min-height: auto;
  padding: 2.5rem 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.8s ease;
  width: 100%;
}

/* 核心功能卡片悬停效果 */
.core-feature-card:hover {
  transform: translateY(-3px) !important;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

/* 热点话题区域样式 */
#hot-topics-section {
  min-height: auto;
  padding: 2.5rem 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  background-color: #f0f9ff;
}

/* 热门商品区域样式 */
#popular-products-section {
  padding: 2.5rem 0;
  background-color: #ffffff;
  min-height: auto;
  display: block;
  width: 100%;
}

/* 热点话题卡片样式改进 */
#hot-topics-section .card {
  border: 1px solid #e9ecef;
  border-radius: 8px;
  background-color: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

#hot-topics-section .card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

#hot-topics-section .card-header {
  background: linear-gradient(135deg, #FF8A5C, #FFD93D);
  color: #ffffff;
  border-bottom: 2px solid #e9ecef;
  padding: 1rem 1.5rem;
}

#hot-topics-section .card-body {
  padding: 1.25rem;
}

/* 修复列表项分隔线 - 使用更具体的选择器 */
#hot-topics-section .card-body ul.list-unstyled li {
  border-bottom: 1px solid #e0f2fe !important;
  padding-bottom: 0.75rem !important;
  margin-bottom: 0.75rem !important;
  display: block !important;
}

#hot-topics-section .card-body ul.list-unstyled li:last-child {
  border-bottom: none !important;
  padding-bottom: 0 !important;
  margin-bottom: 0 !important;
}

#hot-topics-section h4 {
  color: #333;
  font-weight: 600;
  margin-bottom: 0.25rem;
}

#hot-topics-section p {
  color: #6c757d;
  font-size: 0.9rem;
}

#hot-topics-section .bg-primary {
  background-color: #FF8A5C !important;
}

#hot-topics-section .bg-secondary-blue {
  background-color: #6B7A8F !important;
}

#hot-topics-section .text-primary {
  color: #FF8A5C !important;
}

#hot-topics-section .text-secondary-blue {
  color: #6B7A8F !important;
}

/* 各区域容器样式 */
.core-features-section .container,
#hot-topics-section .container {
  width: 100%;
  max-width: 1200px;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 1.5rem;
}

/* 热门商品容器样式 */
#popular-products-section .container {
  width: 100%;
  max-width: 1200px;
  display: flex;
  flex-direction: column;
  padding: 1.5rem;
  margin: 0 auto;
}

/* 渐变文字样式 */
.text-gradient {
  background-clip: text;
  -webkit-background-clip: text;
  color: transparent;
  background-image: linear-gradient(to right, #FF8A5C, #FFD93D);
}

/* 核心功能卡片图片容器样式 - 只应用于核心功能区域 */
.core-features-section .card-image-container {
  height: 280px;
  background-color: #f5f5f5;
  overflow: hidden;
  border-bottom: 1px solid #e0e0e0;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* 核心功能卡片图片样式 - 优化显示效果 */
.core-features-section .card-img-top {
  object-fit: contain !important;
  width: auto !important;
  height: 80% !important;
  max-width: 100%;
  transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  background-color: transparent;
  padding: 0;
  filter: brightness(1);
}

/* 图片悬停效果 */
.core-features-section .card-image-container:hover .card-img-top {
  transform: scale(1.1);
  filter: brightness(1.05);
}

/* 核心功能卡片样式 */
.core-features-section .card {
  height: 100%;
  min-height: 400px;
}

/* 热点话题卡片样式 */
#hot-topics-section .card {
  height: 100%;
  min-height: 350px;
}

/* 热门商品区域样式 */
#popular-products-section {
  min-height: auto;
  background-color: #ffffff;
  padding: 4rem 2rem;
  display: block;
  width: 100%;
}

/* 热门商品容器样式 */
#popular-products-section .container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
}

/* 校园活动区域样式 */
#campus-activities-section {
  min-height: auto;
  background-color: #fef2f2;
  padding: 2.5rem 1rem;
  display: block;
  width: 100%;
}

/* 校园活动容器样式 */
#campus-activities-section .container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
}

/* 热门商品标题区域 */
#popular-products-section .d-flex {
  margin-bottom: 2rem;
  justify-content: space-between;
  align-items: center;
}

/* 热门商品标题 */
#popular-products-section h2 {
  font-size: 2.5rem;
  font-weight: 700;
  color: #333;
  margin: 0;
}

/* 查看全部链接 */
#popular-products-section a.text-primary {
  color: #ff6b6b;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
}

#popular-products-section a.text-primary:hover {
  color: #ff5252;
}

/* 商品卡片容器样式 */
#popular-products-section .product-card-item {
  /* 确保卡片容器不影响内部布局 */
  padding: 0;
}

/* 确保ProductCard组件内部样式统一 */
#popular-products-section :deep(.bg-white) {
  background-color: #ffffff;
}

/* 确保ProductCard组件的宽度适应容器 */
#popular-products-section :deep(.rounded-lg) {
  border-radius: 8px;
}

/* 确保ProductCard组件的阴影效果 */
#popular-products-section :deep(.hover\:shadow-lg) {
  transition: all 0.3s ease;
}

/* 确保ProductCard组件的图片容器样式 */
#popular-products-section :deep(.aspect-square) {
  aspect-ratio: 1 / 1;
  overflow: hidden;
  background-color: #f8f9fa;
  border-radius: 8px 8px 0 0;
}

/* 确保ProductCard组件的图片样式 */
#popular-products-section :deep(.aspect-square img) {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

/* 确保ProductCard组件的图片悬停效果 */
#popular-products-section :deep(.aspect-square:hover img) {
  transform: scale(1.05);
}

/* 确保ProductCard组件的内容区域样式 */
#popular-products-section :deep(.p-4) {
  padding: 1rem;
}

/* 确保ProductCard组件的标题样式 */
#popular-products-section :deep(.font-medium) {
  font-weight: 600;
  font-size: 1rem;
  color: #333;
  margin-bottom: 0.5rem;
  display: block;
  text-decoration: none;
  transition: all 0.3s ease;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  min-height: 2.5rem;
}

/* 确保ProductCard组件的标题悬停效果 */
#popular-products-section :deep(.font-medium:hover) {
  color: #ff6b6b;
}

/* 确保ProductCard组件的价格样式 */
#popular-products-section :deep(.text-orange-500) {
  color: #ff6b6b;
  font-weight: 700;
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
  display: block;
}

/* 确保ProductCard组件的元信息样式 */
#popular-products-section :deep(.text-xs) {
  font-size: 0.75rem;
  color: #6c757d;
}

/* 确保ProductCard组件的分类标签样式 */
#popular-products-section :deep(.bg-orange-50) {
  background-color: #fff5f5;
  color: #ff6b6b;
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

/* 左侧固定导航菜单样式 - 独立汉堡图标形式 */
.left-fixed-nav {
  position: fixed;
  left: 15px;
  top: 50%;
  width: 40px;
  height: 40px;
  background-color: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  z-index: 999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  transition: all 0.3s ease;
  border-radius: 50%;
  cursor: pointer;
  border: none;
  outline: none;
  transform: translateY(-50%);
}

/* 汉堡菜单图标 - 使用伪元素直接绘制三条横线 */
.left-fixed-nav::before {
  content: '';
  position: absolute;
  width: 20px;
  height: 2px;
  background-color: var(--color-primary);
  border-radius: 1px;
  transition: all 0.3s ease;
  box-shadow: 0 6px 0 var(--color-primary), 0 -6px 0 var(--color-primary);
}

/* 鼠标悬停时展开为完整导航 */
.left-fixed-nav:hover {
  width: 120px;
  height: auto;
  border-radius: 8px;
  padding: 10px 0;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
}

/* 鼠标悬停时隐藏汉堡图标 */
.left-fixed-nav:hover::before {
  opacity: 0;
  visibility: hidden;
  transform: scale(0);
  margin-bottom: -10px;
}

.nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
  width: 100%;
  text-align: center;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  transform: translateY(-10px);
}

/* 鼠标悬停时显示导航列表 */
.left-fixed-nav:hover .nav-list {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.nav-list li {
  margin-bottom: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  padding: 8px 0;
  position: relative;
  user-select: none;
}

.nav-list li:last-child {
  margin-bottom: 0;
}

.nav-list li.active {
  background-color: rgba(255, 138, 92, 0.1);
}

.nav-list li:hover {
  background-color: rgba(255, 138, 92, 0.05);
}

.nav-list li.active::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 2px;
  background: linear-gradient(180deg, var(--color-primary), var(--color-secondary-yellow));
}

.nav-label {
  font-size: 12px;
  font-weight: 500;
  color: #666;
  transition: all 0.3s ease;
  white-space: nowrap;
  display: block;
  padding: 0 10px;
}

.nav-list li.active .nav-label {
  color: var(--color-primary);
  font-weight: 600;
}

.nav-list li:hover .nav-label {
  color: var(--color-primary);
}

/* 响应式设计 */
@media (max-width: 768px) {
  .left-fixed-nav {
    display: none;
  }
}

/* 主内容容器样式 */
.main-content-container {
  margin-left: 0; /* 汉堡图标是浮动的，不占据左侧空间 */
  width: 100%;
  transition: all 0.3s ease;
  flex: 1 0 auto;
  display: flex;
  flex-direction: column;
}

/* 响应式调整 */
@media (max-width: 768px) {
  .main-content-container {
    margin-left: 0;
    width: 100%;
  }
}

/* 确保页面内容在粒子效果之上 */
.main-content-container {
  position: relative;
  z-index: 1;
  background-color: white;
  flex: 1;
}

.jumbotron-section,
.core-features-section,
#hot-topics-section,
#popular-products-section,
#campus-activities-section,
footer {
  position: relative;
  z-index: 1;
}

/* 校园活动横向滚动样式 */
.activity-scroll-container {
  position: relative;
  overflow: hidden;
}

.activity-card-group {
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  scrollbar-color: var(--color-primary) transparent;
}

/* 隐藏滚动条但保留滚动功能 */
.activity-card-group::-webkit-scrollbar {
  height: 6px;
}

.activity-card-group::-webkit-scrollbar-track {
  background: transparent;
}

.activity-card-group::-webkit-scrollbar-thumb {
  background-color: var(--color-primary);
  border-radius: 3px;
}

.activity-card-group::-webkit-scrollbar-thumb:hover {
  background-color: var(--color-secondary);
}

.activity-card {
  cursor: pointer;
  transition: all 0.3s ease;
}

.activity-card:hover {
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

/* 响应式调整 */
@media (max-width: 768px) {
  .activity-card {
    width: 280px !important;
  }
}
</style>