<template>
  <div 
    class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 cursor-pointer transform hover:-translate-y-1 border border-gray-100"
    @click="goToDetail"
  >
    <!-- 物品图片 -->
    <div class="relative w-full h-48 overflow-hidden bg-gray-50">
      <img
        :src="item.coverImg || item.image || 'https://picsum.photos/200/200'"
        alt="物品图片"
        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
        @error="handleImageError"
      />
      <div v-if="imageError" class="absolute inset-0 flex items-center justify-center bg-gray-50 text-gray-500">
        暂无图片
      </div>
      <!-- 状态标签 -->
      <div class="absolute top-2 left-2">
        <span 
          class="px-3 py-1 text-xs font-medium rounded-full"
          :class="item.status === 'found' ? 'bg-success text-white' : 'bg-primary text-white'"
        >
          {{ item.status === 'found' ? '已找到' : '寻找中' }}
        </span>
      </div>
    </div>
    <!-- 物品信息 -->
    <div class="p-4">
      <div class="flex justify-between items-start mb-2">
        <h3 class="font-medium text-gray-800 text-sm line-clamp-2 mb-1 hover:text-primary transition-colors duration-300">
          {{ item.type === 'lost' ? '寻物启事：' : '失物招领：' }}{{ item.title || item.name }}
        </h3>
      </div>
      <p class="text-gray-600 text-sm mb-3 line-clamp-2">
        {{ item.description || '暂无描述' }}
      </p>
      <div class="flex justify-between items-center text-xs text-gray-500">
        <span class="bg-gray-100 px-2 py-1 rounded-full text-gray-600 font-medium">
          {{ item.location || '未知地点' }}
        </span>
        <span>{{ formattedDate }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

// 定义 props
const props = defineProps({
  item: {
    type: Object,
    required: true,
    default: () => ({})
  }
})

const router = useRouter()

// 图片错误状态
const imageError = ref(false)

// 处理图片加载错误
const handleImageError = () => {
  imageError.value = true
}

// 格式化日期 - 使用computed缓存结果，显示完整的日期和时间
const formattedDate = computed(() => {
  const date = props.item.createTime || props.item.created_at
  if (!date) return '未知时间'
  try {
    const d = new Date(date)
    return d.toLocaleString('zh-CN', {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
      hour: '2-digit',
      minute: '2-digit'
    })
  } catch (e) {
    return '未知时间'
  }
})

// 跳转到详情页
const goToDetail = () => {
  if (props.item.id) {
    router.push({ name: 'LostFoundDetail', params: { id: props.item.id } })
  }
}
</script>

<style scoped>
.bg-success {
  background-color: #28a745;
}

.bg-primary {
  background-color: #007bff;
}
</style>