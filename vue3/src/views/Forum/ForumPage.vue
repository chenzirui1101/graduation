<template>
  <div class="container py-8">
    <h1 class="h1 font-bold mb-8">校园闲聊</h1>
    <div class="row">
      <!-- 左侧内容区 -->
      <div class="col-md-8">
        <div class="card mb-6">
          <div class="card-body">
            <h2 class="h4 font-semibold mb-4">最新话题</h2>
            <!-- 话题列表将通过API获取 -->
            <div v-if="loading.topics" class="text-center py-4">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 text-muted">加载话题中...</p>
            </div>
            <div v-else-if="topics.length === 0" class="text-center py-8">
              <i class="fa fa-comments-o" style="font-size: 3rem; color: #e9ecef;"></i>
              <h4 class="mt-3 text-muted">暂无话题</h4>
              <p class="text-muted">成为第一个发布话题的人吧！</p>
            </div>
            <div v-else class="space-y-4">
              <div v-for="topic in topics" :key="topic.id" class="border-bottom pb-4">
                <h3 
                  class="font-medium text-primary-hover cursor-pointer"
                  @click="goToTopicDetail(topic.id)"
                >
                  {{ topic.title }}
                </h3>
                <div class="d-flex align-items-center text-sm text-muted mt-2">
                  <span>{{ topic.author.username || '匿名用户' }}</span>
                  <span class="mx-2">·</span>
                  <span>{{ formatTime(topic.created_at) }}</span>
                  <span class="mx-2">·</span>
                  <span>{{ topic.replies_count || 0 }} 回复</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- 右侧边栏 -->
      <div class="col-md-4">
        <div class="card mb-6">
          <div class="card-body">
            <h2 class="h5 font-semibold mb-4">热门话题</h2>
            <div v-if="loading.hotTopics" class="text-center py-4">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 text-muted">加载中...</p>
            </div>
            <div v-else-if="hotTopics.length === 0" class="text-center py-4 text-muted">
              暂无热门话题
            </div>
            <div v-else class="space-y-3">
              <div v-for="(topic, index) in hotTopics" :key="topic.id" class="d-flex align-items-center">
                <span class="rounded-circle bg-primary text-white d-flex align-items-center justify-center" style="width: 20px; height: 20px; font-size: 12px; font-weight: bold;">{{ index + 1 }}</span>
                <span 
                  class="ml-2 text-sm text-primary-hover cursor-pointer"
                  @click="goToTopicDetail(topic.id)"
                >
                  {{ topic.title }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h2 class="h5 font-semibold mb-4">活跃用户</h2>
            <div v-if="loading.activeUsers" class="text-center py-4">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 text-muted">加载中...</p>
            </div>
            <div v-else-if="activeUsers.length === 0" class="text-center py-4 text-muted">
              暂无活跃用户
            </div>
            <div v-else class="space-y-3">
              <div v-for="user in activeUsers" :key="user.id" class="d-flex align-items-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-center" style="width: 32px; height: 32px; font-size: 14px; font-weight: bold;">
                  {{ user.username.charAt(0).toUpperCase() }}
                </div>
                <span class="ml-2 text-sm">{{ user.username }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { forumApi } from '@/api/modules/forum'

// 路由和导航
const router = useRouter()

// 数据状态
const topics = ref([])
const hotTopics = ref([])
const activeUsers = ref([])

// 加载状态
const loading = ref({
  topics: false,
  hotTopics: false,
  activeUsers: false
})

// 格式化时间
const formatTime = (timeStr) => {
  const now = new Date()
  const time = new Date(timeStr)
  const diff = now - time
  const minutes = Math.floor(diff / (1000 * 60))
  const hours = Math.floor(diff / (1000 * 60 * 60))
  const days = Math.floor(diff / (1000 * 60 * 60 * 24))
  
  if (minutes < 60) {
    return `${minutes} 分钟前`
  } else if (hours < 24) {
    return `${hours} 小时前`
  } else {
    return `${days} 天前`
  }
}

// 跳转到话题详情页
const goToTopicDetail = (topicId) => {
  router.push(`/forum/topic/${topicId}`)
}

// 获取话题列表
const getTopics = async () => {
  try {
    loading.value.topics = true
    const res = await forumApi.getTopics()
    if (res.code === 200) {
      topics.value = Array.isArray(res.data) ? res.data : []
    }
  } catch (err) {
    console.error('获取话题列表失败:', err)
  } finally {
    loading.value.topics = false
  }
}

// 获取热门话题
const getHotTopics = async () => {
  try {
    loading.value.hotTopics = true
    const res = await forumApi.getHotTopics()
    if (res.code === 200) {
      hotTopics.value = Array.isArray(res.data) ? res.data : []
    }
  } catch (err) {
    console.error('获取热门话题失败:', err)
  } finally {
    loading.value.hotTopics = false
  }
}

// 获取活跃用户
const getActiveUsers = async () => {
  try {
    loading.value.activeUsers = true
    const res = await forumApi.getActiveUsers()
    if (res.code === 200) {
      activeUsers.value = Array.isArray(res.data) ? res.data : []
    }
  } catch (err) {
    console.error('获取活跃用户失败:', err)
  } finally {
    loading.value.activeUsers = false
  }
}

// 组件挂载时获取数据
onMounted(() => {
  getTopics()
  getHotTopics()
  getActiveUsers()
})
</script>

<style scoped>
.text-primary-hover:hover {
  color: #ff6b6b;
  transition: all 0.3s ease;
}
</style>