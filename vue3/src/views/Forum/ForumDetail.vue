<template>
  <div class="container py-8">
    <div class="row">
      <!-- 左侧内容区 -->
      <div class="col-md-8">
        <!-- 话题详情卡片 -->
          <div class="card mb-6">
            <div class="card-body">
              <h1 class="h2 font-bold mb-4">{{ topic.title }}</h1>
              <div class="d-flex align-items-center text-sm text-muted mb-4">
                <img 
                  :src="(topic.author?.avatar || 'https://picsum.photos/100/100')" 
                  alt="用户头像" 
                  class="rounded-circle" 
                  style="width: 32px; height: 32px; object-fit: cover; margin-right: 8px;"
                >
                <span 
                  class="cursor-pointer text-primary-hover" 
                  @click="contactUser(topic.author?.id, topic.author?.username)"
                >
                  {{ topic.author?.username || '匿名用户' }}
                </span>
                <span class="mx-2">·</span>
                <span>{{ formatTime(topic.created_at) }}</span>
                <span class="mx-2">·</span>
                <span>{{ topic.replies_count || 0 }} 回复</span>
              </div>
              <div class="mb-6 text-gray-700">
                {{ topic.content }}
              </div>
          </div>
        </div>

        <!-- 评论区 -->
        <div class="card mb-6">
          <div class="card-body">
            <h3 class="h5 font-semibold mb-4">评论 ({{ comments.length }})</h3>
            
            <!-- 评论列表 -->
            <div v-if="loading.comments" class="text-center py-4">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 text-muted">加载评论中...</p>
            </div>
            <div v-else-if="comments.length === 0" class="text-center py-8">
              <i class="fa fa-comment-o" style="font-size: 3rem; color: #e9ecef;"></i>
              <h4 class="mt-3 text-muted">暂无评论</h4>
              <p class="text-muted">成为第一个评论的人吧！</p>
            </div>
            <div v-else class="space-y-4">
              <div v-for="comment in comments" :key="comment.id" class="border-bottom pb-4">
                <div class="d-flex align-items-start">
                  <img 
                    :src="(comment.user?.avatar || 'https://picsum.photos/100/100')" 
                    alt="用户头像" 
                    class="rounded-circle" 
                    style="width: 32px; height: 32px; object-fit: cover; margin-right: 12px; flex-shrink: 0;"
                  >
                  <div class="flex-grow-1">
                    <div class="d-flex align-items-center text-sm">
                      <strong 
                        class="cursor-pointer text-primary-hover" 
                        @click="contactUser(comment.user?.id, comment.user?.username)"
                      >
                        {{ comment.user?.username || '匿名用户' }}
                      </strong>
                      <span class="text-muted mx-2">·</span>
                      <span class="text-muted text-sm">{{ formatTime(comment.created_at) }}</span>
                    </div>
                    <p class="mt-2 text-gray-700">{{ comment.content }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- 评论输入框 -->
            <div class="mt-6">
              <h4 class="h6 font-semibold mb-3">发表评论</h4>
              <textarea 
                v-model="newComment" 
                rows="3" 
                class="form-control mb-3" 
                placeholder="写下你的评论..."
                :disabled="!isLoggedIn"
              ></textarea>
              <button 
                class="btn btn-primary" 
                @click="submitComment" 
                :disabled="!isLoggedIn || !newComment.trim()"
              >
                发表评论
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- 右侧边栏 -->
      <div class="col-md-4">
        <!-- 热门话题 -->
        <div class="card mb-6">
          <div class="card-body">
            <h2 class="h5 font-semibold mb-4">热门话题</h2>
            <div v-if="loading.hotTopics" class="text-center py-4">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 text-muted">加载中...</p>
            </div>
            <div v-else class="space-y-3">
              <div v-for="(hotTopic, index) in hotTopics" :key="hotTopic.id" class="d-flex align-items-center">
                <span class="rounded-circle bg-primary text-white d-flex align-items-center justify-center" style="width: 20px; height: 20px; font-size: 12px; font-weight: bold;">{{ index + 1 }}</span>
                <span 
                  class="ml-2 text-sm text-primary-hover cursor-pointer" 
                  @click="goToTopic(hotTopic.id)"
                >
                  {{ hotTopic.title }}
                </span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- 活跃用户 -->
        <div class="card">
          <div class="card-body">
            <h2 class="h5 font-semibold mb-4">活跃用户</h2>
            <div v-if="loading.activeUsers" class="text-center py-4">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 text-muted">加载中...</p>
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
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { forumApi } from '@/api/modules/forum'
import { chatApi } from '@/api/modules/chat'

// 路由和导航
const route = useRoute()
const router = useRouter()

// 数据状态
const topic = ref({})
const comments = ref([])
const hotTopics = ref([])
const activeUsers = ref([])
const newComment = ref('')

// 加载状态
const loading = ref({
  topic: false,
  comments: false,
  hotTopics: false,
  activeUsers: false
})

// 用户登录状态
const isLoggedIn = computed(() => !!localStorage.getItem('token'))

// 格式化时间为具体日期时间
const formatTime = (timeStr) => {
  if (!timeStr) return '未知时间'
  
  const time = new Date(timeStr)
  
  // 检查是否为有效日期
  if (isNaN(time.getTime())) return '未知时间'
  
  return time.toLocaleString('zh-CN', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// 跳转到其他话题
const goToTopic = (topicId) => {
  router.push(`/forum/topic/${topicId}`)
}

// 联系评论用户
const contactUser = async (userId, username) => {
  if (!isLoggedIn.value) {
    alert('请先登录后再联系用户')
    router.push('/login')
    return
  }
  
  try {
    // 创建或获取与评论用户的会话
    // 这里使用一个特殊的resource_type来标识是从评论来的会话
    const res = await chatApi.createConversation({
      resourceType: 'forum_comment',
      resourceId: userId // 直接使用用户ID作为resourceId
    })
    
    if (res && res.code === 200 && res.data && res.data.id) {
      // 跳转到聊天页面，并传递会话ID
      router.push({
        path: '/chat',
        query: { conversation_id: res.data.id }
      })
    } else {
      console.error('创建会话失败:', res)
      alert(res?.msg || '创建会话失败')
    }
  } catch (error) {
    console.error('联系用户失败:', error)
    alert('联系失败，请稍后重试')
  }
}

// 获取话题详情
const getTopicDetail = async () => {
  try {
    loading.value.topic = true
    const id = route.params.id
    const res = await forumApi.getTopicDetail(id)
    if (res.code === 200) {
      topic.value = res.data
    }
  } catch (err) {
    console.error('获取话题详情失败:', err)
  } finally {
    loading.value.topic = false
  }
}

// 获取评论列表
const getComments = async () => {
  try {
    loading.value.comments = true
    const id = route.params.id
    const res = await forumApi.getComments(id)
    if (res.code === 200) {
      comments.value = res.data
    }
  } catch (err) {
    console.error('获取评论失败:', err)
  } finally {
    loading.value.comments = false
  }
}

// 获取热门话题
const getHotTopics = async () => {
  try {
    loading.value.hotTopics = true
    const res = await forumApi.getHotTopics()
    if (res.code === 200) {
      hotTopics.value = res.data
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
      activeUsers.value = res.data
    }
  } catch (err) {
    console.error('获取活跃用户失败:', err)
  } finally {
    loading.value.activeUsers = false
  }
}

// 提交评论
const submitComment = async () => {
  if (!newComment.value.trim()) return
  
  try {
    const id = route.params.id
    const res = await forumApi.addComment(id, {
      content: newComment.value
    })
    if (res.code === 200) {
      // 添加新评论到列表
      comments.value.push(res.data)
      // 清空输入框
      newComment.value = ''
    }
  } catch (err) {
    console.error('提交评论失败:', err)
    alert('评论提交失败，请稍后重试')
  }
}

// 组件挂载时获取数据
onMounted(() => {
  getTopicDetail()
  getComments()
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