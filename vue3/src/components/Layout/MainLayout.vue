<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />
    <main class="flex-1 bg-background-light">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import AppHeader from './AppHeader.vue'
</script>