<template>
  <div class="container mx-auto px-4 py-8">
    <!-- 页面标题和操作区 -->
    <div class="d-flex justify-content-between align-items-center mb-6">
      <h1 class="text-3xl font-bold text-text-primary">二手交易</h1>
      <button 
        class="btn btn-primary"
        @click="goToPublish"
      >
        <i class="fa fa-plus mr-1"></i> 发布商品
      </button>
    </div>
    
    <!-- 搜索和分类筛选区 -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow-sm">
      <div class="row">
        <div class="col-md-8 mb-4 mb-md-0">
          <div class="input-group">
            <input 
              type="text" 
              class="form-control" 
              placeholder="搜索商品..." 
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
        <div class="col-md-4">
          <select 
            class="form-control" 
            v-model="currentCategory"
            @change="handleCategoryChange"
          >
            <option value="0">全部分类</option>
            <option v-for="category in categoryList" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
      </div>
    </div>
    
    <!-- 商品列表 -->
    <div class="row">
      <div v-for="product in productList" :key="product.id" class="col-sm-6 col-md-4 col-lg-3 mb-4 product-card-item d-flex">
        <div class="w-full">
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
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { productApi } from '@/api/modules/product'
import ProductCard from '@/components/ProductCard.vue'

// 分类列表
const categoryList = ref([
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
// 初始化router
const router = useRouter()

// 收藏状态映射表，key: productId, value: boolean
const favoriteStatusMap = ref({})

// 计算总页数
const totalPages = computed(() => {
  return Math.ceil(total.value / pageSize.value)
})

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
    }
  } catch (err) {
    console.error('获取商品列表失败:', err)
  } finally {
    loading.value = false
  }
}

// 处理搜索
const handleSearch = () => {
  pageNum.value = 1
  getProductList()
}

// 处理分类变化
const handleCategoryChange = () => {
  pageNum.value = 1
  getProductList()
}

// 处理分页变化
const handlePageChange = (newPage) => {
  if (newPage < 1 || newPage > totalPages.value) return
  pageNum.value = newPage
  getProductList()
}

// 处理收藏状态变化
const handleFavoriteChange = ({ productId, isFavorite }) => {
  favoriteStatusMap.value[productId] = isFavorite
}

// 跳转到发布商品页面
const goToPublish = () => {
  // 直接跳转，让路由守卫处理登录逻辑
  router.push('/publish')
}

// 页面加载时获取数据
onMounted(() => {
  getProductList()
})
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

/* 商品卡片容器样式 */
.product-card-item {
  /* 确保卡片容器不影响内部布局 */
  padding: 0;
}

/* 确保ProductCard组件内部样式统一 */
:deep(.bg-white) {
  background-color: #ffffff;
}

/* 确保ProductCard组件的宽度适应容器 */
:deep(.rounded-lg) {
  border-radius: 8px;
}

/* 确保ProductCard组件的阴影效果 */
:deep(.hover\:shadow-lg) {
  transition: all 0.3s ease;
}

/* 确保ProductCard组件的图片容器样式 */
:deep(.aspect-square) {
  aspect-ratio: 1 / 1;
  overflow: hidden;
  background-color: #f8f9fa;
  border-radius: 8px 8px 0 0;
}

/* 确保ProductCard组件的图片样式 */
:deep(.aspect-square img) {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

/* 确保ProductCard组件的图片悬停效果 */
:deep(.aspect-square:hover img) {
  transform: scale(1.05);
}

/* 确保ProductCard组件的内容区域样式 */
:deep(.p-4) {
  padding: 1rem;
}

/* 确保ProductCard组件的标题样式 */
:deep(.font-medium) {
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
:deep(.font-medium:hover) {
  color: #ff6b6b;
}

/* 确保ProductCard组件的价格样式 */
:deep(.text-orange-500) {
  color: #ff6b6b;
  font-weight: 700;
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
  display: block;
}

/* 确保ProductCard组件的元信息样式 */
:deep(.text-xs) {
  font-size: 0.75rem;
  color: #6c757d;
}

/* 确保ProductCard组件的分类标签样式 */
:deep(.bg-orange-50) {
  background-color: #fff5f5;
  color: #ff6b6b;
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
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