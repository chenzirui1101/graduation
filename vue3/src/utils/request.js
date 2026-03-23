import axios from 'axios'
import { useUserStore } from '@/stores/modules/user.js'

// 创建Axios实例
const service = axios.create({
  // 修改这里：后端地址是 http://127.0.0.1:8000，不需要加 /api
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000',
  timeout: 30000, // 增加超时时间到30秒
  withCredentials: true,
  headers: {
    'Content-Type': 'application/json;charset=utf-8'
  }
})

// 请求拦截器
service.interceptors.request.use(
  (config) => {
    // 获取token（Pinia使用）
    const userStore = useUserStore()
    const token = userStore.token || localStorage.getItem('token')
    
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    
    // 调试用：打印请求信息
    console.log('请求:', config.method.toUpperCase(), config.url, config.data || config.params)
    
    return config
  },
  (error) => {
    if (import.meta.env.MODE === 'development') {
      alert('请求异常，请重试')
    }
    return Promise.reject(error)
  }
)

// 响应拦截器
service.interceptors.response.use(
  (response) => {
    // 只在开发环境打印响应信息，减少生产环境的日志
    if (import.meta.env.MODE === 'development') {
      console.log('响应:', response.config.method.toUpperCase(), response.config.url, response.data)
    }
    
    const res = response.data
    
    // 处理后端返回的格式
    // 如果返回的是文件流，直接返回
    if (response.config.responseType === 'blob') {
      return response
    }
    
    // 根据后端实际返回格式处理
    if (res.code === 200) {
      return res
    } else {
      // 业务状态码非200
      // 只在开发环境显示错误信息
      if (import.meta.env.MODE === 'development') {
        alert(res.msg || '请求失败')
      }
      
      // 401未授权，跳转登录
      if (res.code === 401) {
        if (confirm('登录已过期，请重新登录')) {
          const userStore = useUserStore()
          userStore.logout()
          // 使用Vue Router跳转到登录页，避免页面刷新
          const router = window.router
          if (router) {
            router.push('/login')
          } else {
            // 降级方案：如果router不可用，使用window.location
            window.location.href = '/login'
          }
        }
      }
      return Promise.reject(new Error(res.msg || '请求失败'))
    }
  },
  (error) => {
    // 只在开发环境打印详细错误信息
    if (import.meta.env.MODE === 'development') {
      console.error('响应错误:', error)
    }
    
    // 处理 HTTP 状态码
    if (error.response) {
      const status = error.response.status
      const data = error.response.data
      
      switch (status) {
        case 401:
          // 只在开发环境显示，生产环境直接跳转
          if (import.meta.env.MODE === 'development') {
            alert('未授权，请重新登录')
          }
          const userStore = useUserStore()
          userStore.logout()
          // 使用Vue Router跳转到登录页，避免页面刷新
          const router = window.router
          if (router) {
            router.push('/login')
          } else {
            // 降级方案：如果router不可用，使用window.location
            window.location.href = '/login'
          }
          break
        case 403:
          if (import.meta.env.MODE === 'development') {
            alert('没有权限访问')
          }
          break
        case 404:
          if (import.meta.env.MODE === 'development') {
            alert('请求的资源不存在')
          }
          break
        case 422:
          // 验证错误，显示具体信息
          const msg = data?.msg || data?.message || '数据验证失败'
          if (import.meta.env.MODE === 'development') {
            alert(msg)
          }
          break
        case 500:
          if (import.meta.env.MODE === 'development') {
            alert('服务器内部错误')
          }
          break
        default:
          // 只在开发环境显示其他错误
          if (import.meta.env.MODE === 'development') {
            alert(data?.msg || `请求失败 (${status})`)
          }
      }
    } else if (error.request) {
      // 请求发出但没有收到响应
      // 检查是否是登录页面或个人中心页面的请求
      const isAuthRequest = error.config?.url?.includes('/api/auth')
      const isFavoriteRequest = error.config?.url?.includes('/api/favorites')
      const isChatRequest = error.config?.url?.includes('/api/chat')
      
      // 只在开发环境显示连接错误，或者非授权/收藏/聊天相关的请求
      if (import.meta.env.MODE === 'development' && !isAuthRequest && !isFavoriteRequest && !isChatRequest) {
        alert('无法连接到服务器，请检查后端服务是否启动')
      }
    } else {
      // 请求配置出错
      if (import.meta.env.MODE === 'development') {
        alert('请求配置错误: ' + error.message)
      }
    }
    
    return Promise.reject(error)
  }
)

export default service