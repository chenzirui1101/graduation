<template>
  <!-- 登录注册模态框 - 仅在不直接显示用户协议时显示 -->
  <div v-if="!showTermsDirectly" class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content rounded shadow-lg">
        <!-- 头部 -->
        <div class="modal-header border-bottom">
          <h5 class="modal-title w-100 text-center font-weight-bold">校园百事屋</h5>
          <button type="button" class="close" @click="emit('close')">
            <span>&times;</span>
          </button>
        </div>
        
        <!-- 标签页 -->
        <div class="border-bottom">
          <ul class="nav nav-tabs">
            <li class="nav-item flex-1 text-center">
              <button 
                class="nav-link w-100 py-3 px-4 font-medium text-center"
                :class="activeTab === 'login' ? 'active border-orange text-orange' : 'text-gray-500'"
                @click="activeTab = 'login'"
              >
                登录
              </button>
            </li>
            <li class="nav-item flex-1 text-center">
              <button 
                class="nav-link w-100 py-3 px-4 font-medium text-center"
                :class="activeTab === 'register' ? 'active border-orange text-orange' : 'text-gray-500'"
                @click="activeTab = 'register'"
              >
                注册
              </button>
            </li>
          </ul>
        </div>
        
        <!-- 内容区域 -->
        <div class="modal-body p-5">
          <!-- 登录表单 -->
          <form v-if="activeTab === 'login'" @submit.prevent="handleLogin">
            <div class="form-group mb-4">
              <label for="loginUsername" class="form-label font-medium">用户名或学号</label>
              <input 
                id="loginUsername"
                v-model="loginForm.username" 
                type="text" 
                class="form-control rounded"
                placeholder="请输入用户名或学号"
                required
              />
            </div>
            
            <div class="form-group mb-4">
              <label for="loginPassword" class="form-label font-medium">密码</label>
              <input 
                id="loginPassword"
                v-model="loginForm.password" 
                type="password" 
                class="form-control rounded"
                placeholder="请输入密码"
                required
              />
            </div>
            
            <div class="form-group mb-4">
              <label for="loginCaptcha" class="form-label font-medium">验证码</label>
              <div class="row">
                <div class="col-7">
                  <input 
                    id="loginCaptcha"
                    v-model="loginForm.captcha" 
                    type="text" 
                    class="form-control rounded"
                    placeholder="请输入验证码"
                    required
                  />
                </div>
                <div class="col-5">
                  <div 
                    class="rounded cursor-pointer overflow-hidden h-10 d-flex align-items-center justify-center"
                    @click="refreshCaptcha"
                  >
                    <img 
                      v-if="captchaImage" 
                      :src="captchaImage" 
                      alt="验证码" 
                      class="h-full w-full object-cover"
                      style="height: 100%; width: 100%;"
                    />
                    <div v-else class="bg-gray-100 w-full h-full flex items-center justify-center text-gray-700">
                      点击刷新
                    </div>
                  </div>
                </div>
              </div>
              <small class="text-muted">点击验证码刷新</small>
            </div>
            
            <div class="form-group mb-4">
              <div class="form-check">
                <input 
                  id="loginAgreeTerms"
                  v-model="loginForm.agreeTerms" 
                  type="checkbox" 
                  class="form-check-input"
                  required
                />
                <label class="form-check-label" for="loginAgreeTerms">
                  我已阅读并同意 <button type="button" class="text-orange bg-transparent border-0 p-0" @click="showTermsModal = true">《用户协议》</button>
                </label>
              </div>
            </div>
            
            <button 
              type="submit"
              class="btn btn-orange w-full py-3 font-medium rounded"
              :disabled="loginLoading || !loginForm.agreeTerms"
            >
              <span v-if="loginLoading"><i class="fa fa-spinner fa-spin mr-1"></i>登录中...</span>
              <span v-else>登录</span>
            </button>
          </form>
          
          <!-- 注册表单 -->
          <form v-else-if="activeTab === 'register'" @submit.prevent="handleRegister">
            <!-- 注册方式切换 -->
            <div class="mb-4">
              <div class="btn-group w-100" role="group">
                <button 
                  type="button" 
                  class="btn flex-1"
                  :class="registerMode === 'normal' ? 'btn-orange' : 'btn-outline-secondary'"
                  @click="registerMode = 'normal'"
                >
                  普通注册
                </button>
                <button 
                  type="button" 
                  class="btn flex-1"
                  :class="registerMode === 'student' ? 'btn-orange' : 'btn-outline-secondary'"
                  @click="registerMode = 'student'"
                >
                  学号注册
                </button>
              </div>
            </div>
            
            <div class="form-group mb-4">
              <label for="registerUsername" class="form-label font-medium">用户名</label>
              <input 
                id="registerUsername"
                v-model="registerForm.username" 
                type="text" 
                class="form-control rounded"
                placeholder="请输入用户名（3-20位）"
                required
              />
            </div>
            
            <div class="form-group mb-4">
              <label for="registerName" class="form-label font-medium">姓名</label>
              <input 
                id="registerName"
                v-model="registerForm.name" 
                type="text" 
                class="form-control rounded"
                placeholder="请输入姓名"
                required
              />
            </div>
            
            <div class="form-group mb-4">
              <label for="registerStudentId" v-if="registerMode === 'student'" class="form-label font-medium">学号</label>
              <label for="registerEmail" v-else class="form-label font-medium">邮箱</label>
              <input 
                id="registerStudentId"
                v-if="registerMode === 'student'"
                v-model="registerForm.studentId" 
                type="text"
                class="form-control rounded"
                placeholder="请输入学号"
                required
              />
              <input 
                id="registerEmail"
                v-else
                v-model="registerForm.email" 
                type="email"
                class="form-control rounded"
                placeholder="请输入邮箱"
                required
              />
            </div>
            
            <div class="form-group mb-4">
              <label for="registerPassword" class="form-label font-medium">密码</label>
              <input 
                id="registerPassword"
                v-model="registerForm.password" 
                type="password" 
                class="form-control rounded"
                placeholder="请输入密码（至少6位）"
                required
                minlength="6"
              />
            </div>
            
            <div class="form-group mb-4">
              <label for="registerConfirmPassword" class="form-label font-medium">确认密码</label>
              <input 
                id="registerConfirmPassword"
                v-model="registerForm.confirmPassword" 
                type="password" 
                class="form-control rounded"
                placeholder="请确认密码"
                required
                minlength="6"
              />
              <div v-if="registerForm.password !== registerForm.confirmPassword" class="text-danger mt-1">
                两次输入的密码不一致
              </div>
            </div>
            
            <div class="form-group mb-4">
              <div class="form-check">
                <input 
                  id="registerAgreeTerms"
                  v-model="registerForm.agreeTerms" 
                  type="checkbox" 
                  class="form-check-input"
                  required
                />
                <label class="form-check-label" for="registerAgreeTerms">
                  我已阅读并同意 <button type="button" class="text-orange bg-transparent border-0 p-0" @click="showTermsModal = true">《用户协议》</button>
                </label>
              </div>
            </div>
            
            <button 
              type="submit"
              class="btn btn-orange w-full py-3 font-medium rounded"
              :disabled="registerLoading || !registerForm.agreeTerms || registerForm.password !== registerForm.confirmPassword"
            >
              <span v-if="registerLoading"><i class="fa fa-spinner fa-spin mr-1"></i>注册中...</span>
              <span v-else>注册</span>
            </button>
          </form>
        </div>
        
        <!-- 底部 -->
        <div class="modal-footer border-top py-3 text-center">
          <p class="text-sm text-gray-500 w-100 mb-0">© 2024 校园百事屋</p>
        </div>
      </div>
    </div>
  </div>
  
  <!-- 用户协议模态框 -->
  <div v-if="showTermsModal || showTermsDirectly" class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5); z-index: 2000;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content rounded shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title">用户协议及免责声明</h5>
          <button type="button" class="close" @click="handleTermsClose">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body p-5">
          <div class="space-y-3 text-gray-700">
            <p>本站为个人毕业设计作品，仅用于技术展示与非商业运营。</p>
            
            <h5 class="font-weight-bold">一、用户行为规范</h5>
            <p>用户不得利用本平台发布任何违反中华人民共和国法律法规的信息，包括但不限于：管制物品、枪支弹药、毒品、诈骗信息、赌博网站导流、色情低俗内容、侵犯他人隐私信息等。</p>
            
            <h5 class="font-weight-bold">二、责任承担</h5>
            <p>用户在本平台发布的任何信息，其真实性、合法性均由用户自行承担全部责任。用户之间因浏览信息、沟通交易产生的任何纠纷（包括但不限于欺诈、不发货、货不对板、金钱损失等），均由交易双方自行解决，本站不承担任何保证责任及连带责任。</p>
            
            <h5 class="font-weight-bold">三、信息记录</h5>
            <p>用户同意，本站有权记录并保留用户的发布信息、IP地址及操作时间，并在接到有权机关正式协查通知时提供上述数据。</p>
            
            <h5 class="font-weight-bold">四、协议接受</h5>
            <p>用户点击“注册”或“登录”按钮即视为已阅读并同意本协议全部条款。</p>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button 
            type="button" 
            class="btn btn-orange"
            @click="handleTermsClose"
          >
            同意
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/modules/user'
import request from '@/utils/request'

// Props
const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  showTermsDirectly: {
    type: Boolean,
    default: false
  }
})

// Emits
const emit = defineEmits(['close', 'success'])

// Router and Store
const router = useRouter()
const userStore = useUserStore()

// States
const activeTab = ref('login')
const registerMode = ref('normal')
const showTermsModal = ref(false)
const loginLoading = ref(false)
const registerLoading = ref(false)
const captchaImage = ref('')
const captchaKey = ref('')

// Watch for showTermsDirectly prop change
watch(() => props.showTermsDirectly, (newValue) => {
  if (newValue) {
    showTermsModal.value = true
  }
}, { immediate: true })

// Handle terms modal close
const handleTermsClose = () => {
  showTermsModal.value = false
  if (props.showTermsDirectly) {
    emit('close')
  }
}

// Login Form
const loginForm = reactive({
  username: '',
  password: '',
  captcha: '',
  agreeTerms: false
})

// Register Form
const registerForm = reactive({
  username: '',
  name: '',
  email: '',
  studentId: '',
  password: '',
  confirmPassword: '',
  agreeTerms: false
})

// Refresh Captcha
const refreshCaptcha = async () => {
  try {
    // 尝试从后端获取验证码
    const res = await request({
      url: '/api/auth/captcha',
      method: 'get',
      params: { t: Date.now() }
    })
    
    if (res.code === 200) {
      captchaKey.value = res.key;
      
      // 处理不同类型的验证码
      if (res.image) {
        // 图片验证码 - Laravel后端返回的是图片验证码
        captchaImage.value = res.image;
      } else if (res.captcha_text) {
        // 文本验证码
        captchaImage.value = '';
        // 如果需要文本验证码，可以在这里处理
      } else {
        // 没有返回验证码
        captchaImage.value = '';
      }
    } else {
      // 后端返回错误
      captchaImage.value = '';
    }
  } catch (error) {
    console.error('获取验证码失败:', error);
    captchaImage.value = '';
  }
}

// Handle Login
const handleLogin = async () => {
  if (!loginForm.agreeTerms) return
  
  try {
    loginLoading.value = true
    
    // 准备登录数据
    const loginData = {
      username: loginForm.username,
      password: loginForm.password,
      captcha: loginForm.captcha,
      captcha_key: captchaKey.value || 'test'
    }
    
    // 调用真实的登录API
    const res = await userStore.login(loginData)
    
    // 登录成功
    emit('success')
    emit('close')
  } catch (err) {
    console.error('登录失败:', err)
    
    // 简化错误处理，避免过多的弹窗
    let errorMsg = '登录失败，请重试'
    
    // 检查是否是验证码错误
    const isCaptchaError = err.response?.data?.msg?.includes('验证码') || err.response?.data?.msg?.includes('captcha')
    
    if (isCaptchaError) {
      // 验证码错误，刷新验证码并提示用户
      errorMsg = '验证码错误，请重试'
      refreshCaptcha()
    } else if (err.response?.data?.msg) {
      errorMsg = err.response.data.msg
    } else if (err.msg) {
      errorMsg = err.msg
    }
    
    alert(errorMsg)
    
    // 如果不是验证码错误，也刷新验证码
    if (!isCaptchaError) {
      refreshCaptcha()
    }
  } finally {
    loginLoading.value = false
  }
}

// Handle Register
const handleRegister = async () => {
  if (!registerForm.agreeTerms) return
  if (registerForm.password !== registerForm.confirmPassword) return
  
  try {
    registerLoading.value = true
    
    // 准备注册数据
    const registerData = {
      username: registerForm.username,
      name: registerForm.name,
      password: registerForm.password
    }
    
    // 根据注册方式添加不同字段
    if (registerMode.value === 'student') {
      registerData.studentId = registerForm.studentId
    } else {
      registerData.email = registerForm.email
    }
    
    // 调用真实的注册API
    const res = await request({
      url: '/api/auth/register',
      method: 'post',
      data: registerData
    })
    
    if (res.code === 200) {
      // 注册成功后切换到登录
      activeTab.value = 'login'
      loginForm.username = registerForm.username
      loginForm.password = registerForm.password
      alert('注册成功，请登录')
      
      // 刷新验证码
      refreshCaptcha()
    }
  } catch (err) {
    console.error('注册失败:', err)
    if (err.response?.data?.msg) {
      alert(err.response.data.msg)
    } else if (err.msg) {
      alert(err.msg)
    } else {
      alert('注册失败，请重试')
    }
  } finally {
    registerLoading.value = false
  }
}

// 组件挂载时获取验证码
refreshCaptcha()
</script>
