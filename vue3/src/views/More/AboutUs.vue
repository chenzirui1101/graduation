<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">关于我们</h1>
    <Card>
      <CardContent class="p-6">
        <div class="space-y-6">
          <div>
            <h2 class="text-xl font-semibold mb-3">关于百事屋</h2>
            <p class="text-muted-foreground leading-relaxed">
              百事屋是一个面向大学生的校园生活服务平台，致力于为同学们提供便捷、安全的二手交易、校园闲聊、失物招领等服务。
              我们的愿景是打造一个充满活力和温暖的校园社区，让每一位同学都能在这里找到所需，分享快乐。
            </p>
          </div>
          <div>
            <h2 class="text-xl font-semibold mb-3">我们的使命</h2>
            <p class="text-muted-foreground leading-relaxed">
              连接校园里的每一个人，让闲置资源得到有效利用，让信息传递更加顺畅，让校园生活更加丰富多彩。
            </p>
          </div>
          <div>
            <h2 class="text-xl font-semibold mb-3">团队介绍</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
              <div v-for="i in 3" :key="i" class="text-center">
                <Avatar class="w-24 h-24 mx-auto mb-3">
                  <AvatarFallback class="text-2xl">{{ i }}</AvatarFallback>
                </Avatar>
                <h3 class="font-medium">团队成员 {{ i }}</h3>
                <p class="text-sm text-muted-foreground mt-1">开发人员</p>
              </div>
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
import Avatar from '@/components/ui/Avatar'
import AvatarFallback from '@/components/ui/AvatarFallback'
</script>