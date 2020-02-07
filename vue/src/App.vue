<template>
  <div id="app">
    <transition name="slip">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
export default {
  name: "app",
  data() {
    return {};
  },
  mounted() {
    this.$router.push({name:'首页'});
  }
};
</script>

<style type="scss" >
html,
body {
  width: 100%;
  height: 100%;
}
*,
*::after,
*::before {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}
#app {
  height: 100%;
}
.slip-enter-active {
  transform-origin: 100% 100%;
  animation: slip-in 0.2s ease;
}
.slip-leave-active {
  transform-origin: 100% 100%; 
  animation: slip-in 0.2s   reverse ease;
}
@keyframes slip-in {
  0% {
    transform: rotateZ(90deg);
  }

  100% {
    transform: rotateZ(0deg);
  }
}
</style>
