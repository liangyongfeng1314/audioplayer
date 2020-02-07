import Vue from "vue";
import App from "./App.vue";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import router from "./router/router.js";

Vue.use(BootstrapVue);

// 导入迷你简南宫字体
import "./assets/font/迷你简南宫.css";
// 导入字体图标
import "./assets/icon/font-awesome-4.7.0/css/font-awesome.min.css";
Vue.config.productionTip = false;

new Vue({
  render: h => h(App),
  router
}).$mount("#app");
