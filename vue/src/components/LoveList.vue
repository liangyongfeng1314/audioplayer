<template>
    <div id="LoveList">
        <b-container fluid class="" style="font-family:迷你简南宫;height: 100%;">
            <b-row>
                <b-col cols="12" class="text-center" style="height: 80px;line-height:80px;font-size: 32px;background: #FA8072;color: #FFF;border-bottom-left-radius:15px;border-bottom-right-radius:15px">
                    <span ref="loves" class="text-danger" >
                        <i class="fa fa-heart fa-1x" aria-hidden="true"></i> 
                    </span>
                    我喜欢
                </b-col>
            </b-row>
            <b-row>
                <b-col cols="12" class="mt-4 pl-3 pb-3" :key="key" v-for="(value,key) in loveList"  style="display: flex;border-bottom: .5px dashed #999" >
                    <div class="w-75" style="text-overflow: ellipsis;overflow:hidden;white-space: nowrap">
                        <p class="m-0" style="font-size: 19px">{{value.name}}</p>
                        <p class="m-0" style="color: #AAA">{{value.author}}</p>
                    </div>
                    <div class="" style="display: flex;justify-content: center;align-items: center">
                        <span ref="loves" class="text-danger" >
                            <i class="fa fa-heart fa-1x" aria-hidden="true"></i> 
                        </span>
                    </div>
                </b-col>
            </b-row>
            <!-- 如果没有喜欢的歌曲，提示暂无喜欢的歌曲 -->
            <p class="pt-5 mt-5 text-center" v-if="!flag"  style="font-size: 35px">暂无喜欢的歌曲</p>
        </b-container>
    </div>
</template>
<script>
export default {
    data(){
        return{
            loveList: [], // 喜欢歌曲列表
            flag: false // 默认没有歌曲
        }
    },
    methods:{
        requerstLoveList(){ // 请求浏览器里面的"我喜欢"歌曲列表
            new Promise((resolved,rejected)=>{
                JSON.parse(window.localStorage.getItem('loveList')).forEach((item)=>{
                    this.loveList.push(item);
                })
                if(this.loveList != ''){
                    resolved('请求歌曲列表完成');
                    this.flag = true;
                    console.log('请求歌曲列表完成');
                    console.log(this.loveList);
                }else{
                    rejected('请求歌曲列表失败');
                    console.log('请求歌曲列表失败');
                }
            })
        }
    },
    mounted(){
        this.requerstLoveList();
    }
}
</script>
<style lang="scss" scoped>
*,*::after,*::before{
    margin: 0;
    padding: 0;
}
#LoveList{
    width: 100%;
    height: 100%;
}
</style> 