<template>
    <div id="Search">
        <b-container fluid class="h-100" style="font-family:迷你简南宫;">
            <b-row class=" text-white" style="background: #2CA2F9">
                <b-col cols="2" class="pb-2 text-center " style="height: 42px;line-height: 42px">
                    <svg  @click="back()" style="max-width: 100%" t="1576585285909" class="icon back" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1286" width="200" height="29"><path d="M224.45 538.68l575.11-346.21-0.05-68.75-575.03 345.61-0.03 69.35z" p-id="1287" fill="#ffffff"></path><path d="M224.45 538.68l575.08 356.96v-69.52L224.48 469.33l-0.03 69.35z" p-id="1288" fill="#ffffff"></path></svg>   
                </b-col>
                <b-col cols="8" class="pb-2 px-0" style="height: 42px;line-height: 42px;position: relative;">
                    <div style="position: absolute;left: 0;right: 0;top: 15%;bottom: 0;height: 70%;background: #FFF;opacity: .2;border-radius: 15px"></div> <!--背景层-->
                    <input ref="search" type="text" class="w-100 pl-3 text-white" style="height: 95%;padding-right: 25%;border-radius: 35px;position: relative;z-index: 1" v-model="searchContent"/>
                    <svg v-if="isDelete" @click="empty()" style="position: absolute;right: 0;top: 10px;z-index: 2" t="1577502860430" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3337" width="50" height="20"><path d="M824.7 234.7l-35.4-35.4L512 476.6 234.7 199.3l-35.4 35.4L476.6 512 199.3 789.3l35.4 35.4L512 547.4l277.3 277.3 35.4-35.4L547.4 512z" p-id="3338" fill="#ffffff"></path></svg>
                </b-col>
                <b-col cols="2" class="pb-2 text-center" style="height: 42px;line-height: 42px;font-size: 18px">
                    搜索
                </b-col>
            </b-row>
            <b-row class="py-2 " @click="postDataToIndex()">
                <b-col cols="12" class="" style="display: flex;justify-content: center;align-items: center">
                    <div class=" text-center py-1" style="width: 35%;border-radius: 15px;background: #2CA2F9;color: #fff;letter-spacing: 2px">
                        本地搜索
                    </div>
                </b-col>
                <div class="py-2 mb-2 border-bottom" style="margin-left:5%;width: 98%" :key="key" v-for="(item,key) in preview">
                    <svg  t="1577502810812" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2486" width="20" height="20"><path d="M916.7 875.7L797 756c58.1-71 92.9-161.7 92.9-260.6C890 268 705.6 83.6 478.2 83.6S66.4 268 66.4 495.4s184.4 411.8 411.8 411.8c107.7 0 205.7-41.3 279.1-109l118.4 118.4c5.7 5.7 13.1 8.5 20.5 8.5s14.8-2.8 20.5-8.5c11.3-11.2 11.3-29.6 0-40.9z m-300.8-54.3c-43.6 18.4-89.9 27.8-137.7 27.8s-94.1-9.3-137.7-27.8c-42.1-17.8-80-43.3-112.5-75.8s-58-70.4-75.8-112.5c-18.4-43.6-27.8-89.9-27.8-137.7 0-47.8 9.3-94.1 27.8-137.7 17.8-42.1 43.3-80 75.8-112.5s70.4-58 112.5-75.8c43.6-18.4 89.9-27.8 137.7-27.8s94.1 9.3 137.7 27.8c42.1 17.8 80 43.3 112.5 75.8s58 70.4 75.8 112.5c18.4 43.6 27.8 89.9 27.8 137.7 0 47.8-9.3 94.1-27.8 137.7-17.8 42.1-43.3 80-75.8 112.5-32.6 32.5-70.4 58-112.5 75.8z" p-id="2487"></path></svg>
                    <span class="ml-3"  v-html="item.song"></span>
                </div>
            </b-row>
        </b-container>
    </div>
</template>
<script>
import Axios from 'axios'
export default {
    data(){
        return{
            searchContent: '', // 输入框输入的内容
            preview: [], // 预览的结果
            isDelete: false,
        }
    },
    methods:{
        back(){
            this.$router.go(-1);
        },
        search(){
            // console.log(this.preview);
                Axios.post('/audioplayer/tp5/public/index.php/user/Index/searchContent',{'searchContent':this.searchContent}) // 请求数据库返回查询的结果
                .then((res)=>{
                    this.preview = []; // 查询之前清空前面的记录
                    if(res.data != 'null'){ // 
                        res.data.forEach((item)=>{
                            item.song = item.song.replace(this.searchContent,`<span style="color:#2CA2F9">${this.searchContent}</span>`); 
                            this.preview.push(item);
                        })
                    }
                },errow=>{
                    console.log(errow);
                })
                this.isHidden();
        },
        empty(){
            this.searchContent = ''; // 情况输入框
            this.isHidden(); // 隐藏 "X"按钮
        },
        isHidden(){
            if(this.searchContent != 0){ // 如果搜索框有内容就显示"x"出来 
                this.isDelete = true; 
            }else{
                this.isDelete = false;
                this.searchContent = '';
                this.preview = [];
            }
        },
        postDataToIndex(ev){
            ev = ev || window.event;
            var target = ev.target || ev.srcElement;
            let currentNode = target.nodeName.toLocaleLowerCase();
            switch(currentNode){ // 事件源是span 
                case 'span':
                    this.dealFn(target);
                break;   
                case 'div': // 事件源是div 
                    this.dealFn(target);
                break;
            }
        },
        dealFn(target){
            if(target.innerText.length > 2){
                let seperator = target.innerText.indexOf('-');
                let songNmae =  target.innerText.substr(seperator + 1).replace(/\s/g,'');
                window.localStorage.setItem('searchResult',songNmae);
                this.$router.push({name: '首页'});
            }
        }
    },
    mounted(){
        this.$refs.search.addEventListener('input',this.search); // 给搜索框注册一个input事件，用于模糊匹配 
    }
}
</script>
<style lang="scss" scoped>
    *,*::before,*::after{
        padding: 0; 
        margin: 0;
      
    }
    #Search{
        width: 100%;
        height: 100%;    
    }
    input{
        outline: none;
        border: none;
        appearance: none;
        background: none;
    }
</style>