import Vue from 'vue';
import VueRouter from 'vue-router'
Vue.use(VueRouter);
// 配置路由规则
const routes = [{
    path: '/Index',
    component: ()=>import('../components/Index.vue'),
    name: '首页'
},{
    path: '/Search', // 搜索界面
    component: ()=>import('../components/Search.vue'),
    name: '搜索界面'
},{
    path: '/Lyrics', // 歌词界面
    component: ()=>import('../components/Lyrics.vue'),
    name: '歌词界面'
},{
    path: '/LoveList', // 喜欢列表
    component: () => import('../components/LoveList.vue'),
    name: '喜欢列表'
},{
    path: 'BrowsingHistory',
    component: () => import('../components/BrowsingHistory.vue'),
    name: '浏览历史'
}]
let router = new VueRouter({
    routes
})
export default router;