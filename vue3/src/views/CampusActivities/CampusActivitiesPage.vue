<template>
  <div class="campus-activities-container">
    <!-- 页面标题 -->
    <div class="page-header">
      <h1 class="text-3xl font-bold">
        <i class="fa fa-calendar-check-o mr-2"></i> 校园活动
      </h1>
      <p class="text-muted">参与校园活动，丰富大学生活</p>
    </div>
    
   <div class="main-content">
      <!-- 左侧导航菜单 -->
      <div class="sidebar">
        <ul class="nav-menu">
          <li 
            class="nav-item" 
            :class="{ active: currentTab === 'to-dream' }"
            @click="currentTab = 'to-dream'"
          >
            <i class="fa fa-star mr-2"></i> 到梦活动
          </li>
          <li 
            class="nav-item" 
            :class="{ active: currentTab === 'xuexitong' }"
            @click="currentTab = 'xuexitong'"
          >
            <i class="fa fa-book mr-2"></i> 学习通
          </li>
          <li 
            class="nav-item" 
            :class="{ active: currentTab === 'volunteer' }"
            @click="currentTab = 'volunteer'"
          >
            <i class="fa fa-heart mr-2"></i> 志愿者
          </li>
          <li 
            class="nav-item" 
            :class="{ active: currentTab === 'about' }"
            @click="currentTab = 'about'"
          >
            <i class="fa fa-info-circle mr-2"></i> 关于我们
          </li>
          <li 
            class="nav-item" 
            :class="{ active: currentTab === 'contact' }"
            @click="currentTab = 'contact'"
          >
            <i class="fa fa-envelope mr-2"></i> 联系我们
          </li>
        </ul>
      </div>
      
      <!-- 右侧内容区域 -->
      <div class="content-area">
        <!-- 到梦活动 -->
        <div v-if="currentTab === 'to-dream'" class="tab-content">
          <div class="tab-header">
            <h2 class="text-2xl font-bold">到梦活动</h2>
            <p class="text-muted">参与校园活动，获取第二课堂学分</p>
          </div>
          
          <div class="activity-section">
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-star"></i>
              </div>
              <h3>活动报名</h3>
              <p>参与各类校园活动，拓展视野，丰富课余生活</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://www.5idream.net/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往到梦空间
              </button>
            </div>
            
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-certificate"></i>
              </div>
              <h3>学分管理</h3>
              <p>查看已获得的学分，规划第二课堂学习路径</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://www.5idream.net/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往到梦空间
              </button>
            </div>
            
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-trophy"></i>
              </div>
              <h3>活动评价</h3>
              <p>参与活动评价，分享你的活动体验</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://www.5idream.net/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往到梦空间
              </button>
            </div>
          </div>
        </div>
        
        <!-- 学习通 -->
        <div v-if="currentTab === 'xuexitong'" class="tab-content">
          <div class="tab-header">
            <h2 class="text-2xl font-bold">学习通</h2>
            <p class="text-muted">在线学习平台，随时随地学习</p>
          </div>
          
          <div class="activity-section">
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-book"></i>
              </div>
              <h3>在线课程</h3>
              <p>访问各类在线课程，提升专业知识和技能</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://i.chaoxing.com/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往学习通
              </button>
            </div>
            
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-clipboard"></i>
              </div>
              <h3>作业考试</h3>
              <p>完成老师布置的作业和考试，查看成绩</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://i.chaoxing.com/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往学习通
              </button>
            </div>
            
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-comments"></i>
              </div>
              <h3>课程讨论</h3>
              <p>参与课程讨论，与老师和同学交流学习心得</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://i.chaoxing.com/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往学习通
              </button>
            </div>
          </div>
        </div>
        
        <!-- 志愿者 -->
        <div v-if="currentTab === 'volunteer'" class="tab-content">
          <div class="tab-header">
            <h2 class="text-2xl font-bold">志愿者</h2>
            <p class="text-muted">参与志愿服务，传递爱心与温暖</p>
          </div>
          
          <div class="activity-section">
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-heart"></i>
              </div>
              <h3>志愿活动</h3>
              <p>参与各类志愿服务活动，奉献爱心</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://www.volunteer.csjrw.cn/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往志愿者平台
              </button>
            </div>
            
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-trophy"></i>
              </div>
              <h3>志愿时长</h3>
              <p>查看你的志愿时长和服务记录</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://www.volunteer.csjrw.cn/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往志愿者平台
              </button>
            </div>
            
            <div class="activity-card">
              <div class="activity-icon">
                <i class="fa fa-users"></i>
              </div>
              <h3>志愿团队</h3>
              <p>加入志愿团队，与志同道合的人一起服务社会</p>
              <button 
                class="btn btn-primary mt-3"
                @click="openExternalLink('https://www.volunteer.csjrw.cn/')"
              >
                <i class="fa fa-external-link mr-2"></i> 前往志愿者平台
              </button>
            </div>
          </div>
        </div>
        
        <!-- 关于我们 -->
        <div v-if="currentTab === 'about'" class="tab-content">
          <div class="tab-header">
            <h2 class="text-2xl font-bold">关于我们</h2>
            <p class="text-muted">了解校园活动平台</p>
          </div>
          
          <div class="about-section">
            <div class="about-card">
              <h3>平台介绍</h3>
              <p>校园活动平台是为大学生提供活动信息、报名参与、学分管理等服务的综合平台。</p>
            </div>
            
            <div class="about-card">
              <h3>平台愿景</h3>
              <p>致力于打造一个便捷、高效、丰富的校园活动生态系统，促进大学生全面发展。</p>
            </div>
            
            <div class="about-card">
              <h3>服务宗旨</h3>
              <p>以学生为中心，提供优质的活动资源和服务，助力大学生成长成才。</p>
            </div>
          </div>
        </div>
        
        <!-- 联系我们 -->
        <div v-if="currentTab === 'contact'" class="tab-content">
          <div class="tab-header">
            <h2 class="text-2xl font-bold">联系我们</h2>
            <p class="text-muted">如有问题，欢迎联系我们</p>
          </div>
          
          <div class="contact-section">
            <div class="contact-card">
              <div class="contact-icon">
                <i class="fa fa-envelope"></i>
              </div>
              <h3>电子邮箱</h3>
              <p>campus-activities@example.com</p>
            </div>
            
            <div class="contact-card">
              <div class="contact-icon">
                <i class="fa fa-phone"></i>
              </div>
              <h3>联系电话</h3>
              <p>010-12345678</p>
            </div>
            
            <div class="contact-card">
              <div class="contact-icon">
                <i class="fa fa-map-marker"></i>
              </div>
              <h3>办公地址</h3>
              <p>大学生活动中心301室</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'

// 获取路由对象
const route = useRoute()

// 当前选中的标签页
const currentTab = ref('to-dream')

// 监听路由查询参数变化，更新当前标签页
watch(() => route.query.tab, (newTab) => {
  if (newTab) {
    currentTab.value = newTab
  }
}, { immediate: true }) // 初始加载时也检查

// 打开外部链接
const openExternalLink = (url) => {
  window.open(url, '_blank')
}
</script>

<style scoped>
.campus-activities-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  min-height: 100vh;
  color: #ffffff;
}

/* 页面标题 */
.page-header {
  text-align: center;
  margin-bottom: 3rem;
  padding: 2rem;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.page-header h1 {
  background: linear-gradient(45deg, #fff, #f0f0f0);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  margin-bottom: 0.5rem;
}

.page-header p {
  color: rgba(255, 255, 255, 0.8);
}

/* 主要内容区域 */
.main-content {
  display: flex;
  gap: 2rem;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  padding: 2rem;
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* 左侧导航菜单 */
.sidebar {
  flex: 0 0 250px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 8px;
  padding: 1rem;
  backdrop-filter: blur(5px);
}

.nav-menu {
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav-item {
  padding: 0.8rem 1rem;
  margin-bottom: 0.5rem;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.3s ease;
  background: rgba(255, 255, 255, 0.05);
  display: flex;
  align-items: center;
  color: rgba(255, 255, 255, 0.8);
}

.nav-item:hover {
  background: rgba(255, 255, 255, 0.15);
  transform: translateX(5px);
}

.nav-item.active {
  background: linear-gradient(45deg, #ff6b6b, #ffa500);
  color: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* 右侧内容区域 */
.content-area {
  flex: 1;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 8px;
  padding: 2rem;
  backdrop-filter: blur(5px);
}

.tab-content {
  animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* 标签页标题 */
.tab-header {
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.tab-header h2 {
  margin-bottom: 0.5rem;
  background: linear-gradient(45deg, #fff, #f0f0f0);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

.tab-header p {
  color: rgba(255, 255, 255, 0.8);
}

/* 活动卡片布局 */
.activity-section {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.activity-card {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 1.5rem;
  text-align: center;
  backdrop-filter: blur(5px);
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.activity-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  background: rgba(255, 255, 255, 0.15);
}

.activity-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  background: linear-gradient(45deg, #ff6b6b, #ffa500);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

.activity-card h3 {
  margin-bottom: 0.5rem;
  color: #ffffff;
}

.activity-card p {
  margin-bottom: 1rem;
  color: rgba(255, 255, 255, 0.8);
  line-height: 1.5;
}

/* 按钮样式 */
.btn {
  border: none;
  border-radius: 6px;
  padding: 0.6rem 1.2rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-primary {
  background: linear-gradient(45deg, #667eea, #764ba2);
  color: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.btn-primary:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  background: linear-gradient(45deg, #5a6fd8, #6b4290);
}

/* 关于我们和联系我们样式 */
.about-section, .contact-section {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.about-card, .contact-card {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 1.5rem;
  backdrop-filter: blur(5px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  transition: all 0.3s ease;
}

.about-card:hover, .contact-card:hover {
  background: rgba(255, 255, 255, 0.15);
  transform: translateY(-2px);
}

.about-card h3, .contact-card h3 {
  margin-bottom: 1rem;
  color: #ffffff;
}

.about-card p, .contact-card p {
  color: rgba(255, 255, 255, 0.8);
  line-height: 1.6;
}

.contact-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  background: linear-gradient(45deg, #667eea, #764ba2);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

/* 响应式设计 */
@media (max-width: 768px) {
  .campus-activities-container {
    padding: 1rem;
  }
  
  .main-content {
    flex-direction: column;
    padding: 1rem;
  }
  
  .sidebar {
    flex: none;
    margin-bottom: 1rem;
  }
  
  .activity-section, .about-section, .contact-section {
    grid-template-columns: 1fr;
  }
}
</style>