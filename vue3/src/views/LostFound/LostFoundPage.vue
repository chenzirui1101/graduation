<template>
  <div class="container mx-auto px-4 py-8">
    <!-- 页面标题和操作区 -->
    <div class="d-flex justify-content-between align-items-center mb-6">
      <h1 class="text-3xl font-bold text-text-primary">失物招领</h1>
      <router-link 
        to="/lostfound/publish" 
        class="btn btn-primary"
      >
        <i class="fa fa-plus mr-1"></i> 发布信息
      </router-link>
    </div>
    
    <!-- 搜索和筛选区 -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow-sm">
      <div class="row">
        <div class="col-md-6 mb-4 mb-md-0">
          <div class="input-group">
            <input 
              type="text" 
              class="form-control" 
              placeholder="搜索物品..." 
              v-model="searchKeyword"
              @input="handleSearch"
            >
            <div class="input-group-append">
              <button class="btn btn-outline-primary" @click="handleSearch">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <select 
            class="form-control" 
            v-model="currentType"
            @change="handleTypeChange"
          >
            <option value="all">全部类型</option>
            <option value="lost">寻物启事</option>
            <option value="found">失物招领</option>
          </select>
        </div>
        <div class="col-md-3">
          <select 
            class="form-control" 
            v-model="currentStatus"
            @change="handleStatusChange"
          >
            <option value="all">全部状态</option>
            <option value="looking">寻找中</option>
            <option value="found">已找到</option>
          </select>
        </div>
      </div>
    </div>
    
    <!-- 失物招领列表 -->
    <div class="row">
      <div v-for="item in lostFoundList" :key="item.id" class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <LostFoundCard :item="item" />
      </div>
    </div>
    
    <!-- 空状态 -->
    <div v-if="lostFoundList.length === 0 && !loading" class="card shadow-sm p-5 text-center">
      <div class="text-text-secondary">暂无失物招领信息</div>
    </div>
    
    <!-- 加载状态 -->
    <div v-if="loading" class="card shadow-sm p-5 text-center">
      <div class="spinner-border text-primary" role="status"></div>
    </div>
    
    <!-- 分页 -->
    <div v-if="total > 0 && !loading" class="mt-6 d-flex justify-content-center">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: pageNum === 1 }">
            <button class="page-link" @click="handlePageChange(pageNum - 1)">上一页</button>
          </li>
          <li class="page-item" :class="{ disabled: pageNum === totalPages }">
            <button class="page-link" @click="handlePageChange(pageNum + 1)">下一页</button>
          </li>
        </ul>
      </nav>
      <div class="ml-4 d-flex align-items-center">
        <span class="text-text-secondary">
          第 {{ pageNum }} / {{ totalPages }} 页，共 {{ total }} 条
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import LostFoundCard from '@/components/LostFoundCard.vue'

// 失物招领列表相关
const lostFoundList = ref([])
const loading = ref(false)
const pageNum = ref(1)
const pageSize = ref(12)
const total = ref(0)
const currentType = ref('all')
const currentStatus = ref('all')
const searchKeyword = ref('')

// 计算总页数
const totalPages = computed(() => {
  return Math.ceil(total.value / pageSize.value)
})

// 导入请求工具
import request from '@/utils/request'

// 获取失物招领列表
const getLostFoundList = async () => {
  try {
    loading.value = true
    
    // 真实API调用
    const params = {
      pageNum: pageNum.value,
      pageSize: pageSize.value,
      type: currentType.value,
      status: currentStatus.value,
      keyword: searchKeyword.value
    }
    
    // 调用失物招领API获取数据
    const res = await request({
      url: '/api/lostfound',
      method: 'get',
      params
    })
    
    if (res.code === 200) {
      lostFoundList.value = res.data.list || []
      total.value = res.data.total || 0
    } else {
      console.error('获取失物招领列表失败:', res.msg)
      lostFoundList.value = []
      total.value = 0
    }
  } catch (err) {
    console.error('获取失物招领列表失败:', err)
    lostFoundList.value = []
    total.value = 0
  } finally {
    loading.value = false
  }
}

// 处理搜索
const handleSearch = () => {
  pageNum.value = 1
  getLostFoundList()
}

// 处理类型筛选
const handleTypeChange = () => {
  pageNum.value = 1
  getLostFoundList()
}

// 处理状态筛选
const handleStatusChange = () => {
  pageNum.value = 1
  getLostFoundList()
}

// 处理分页变化
const handlePageChange = (newPage) => {
  if (newPage < 1 || newPage > totalPages.value) return
  pageNum.value = newPage
  getLostFoundList()
}

// 页面加载时获取数据
getLostFoundList()
</script>

<style scoped>
/* 自定义样式 */
.container {
  max-width: 1200px;
}

.text-text-primary {
  color: var(--color-primary);
}

.text-text-secondary {
  color: var(--color-text-secondary);
}

/* 响应式调整 */
@media (max-width: 768px) {
  h1 {
    font-size: 2rem;
  }
  
  .row {
    --bs-gutter-x: 1rem;
  }
}
</style>