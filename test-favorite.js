const axios = require('axios');

// 测试获取收藏列表
async function testFavoriteList() {
  try {
    // 首先登录获取token
    const loginResponse = await axios.post('http://127.0.0.1:8000/api/auth/login', {
      username: 'testuser',
      password: 'password123'
    });
    
    const token = loginResponse.data.data.token;
    console.log('登录成功，token:', token);
    
    // 使用token获取收藏列表
    const favoriteResponse = await axios.get('http://127.0.0.1:8000/api/favorites', {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    
    console.log('\n收藏列表返回数据:', JSON.stringify(favoriteResponse.data, null, 2));
    
  } catch (error) {
    console.error('测试失败:', error.message);
    if (error.response) {
      console.error('响应数据:', JSON.stringify(error.response.data, null, 2));
    }
  }
}

testFavoriteList();