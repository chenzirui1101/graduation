<template>
  <div class="container py-8">
    <div class="profile-page">
      <div class="profile-header mb-8">
        <div class="card shadow-lg hover:shadow-xl transition-all duration-300">
          <div class="d-flex flex-column md:flex-row align-items-center justify-between p-6 rounded-lg" style="background-color: #fff;">
            <div class="d-flex align-items-center">
                  <div class="avatar mr-4 position-relative">
                    <div class="rounded-circle overflow-hidden border-4 border-primary shadow-lg" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                      <img
                        :src="userInfo.avatar || 'https://picsum.photos/100/100'"
                        alt="用户头像"
                        class="w-full h-full object-cover"
                      />
                    </div>
                    <div class="position-absolute bottom-0 right-0 bg-primary text-white rounded-full w-7 h-7 d-flex align-items-center justify-center shadow-md">
                      <i class="fa fa-user-circle-o"></i>
                    </div>
                  </div>
                  <div class="info">
                    <h3 class="h2 font-bold mb-2 text-primary">{{ userInfo.username }}</h3>
                    <p class="text-muted mb-1">
                      <i class="fa fa-calendar-o mr-2"></i>注册时间：{{ userInfo.created_at || '2026-03-02' }}
                    </p>
                    <p class="text-muted">
                      <i class="fa fa-envelope-o mr-2"></i>邮箱：{{ userInfo.email || '未设置' }}
                    </p>
                  </div>
                </div>
            <div class="actions mt-4 md:mt-0 d-flex flex-wrap gap-2 justify-center">
              <button class="btn btn-primary" @click="goToPublish">
                <i class="fa fa-plus mr-1"></i> 发布商品
              </button>
              <button class="btn btn-outline-primary" @click="showEditDialog">
                <i class="fa fa-pencil mr-1"></i> 编辑资料
              </button>
              <button class="btn btn-outline-danger" @click="handleLogout">
                <i class="fa fa-sign-out mr-1"></i> 退出登录
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- 内容Tab栏 -->
      <div class="profile-content mb-8">
        <div class="card shadow-lg hover:shadow-xl transition-all duration-300">
          <div class="card-header p-0">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button 
                  class="nav-link active" 
                  id="my-products-tab" 
                  data-toggle="tab" 
                  data-target="#my-products" 
                  type="button" 
                  role="tab" 
                  aria-controls="my-products" 
                  aria-selected="true"
                  @click="activeTab = 'myProducts'"
                >
                  <i class="fa fa-shopping-bag mr-1"></i> 我的发布
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button 
                  class="nav-link" 
                  id="favorite-products-tab" 
                  data-toggle="tab" 
                  data-target="#favorite-products" 
                  type="button" 
                  role="tab" 
                  aria-controls="favorite-products" 
                  aria-selected="false"
                  @click="activeTab = 'favoriteProducts'"
                >
                  <i class="fa fa-star-o mr-1"></i> 我的收藏
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button 
                  class="nav-link" 
                  id="completed-tab" 
                  data-toggle="tab" 
                  data-target="#completed" 
                  type="button" 
                  role="tab" 
                  aria-controls="completed" 
                  aria-selected="false"
                  @click="activeTab = 'completed'"
                >
                  <i class="fa fa-check-circle mr-1"></i> 已完成
                </button>
              </li>

            </ul>
          </div>
          <div class="card-body p-6">
            <div class="tab-content" id="profileTabContent">
              <!-- 我的发布 -->
              <div 
                class="tab-pane fade show active" 
                id="my-products" 
                role="tabpanel" 
                aria-labelledby="my-products-tab"
                v-if="activeTab === 'myProducts'"
              >
                <!-- 加载状态 -->
                <div v-if="loading.myProducts" class="text-center py-12">
                  <div class="spinner-border text-primary" role="status"></div>
                  <p class="mt-3 text-muted">加载中...</p>
                </div>
                
                <!-- 商品列表 -->
                <div v-else>
                  <div class="row g-4">
                    <div class="col-md-3" v-for="product in myProducts" :key="product.id">
                      <div class="h-100">
                        <ProductCard 
                          :product="product" 
                          isMine
                          @delete="getMyProducts"
                        />
                      </div>
                    </div>
                  </div>

                  <!-- 空状态 -->
                  <div v-if="myProducts.length === 0" class="text-center py-12 bg-gray-50 rounded-lg shadow-sm">
                    <div class="text-primary mb-3" style="font-size: 3rem;">
                      <i class="fa fa-shopping-bag"></i>
                    </div>
                    <h4 class="mb-2">你还没有发布任何商品</h4>
                    <p class="text-muted mb-4">开始发布你的第一个商品吧！</p>
                    <button class="btn btn-primary" @click="goToPublish">
                      <i class="fa fa-plus mr-1"></i> 发布商品
                    </button>
                  </div>
                </div>
              </div>

              <!-- 我的收藏 -->
              <div 
                class="tab-pane fade" 
                id="favorite-products" 
                role="tabpanel" 
                aria-labelledby="favorite-products-tab"
                v-if="activeTab === 'favoriteProducts'"
              >
                <!-- 加载状态 -->
                <div v-if="loading.favoriteProducts" class="text-center py-12">
                  <div class="spinner-border text-primary" role="status"></div>
                  <p class="mt-3 text-muted">加载中...</p>
                </div>
                
                <!-- 商品列表 -->
                <div v-else>
                  <div class="row g-4">
                    <div class="col-md-3" v-for="product in favoriteProducts" :key="product.id">
                      <div class="h-100">
                        <ProductCard 
                          :product="product" 
                        />
                      </div>
                    </div>
                  </div>

                  <!-- 空状态 -->
                  <div v-if="favoriteProducts.length === 0" class="text-center py-12 bg-gray-50 rounded-lg shadow-sm">
                    <div class="text-primary mb-3" style="font-size: 3rem;">
                      <i class="fa fa-star-o"></i>
                    </div>
                    <h4 class="mb-2">你还没有收藏任何商品</h4>
                    <p class="text-muted mb-4">去浏览商品并收藏你喜欢的商品吧！</p>
                    <router-link to="/secondhand" class="btn btn-primary">
                      <i class="fa fa-shopping-cart mr-1"></i> 浏览商品
                    </router-link>
                  </div>
                </div>
              </div>

              <!-- 已完成 -->
              <div 
                class="tab-pane fade" 
                id="completed" 
                role="tabpanel" 
                aria-labelledby="completed-tab"
                v-if="activeTab === 'completed'"
              >
                <!-- 加载状态 -->
                <div v-if="loading.completedProducts" class="text-center py-12">
                  <div class="spinner-border text-primary" role="status"></div>
                  <p class="mt-3 text-muted">加载中...</p>
                </div>
                
                <!-- 已完成商品列表 -->
                <div v-else>
                  <div class="row g-4">
                    <div class="col-md-3" v-for="product in completedProducts" :key="product.id">
                      <div class="h-100">
                        <ProductCard 
                          :product="product" 
                        />
                      </div>
                    </div>
                  </div>

                  <!-- 空状态 -->
                  <div v-if="completedProducts.length === 0" class="text-center py-12 bg-gray-50 rounded-lg shadow-sm">
                    <div class="text-primary mb-3" style="font-size: 3rem;">
                      <i class="fa fa-check-circle"></i>
                    </div>
                    <h4 class="mb-2">你还没有已完成的商品</h4>
                    <p class="text-muted mb-4">完成的商品会显示在这里</p>
                    <router-link to="/secondhand" class="btn btn-primary">
                      <i class="fa fa-shopping-cart mr-1"></i> 浏览商品
                    </router-link>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
      
      <!-- 编辑资料模态框 -->
      <div v-if="showEditModal" class="modal fade show" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5); display: block;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editProfileModalLabel">编辑资料</h5>
              <button type="button" class="close" @click="showEditModal = false" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="submitEdit" ref="editFormRef">
                <div class="form-group">
                  <label for="username">用户名</label>
                  <input type="text" class="form-control" id="username" v-model="editForm.username" required minlength="3" maxlength="20">
                </div>
                <div class="form-group">
                  <label for="email">邮箱</label>
                  <input type="email" class="form-control" id="email" v-model="editForm.email" required>
                </div>
                <div class="form-group">
                  <label for="avatar">头像</label>
                  <input type="file" class="form-control-file" id="avatar" accept="image/*" @change="handleAvatarChange">
                  <div class="mt-2" v-if="editForm.avatar">
                    <img :src="editForm.avatar" alt="头像预览" class="img-thumbnail" style="max-width: 150px;">
                  </div>
                </div>
                <div class="form-group">
                  <label for="oldPassword">原密码（修改密码时必填）</label>
                  <input type="password" class="form-control" id="oldPassword" v-model="editForm.oldPassword">
                </div>
                <div class="form-group">
                  <label for="newPassword">新密码（修改密码时必填）</label>
                  <input type="password" class="form-control" id="newPassword" v-model="editForm.newPassword" minlength="6">
                </div>
                <div class="form-group">
                  <label for="confirmPassword">确认新密码</label>
                  <input type="password" class="form-control" id="confirmPassword" v-model="editForm.confirmPassword" minlength="6">
                  <div class="text-danger text-sm mt-1" v-if="editForm.newPassword && editForm.newPassword !== editForm.confirmPassword">
                    两次输入的密码不一致
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="showEditModal = false">取消</button>
                  <button type="submit" class="btn btn-primary" :disabled="submitting">
                    <span v-if="submitting"><i class="fa fa-spinner fa-spin mr-1"></i>提交中...</span>
                    <span v-else>保存</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/modules/user'
import ProductCard from '@/components/ProductCard.vue'
import { productApi } from '@/api/modules/product'
import request from '@/utils/request'

const router = useRouter()
const userStore = useUserStore()

// 当前用户信息
const userInfo = ref({
  username: localStorage.getItem('username') || 'admin',
  email: '',
  avatar: '',
  created_at: ''
})

// 加载状态
const loading = ref({
  userInfo: false,
  myProducts: false,
  favoriteProducts: false,
  completedProducts: false
})

// 编辑资料对话框相关
const editFormRef = ref(null)
const submitting = ref(false)
const showEditModal = ref(false)
const editForm = ref({
  username: '',
  email: '',
  avatar: '',
  oldPassword: '',
  newPassword: '',
  confirmPassword: ''
})

// 头像上传相关
const selectedAvatarFile = ref(null)

// Tab切换相关
const activeTab = ref('myProducts')

// 我的商品列表
const myProducts = ref([])

// 我的收藏商品列表
const favoriteProducts = ref([])

// 已完成商品列表
const completedProducts = ref([])



// 获取我的发布商品
const getMyProducts = async () => {
  try {
    loading.value.myProducts = true
    const res = await productApi.getMyProducts()
    if (res.code === 200) {
      myProducts.value = res.data.list || []
    } else {
      console.error('获取我的商品失败:', res.msg)
    }
  } catch (err) {
    console.error('获取我的商品失败:', err)
    myProducts.value = []
  } finally {
    loading.value.myProducts = false
  }
}

// 获取我的收藏商品
const getFavoriteProducts = async () => {
  try {
    loading.value.favoriteProducts = true
    const res = await request({
      url: '/api/favorites',
      method: 'get'
    })
    if (res.code === 200) {
      favoriteProducts.value = res.data.list || []
    } else {
      console.error('获取我的收藏商品失败:', res.msg)
      favoriteProducts.value = []
    }
  } catch (err) {
    console.error('获取我的收藏商品失败:', err)
    favoriteProducts.value = []
  } finally {
    loading.value.favoriteProducts = false
  }
}

// 获取已完成商品
const getCompletedProducts = async () => {
  try {
    loading.value.completedProducts = true
    // 这里可以替换为实际的API调用
    // 暂时使用模拟数据
    completedProducts.value = []
  } catch (err) {
    console.error('获取已完成商品失败:', err)
    completedProducts.value = []
  } finally {
    loading.value.completedProducts = false
  }
}



// 获取用户详情
const getUserInfo = async () => {
  try {
    loading.value.userInfo = true
    const res = await request({
      url: '/api/auth/me',
      method: 'get'
    })
    if (res.code === 200) {
      userInfo.value = res.data
      localStorage.setItem('username', res.data.username)
    } else {
      console.error('获取用户详情失败:', res.msg)
    }
  } catch (err) {
    console.error('获取用户详情失败:', err)
    // 使用本地存储的用户名作为 fallback
    userInfo.value.username = localStorage.getItem('username') || 'admin'
  } finally {
    loading.value.userInfo = false
  }
}

// 显示编辑资料对话框
const showEditDialog = () => {
  // 初始化表单数据
  editForm.value = {
    username: userInfo.value.username,
    email: userInfo.value.email,
    avatar: userInfo.value.avatar,
    oldPassword: '',
    newPassword: '',
    confirmPassword: ''
  }
  // 使用Vue方式显示模态框
  showEditModal.value = true
}

// 处理头像文件选择
const handleAvatarChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    // 验证文件类型和大小
    const isImage = file.type.startsWith('image/')
    if (!isImage) {
      alert('请上传图片文件')
      return
    }
    const isLt2M = file.size / 1024 / 1024 < 2
    if (!isLt2M) {
      alert('上传头像图片大小不能超过 2MB!')
      return
    }
    
    selectedAvatarFile.value = file
    // 本地预览
    const reader = new FileReader()
    reader.onload = (e) => {
      editForm.value.avatar = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

// 提交编辑资料
const submitEdit = async () => {
  if (!editFormRef.value) return
  
  // 前端验证
  if (!editForm.value.username || editForm.value.username.length < 3) {
    alert('用户名长度在3-20个字符之间')
    return
  }
  if (!editForm.value.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(editForm.value.email)) {
    alert('请输入正确的邮箱格式')
    return
  }
  if (editForm.value.newPassword && editForm.value.newPassword.length < 6) {
    alert('新密码长度不能少于6个字符')
    return
  }
  if (editForm.value.newPassword !== editForm.value.confirmPassword) {
    alert('两次输入的密码不一致')
    return
  }
  
  try {
    submitting.value = true
    
    // 准备FormData
    const formData = new FormData()
    formData.append('username', editForm.value.username)
    formData.append('email', editForm.value.email)
    
    // 如果选择了新头像
    if (selectedAvatarFile.value) {
      formData.append('avatar', selectedAvatarFile.value)
    }
    
    // 如果填写了密码相关字段，则添加到请求数据中
    if (editForm.value.oldPassword && editForm.value.newPassword) {
      formData.append('old_password', editForm.value.oldPassword)
      formData.append('new_password', editForm.value.newPassword)
    }
    
    // 调用更新用户信息API
    const res = await request({
      url: '/api/auth/update',
      method: 'post',
      data: formData,
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    
    if (res.code === 200) {
      alert('资料更新成功')
      // 关闭模态框
      showEditModal.value = false
      
      // 更新本地用户信息
      await getUserInfo()
      
      // 清空文件输入
      if (editFormRef.value) {
        const fileInput = editFormRef.value.querySelector('#avatar')
        if (fileInput) {
          fileInput.value = ''
        }
      }
      selectedAvatarFile.value = null
    } else {
      alert(res.msg || '更新失败')
    }
  } catch (err) {
    console.error('更新用户信息失败:', err)
    alert('更新失败，请稍后重试')
  } finally {
    submitting.value = false
  }
}

// 跳转到发布页
const goToPublish = () => {
  router.push('/publish')
}

// 退出登录
const handleLogout = () => {
  if (confirm('确定退出登录吗？')) {
    userStore.logout()
    alert('退出成功')
    router.push('/')
  }
}

// 页面加载
onMounted(() => {
  getUserInfo()
  getMyProducts()
  getFavoriteProducts()
  getCompletedProducts()
})
</script>

<style scoped>
.profile-page {
  max-width: 1200px;
  margin: 0 auto;
}

/* 卡片动画效果 */
.card {
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* 按钮动画效果 */
.btn {
  transition: all 0.3s ease;
}

/* 响应式样式 */
@media (max-width: 992px) {
  .profile-page {
    padding: 0 15px;
  }
}

@media (max-width: 768px) {
  .profile-page {
    padding: 0 15px;
  }
  
  .card-header {
    text-align: center;
  }
  
  /* 调整移动端商品卡片显示数量 */
  .col-md-3 {
    flex: 0 0 50%;
    max-width: 50%;
  }
}

@media (max-width: 576px) {
  /* 移动端单列显示 */
  .col-md-3 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  
  /* 调整移动端用户信息布局 */
  .avatar {
    margin-right: 0;
    margin-bottom: 1rem;
    display: flex;
    justify-content: center;
  }
  
  .info {
    text-align: center;
  }
  
  /* 调整移动端按钮布局 */
  .actions {
    display: flex;
    flex-direction: column;
    width: 100%;
  }
  
  .btn {
    margin-bottom: 0.5rem;
  }
}

/* 空状态和加载状态样式优化 */
.text-center.py-12 {
  border-radius: 8px;
  background-color: #f8f9fa;
}

/* 标题样式优化 */
.card-header {
  border-bottom: 1px solid #e9ecef;
  padding-bottom: 1rem;
  margin-bottom: 1.5rem;
}

/* 商品卡片容器样式 */
.h-100 {
  display: flex;
  flex-direction: column;
}

/* Tab样式优化 */
.nav-tabs {
  border-bottom: 1px solid #e9ecef;
}

.nav-tabs .nav-link {
  color: #6c757d;
  border: none;
  border-radius: 0;
  padding: 12px 20px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
  color: #FF8A5C;
  background-color: #fff5f5;
}

.nav-tabs .nav-link.active {
  color: #FF8A5C;
  background-color: #fff;
  border-bottom: 2px solid #FF8A5C;
}

/* 确保ProductCard组件的图片容器样式 */
.profile-content :deep(.aspect-square) {
  aspect-ratio: 1 / 1;
  overflow: hidden;
  background-color: #f8f9fa;
  border-radius: 8px 8px 0 0;
}

/* 确保ProductCard组件的图片样式 */
.profile-content :deep(.aspect-square img) {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

/* 确保ProductCard组件的图片悬停效果 */
.profile-content :deep(.aspect-square:hover img) {
  transform: scale(1.05);
}
</style>