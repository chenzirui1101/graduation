<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">更多</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- 联系我们 -->
      <router-link to="/more/contact">
        <Card class="hover:shadow-lg transition-shadow p-6 cursor-pointer">
          <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
              <Mail class="w-8 h-8" />
            </div>
            <div>
              <h2 class="text-xl font-semibold">联系我们</h2>
              <p class="text-muted-foreground mt-1">有问题或建议？请联系我们</p>
            </div>
          </div>
        </Card>
      </router-link>
      <!-- 关于我们 -->
      <router-link to="/more/about">
        <Card class="hover:shadow-lg transition-shadow p-6 cursor-pointer">
          <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
              <Info class="w-8 h-8" />
            </div>
            <div>
              <h2 class="text-xl font-semibold">关于我们</h2>
              <p class="text-muted-foreground mt-1">了解百事屋的故事和团队</p>
            </div>
          </div>
        </Card>
      </router-link>
    </div>
  </div>
</template>

<script setup>
import Card from '@/components/ui/Card'
import { Mail, Info } from 'lucide-vue-next'
</script>