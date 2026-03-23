<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">联系我们</h1>
    <Card>
      <CardContent class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <h2 class="text-xl font-semibold mb-4">联系方式</h2>
            <div class="space-y-4">
              <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary mt-1">
                  <Mail class="w-5 h-5" />
                </div>
                <div>
                  <h3 class="font-medium">邮箱</h3>
                  <p class="text-muted-foreground">contact@baishiwu.com</p>
                </div>
              </div>
              <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary mt-1">
                  <Phone class="w-5 h-5" />
                </div>
                <div>
                  <h3 class="font-medium">电话</h3>
                  <p class="text-muted-foreground">138-0000-0000</p>
                </div>
              </div>
              <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary mt-1">
                  <MapPin class="w-5 h-5" />
                </div>
                <div>
                  <h3 class="font-medium">地址</h3>
                  <p class="text-muted-foreground">北京市海淀区清华大学</p>
                </div>
              </div>
            </div>
          </div>
          <div>
            <h2 class="text-xl font-semibold mb-4">留言反馈</h2>
            <!-- 留言表单将通过API提交 -->
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium mb-1">姓名</label>
                  <input type="text" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="请输入您的姓名">
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1">邮箱</label>
                  <input type="email" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="请输入您的邮箱">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">留言内容</label>
                <textarea rows="5" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="请输入您的留言内容"></textarea>
              </div>
              <Button class="w-full text-white hover:opacity-90 transition-opacity" style="background: linear-gradient(135deg, #FF8A5C, #FFD93D);">
                提交留言
              </Button>
            </div>
          </div>
        </div>
      </CardContent>
    </Card>
  </div>
</template>

<script setup>
import Card from '@/components/ui/Card'
import CardContent from '@/components/ui/CardContent'
import Button from '@/components/ui/Button'
import { Mail, Phone, MapPin } from 'lucide-vue-next'
</script>