<template>
    <div id="browsingHistory">
        <b-container fluid class="" style="font-family:迷你简南宫;height: 100%;">
            <b-row>
                <b-col cols="12" class="text-center" style="height: 80px;line-height:80px;font-size: 32px;background: #2CA2F9;color: #FFF;border-bottom-left-radius:15px;border-bottom-right-radius:15px">
                    <span class="text-primary">
                        <i class="fa fa-history fa-1x" aria-hidden="true"></i>
                    </span>
                    最近播放
                </b-col>
            </b-row>
            <b-row>
                <b-col cols="12" class="mt-4 pl-3 pb-3" :key="key" v-for="(value,key) in browsingHistry"  style="display: flex;border-bottom: .5px dashed #999" >
                    <div class="w-75" style="text-overflow: ellipsis;overflow:hidden;white-space: nowrap">
                        <p class="m-0" style="font-size: 19px">{{value.name}}</p>
                        <p class="m-0" style="color: #AAA">{{value.author}}</p>
                    </div>
                </b-col>
            </b-row>
            <!-- 如果没有喜欢的歌曲，提示暂无喜欢的歌曲 -->
            <p class="pt-5 mt-5 text-center" v-if="!flag"  style="font-size: 35px">暂无播放记录</p>
        </b-container>
    </div>
</template>
<script>
export default {
    data(){
        return{
            flag: false, // 默认没有歌曲
            browsingHistry: [], // 记录用户的听歌记录
        }
    },  
    methods:{
        requerstBrowsingHistory(){ // 请求浏览器里面的听歌记录
            new Promise((resolved,rejected)=>{
                JSON.parse(window.localStorage.getItem('browsingHistory')).forEach((item)=>{
                    this.browsingHistry.push(item);
                })
                if(this.browsingHistry != ''){
                    resolved('请求听歌记录完成');
                    this.flag = true;
                    console.log('请求听歌记录完成');
                    console.log(this.browsingHistry);
                }else{
                    rejected('请求听歌记录失败');
                    console.log('请求听歌记录失败');
                }
            })
        }
    },
    mounted(){
        this.requerstBrowsingHistory();
    }
}
</script>
<style lang="scss" scoped>
*,*::after,*::before{
    margin: 0;
    padding: 0;
}
#browsingHistory{
    width: 100%;
    height: 100%;
}
</style>