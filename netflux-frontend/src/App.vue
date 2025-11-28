<script setup>
import NavigationView from './views/NavigationView.vue';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute()
const showNav = computed(() => route.path !== '/')
</script>

<template>
  <NavigationView v-if="showNav" />
  <div class="container">
    <router-view v-slot="{ Component, route }">
      <transition name="page" mode="out-in">
        <div :key="route.path">
          <component :is="Component" />
        </div>
      </transition>
    </router-view>
  </div>
</template>

<style scoped>
.page-enter-active,
.page-leave-active {
  transition: opacity 0.8s ease;
}

.page-enter-from,
.page-leave-to {
  opacity: 0;
}
</style>
