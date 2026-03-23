# 校园二手交易平台

## 项目简介
校园二手交易平台是一个基于Vue 3 + Laravel的前后端分离项目，提供二手商品交易、失物招领、校园论坛、聊天等功能。

## 技术栈

### 前端
- Vue 3
- Vite
- SCSS + Bootstrap
- Pinia
- Axios

### 后端
- Laravel 9
- MySQL 8
- Sanctum 认证

## 项目结构

```
├── laravel/          # 后端代码
├── vue3/             # 前端代码
├── create_table_sql.txt  # 数据库建表SQL
├── database_schema.txt   # 数据库结构描述
└── project.txt       # 项目文档
```

## 部署指南

### 后端部署
1. 进入laravel目录
2. 配置.env文件
3. 安装依赖：`composer install`
4. 生成APP_KEY：`php artisan key:generate`
5. 数据库迁移：`php artisan migrate --seed`

### 前端部署
1. 进入vue3目录
2. 安装依赖：`npm install`
3. 配置.env.production文件
4. 构建项目：`npm run build`

## 功能模块

- ✅ 认证模块（登录、注册、忘记密码）
- ✅ 商品模块（发布、浏览、搜索、收藏、评价）
- ✅ 聊天模块（会话列表、消息发送与接收）
- ✅ 失物招领模块（发布、浏览、状态管理）
- ✅ 论坛模块（话题发布、回复、浏览）
- ✅ 校园活动模块（活动列表、详情、分类）
- ✅ 个人中心（个人信息、发布的商品、收藏的商品）
