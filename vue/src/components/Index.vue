<template>
  <div id="Index">
    <b-container fluid  class="ps-r" style="font-family:迷你简南宫;height: 100%;overflow:hidden">
      <!-- <button @click="addSongListClick()">获取歌曲列表</button> -->
    <!--标题-->
      <b-row class="bg-2CA2F9 p-2" >
        <b-col cols="12" class="text-center text-white p-2" style="font-size:20px">
            音乐播放器
        </b-col>
    <!--搜索框-->
        <b-col cols="12" class="ps-r pb-1" @click="search()">
          <b-form-input
            class="font-size-16"
            style="height: 32px;filter:opacity(50%);border-radius: 32px"
            disabled
          ></b-form-input>
          <span class="ps-a text-white" style="top:5.8px;left:40%">
            <i class="fa fa-search" ></i>
          </span>  
          <span class="ps-a text-white" style="top:5px;padding-left:42%">
            搜索
          </span>
        </b-col>
      </b-row> 
      <!--我喜欢 - 用户添加歌曲到我喜欢列表 | 最近播放 - 用户播放歌曲的最近播放-->
      <b-row class="mt-2">
        <b-col cols="6" class="border" style="height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center" @click="loveList()">
          <span class="text-danger">
            <i class="fa fa-heart fa-3x" aria-hidden="true"></i>
          </span>
          <b-row>
            <b-col cols="12">
              我喜欢
            </b-col> 
          </b-row>
        </b-col>
        <b-col cols="6" class="border text-center" style="height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center" @click="browsingHistory()">
          <span class="text-primary">
            <i class="fa fa-history fa-3x" aria-hidden="true"></i>
          </span>
          <b-row>
            <b-col cols="12">
              最近播放
            </b-col>
          </b-row>
        </b-col>
      </b-row>
      <b-row class="mt-2"> <!--歌曲列表-->
        <b-col cols="12" ref="songList" class=" py-2" style="height: 70px;display:flex" :key="index" v-for="(item,index) in songList">
          <div class="poster" style="height: 100%;width: 20%;">
            <img ref="poster_src" :src="item.poster_src" alt="error" style="max-width:100%;max-height:100%;width: 100%;height:100%;border-radius:15px"> <!--海报-->
          </div>
            <div class="songInfo pl-2" style="width: 60%;height: 100%;"> <!--歌曲信息-->
            <p class="p-0 m-0" ref="name" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;font-size: 19px">{{item.name}}</p> <!--歌曲名-->
            <p class="p-0 m-0 songs" ref="songs" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;color: #AAAAAA">{{item.song}}</p> <!--有作者的歌名-->
          </div>
          <div class="p-2 ml-2 love " style="display: flex;align-items: center;justify-content: center"> <!-- "我喜欢" 图标-->
            <span ref="loves" class="" style="color: #AAAAAA;" > 
              <i class="fa fa-heart fa-1x" aria-hidden="true"></i> 
            </span>
          </div>
          <p hidden ref="author">{{item.author}}</p> <!--获取歌曲的作者 但是不显示出来--> <!--author audio_src name poster_src-->
          <p hidden ref="audio_src">{{item.audio_src}}</p> <!--获取歌曲的播放路径-->
        </b-col>
      </b-row>
      <!--播放器操作界面-->
      <b-row class=" w-100 py-0" style="position:fixed;bottom: 0;height:73px;background: #fff" >
        <b-col cols="12">
          <b-row class="ps-r">
            <b-col cols="2" class=" ps-a px-1 py-1  text-center poster" style="height:65px;top: -10px;border-radius:65px;background:#FFFACD" @click="lyrics()">
              <img  ref="poster_img" src=""  style="max-width:100%;max-height: 100%;width: 100%;height: 100%;border-radius:65px;background-repeat:no-repeat"/> <!--操作界面的当前歌曲海报-->
            </b-col>
            <b-col cols="10" sm="10" class="pl-4 pr-4 offset-2" >
              <b-row class="">
                <b-col cols="12" class="px-0  pt-2 ps-r" style="height:20px">
                  <!--进度条-->
                  <div class="progressBar bg-danger" style="height:2px;width:100%" ref="originProgressBarBg" ></div>
                  <div class="progressBar bg-primary" style="height:3px;width:0;margin-top:-2px;z-index:1314"  ref="progressBarBg"></div>
                  <!--移动的点-->
                  <div class="ps-a bg-primary progressPoint" style="top:5px;width:7px;height:10px;border-radius:50%;left:0" ref="progressBar" ></div>
                </b-col>
                <b-col class="px-3 ">
                  <b-row class="">
                    <b-col cols="4" class=" px-0 py-0 " style="overflow:hidden;text-overflow:ellipsis;white-space: nowrap;max-width:100%">
                      <span ref="player_title"  class=""></span><br> <!--歌曲名称-->
                      <span ref="player_author" style="margin-top: -6px;display:block"></span> <!--歌曲作者-->
                    </b-col>
                    <b-col class="">
                      <b-row class="mx-0 my-0 " style="height:45px">
                        <b-col offset="3" class="px-2 " @click="plalyer()" ref="player">
                          <svg style="width:100%;height:100%;max-height:100%;max-width:100%" t="1576401147186" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4385" width="200" height="200"><path d="M226.592 896C167.616 896 128 850.48 128 782.736V241.264C128 173.52 167.616 128 226.592 128c20.176 0 41.136 5.536 62.288 16.464l542.864 280.432C887.648 453.792 896 491.872 896 512s-8.352 58.208-64.272 87.088L288.864 879.536C267.712 890.464 246.768 896 226.592 896z m0-704.304c-31.008 0-34.368 34.656-34.368 49.568v541.472c0 14.896 3.344 49.568 34.368 49.568 9.6 0 20.88-3.2 32.608-9.248l542.864-280.432c21.904-11.328 29.712-23.232 29.712-30.608s-7.808-19.28-29.712-30.592L259.2 200.96c-11.728-6.048-23.008-9.264-32.608-9.264z" p-id="4386"></path></svg>
                        </b-col>
                        <b-col class="px-2">
                          <svg v-on:click="nextSong()" style="width:100%;height:100%;max-height:100%;max-width:100%" t="1576409816596" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5196" width="200" height="200"><path d="M832 160.128c0-17.664-14.336-32-32-32S768 142.464 768 160.128l0 282.88L214.592 134.592c-18.176-10.112-39.936-10.048-58.112 0C138.24 144.768 127.424 162.88 127.424 183.168l0 656.64c0 20.224 10.816 38.464 29.056 48.576C165.568 893.44 175.488 896 185.472 896s19.968-2.56 29.056-7.616L768 579.968l0 284.096c0 17.664 14.336 32 32 32s32-14.336 32-32L832 160.128zM191.808 829.248 188.672 192l573.312 319.488L191.808 829.248z" p-id="5197"></path></svg>
                        </b-col>
                        <b-col class="px-2" @click="lyricsList()">
                          <svg @click="showPlayerList()" style="width:100%;height:100%;max-height:100%;max-width:100%" t="1576410021021" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="10488" width="200" height="200"><path d="M916.696 207.992H336.416a30.104 30.104 0 0 1 0-60.208h580.28a30.096 30.096 0 0 1 30.104 30.104 30.096 30.096 0 0 1-30.104 30.104zM916.696 543.216H336.416c-16.624 0-30.104-13.464-30.104-30.104s13.48-30.104 30.104-30.104h580.28c16.64 0 30.104 13.464 30.104 30.104s-13.464 30.104-30.104 30.104zM916.696 878.456H336.416a30.104 30.104 0 1 1 0-60.216h580.28c16.64 0 30.104 13.464 30.104 30.104s-13.464 30.112-30.104 30.112z" fill="#2c2c2c" p-id="10489"></path><path d="M215.768 207.992H113.344a30.104 30.104 0 0 1 0-60.208h102.424a30.104 30.104 0 0 1 0 60.208zM215.768 543.216H113.344c-16.624 0-30.104-13.464-30.104-30.104s13.48-30.104 30.104-30.104h102.424c16.624 0 30.104 13.464 30.104 30.104s-13.48 30.104-30.104 30.104zM215.768 878.456H113.344a30.104 30.104 0 1 1 0-60.216h102.424a30.104 30.104 0 1 1 0 60.216z" fill="#2c2c2c" p-id="10490"></path></svg>
                        </b-col>
                      </b-row>
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
      <!--  "心形" 变红我们出现一个提示框-->
      <b-row ref="hotHeartToastr" class="" style="position:absolute;left:50%;top:50%;margin-left: -80px;display: none">
        <b-col cols="12" class="" style="position:absolute;top:0;right:0;bottom:0;left:0;background: #000;opacity: .8"> <!--背景层-->
        </b-col>
        <b-col cols="12" class="text-white " style="height:40px;display:flex;justify-content: center;align-items:center;font-size: 22px">
            <span class="text-danger" style="">
              <i class="fa fa-heart" aria-hidden="true" style="height: 100%;max-height: 100%"></i>
            </span>
            <span class="pl-2" style="font-size: 18px;">添加成功</span>  
        </b-col>
      </b-row>
      <!-- 播放列表 弹出层 -->
      <b-row class="p-0 m-0" style="position: absolute;top: 0;right: 0;bottom: 0;left: 0;z-index: -1314" ref="controlPanel" @click="hiddenPlayerPage()">
        <b-col  ref="listenList" cols="12" class=" px-0" style="position: absolute;bottom: -50%;left: 0;right: 0;height: 50%;background:#fff; border-top-left-radius: 15px;border-top-right-radius: 15px;overflow: scroll">
          <div class=" py-2 px-2 pl-3" style="position: -webkit-sticky;position: sticky;top :0px;border-top-left-radius: 15px;border-top-right-radius: 15px;background:#fff;" ref="cutPattern" @click="cutPattern()"> <!--切换模式-->
            <img src="../assets/icon/顺序播放.png" alt="" style="max-height: 100%;max-width: 100%;width: 9%;height: 9%">
            <span class="ml-2">顺序播放</span>
          </div>
          <div ref="listSong" class="pt-2 px-2  " style="display: flex;flex-direction: row" :key="key" v-for="(item,key) in this.recordBrowsingHistory">
            <img :src="item.poster_src" alt="" style="width: 15%;height: 55px;border-radius: 50%;">
            <p class="ml-2" style="display: flex;flex-direction: column">
              <span>{{item.name}}</span>
              <span>{{item.author}}</span>
            </p>
          </div>
        </b-col>
      </b-row>
      <!--音频控制器-->
      <audio ref="audio" src=""></audio>
    </b-container>
  </div>
</template>
<script>
import Axios from 'axios'
import Vue from 'vue'
export default {
  name: 'Index',
  data(){
    return{
      showValue: '',
       position : {
        oriOffsetLeft: 0, //移动开始的时候进度条点距离进度条的偏移量
        oriX: 0, // 移动开始时候的X坐标
      },
      flag: false, // 是否开始移动
      songList: [], // 歌曲  
      isLoveList: [], // 记录哪首歌用户点击了喜欢的一些信息(歌名、歌手、是否喜欢、歌曲的播放路径)
      recordBrowsingHistory: [], // 记录用户的听歌记录
      currentPlayerStatus: 0, // 记录当前播放状态 0 表示顺序播放
      playerPattern: [ // 播放的模式
       {
         name: '顺序播放',
         img_src: 'data:image/png;base64,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'
       },
       {
        name: '随机播放',
        img_src: '/img/随机播放.fc8ba89a.png'
       },
       {
         name: '单曲循环',
         img_src: 'data:image/png;base64,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'
       }
      ],
      isLoop: false, // 是否循环播放
      isRandom: false, // 是否随机播放
      isOrder: true, // 是否顺序播放 默认是顺序播放
      currentListen: 0, // 当前用户听着歌曲列表里面的第几首
    }
  },
  components: {
  },
  methods:{
    search(){
      this.$router.push({path: '/Search'});
    },
    loveList(){ // 喜欢列表入口
      this.$router.push({name: '喜欢列表'})
    },
    browsingHistory(){
      this.$router.push({name: '浏览历史'})
    },
     lyrics(){
        this.$router.push({path:'/Lyrics'})
    },
    updatetime(){ // 音频播放位置改变 进度条和进度点一起改变 
      try{
        let value = (this.$refs.audio.currentTime /this.$refs.audio.duration) * 100;
        this.cpp(value);
      }catch(e){
         new Error(e);
      }
    },
    jumpPosition(e){
       let pgbw = this.$refs.originProgressBarBg.offsetWidth; // 进度条背景的宽度
       let rate = e.offsetX / pgbw; // 鼠标在进度条那个位置
       let changeValue = rate * 100; // 存储移动之后的进度条的宽度和进度点的位置
       this.$refs.audio.currentTime = this.$refs.audio.duration * rate;
       this.cpp(changeValue);
    },
    touchestart(event){
         this.flag = true;
         this.position.oriOffsetLeft = this.$refs.progressBar.offsetLeft; // 记录开始触摸的点
         this.position.oriX =  event.touches[0].clientX; // 移动开始时的x轴坐标
        // 禁止事件冒泡
        if (event && event.stopPropagation) {
            event.stopPropagation();
        } else {
            window.event.cancelBubble = true;
        }
    },
    touchmove(event){
           if(this.flag == true){
            let clientX = event.touches[0].clientX; // 鼠标距可视区域X轴距离
            var length = clientX - this.position.oriX; // 进度条用户移动的距离.两个点会产生距离，just like u
            let pgsWidth = this.$refs.originProgressBarBg.offsetWidth; // 源进度条总宽度
            // 点原先的距离+用户移动的距离/进度条总宽度
            let rate = (this.position.oriOffsetLeft + length) / pgsWidth; 
            this.$refs.audio.currentTime = this.$refs.audio.duration * rate;
            let moveDistance = rate * 100;
            if(moveDistance > 100){
              moveDistance = 100;
            }
            this.cpp(moveDistance);
        }
    } ,
    cpp(value){ // change(改变) - progressBar(进度条) - progressPoint(进度点)
        try{
          this.$refs.progressBarBg.style.cssText += `;width: ${value}%;`; // 进度条
          this.$refs.progressBar.style.cssText += `;left: ${value}%;`; // 进度点
        }catch(e){
          new Error(e);
        }
    },
    plalyer(){
      this.isPlay();
    },
    getSongs(){ // 请求歌词信息
      new Promise((resolve)=>{
        Axios.get('/audioplayer/tp5/public/index.php/user/Index/getSongs').then((res)=>{
          res.data.map((item,index)=>{
            item.poster_src = require(`../assets/poster/${item.poster_name}.${item.poster_subfix}`); // 组装海报的路径
            // 组装audio_src路径成为可以访问的地址
            let lastDash = item.audio_src.lastIndexOf('/'); // 获取破折号 "/"最后出现的位置
            let lastPoint = item.audio_src.lastIndexOf('.'); // 获取最后一个"."的出现的位置
            let audio_src_name = item.audio_src.substring(lastDash + 1,lastPoint); // 路径中的路径名
            let audio_src_subfix = item.audio_src.substring(lastPoint);
            item.audio_src = require(`../assets/audio/${audio_src_name}${audio_src_subfix}`);
            this.songList.push(item); // 把歌曲的所有信息存入一个数组里面， 格式: [{},{},{}]
          })
          if(this.songList.length != 0){
            resolve('请求歌曲并且audio_src和海报路组装完毕');
            console.log('请求歌曲并且audio_src和海报路组装完毕');
          }
        })
      }).then(()=>{
        this.$refs.songList.forEach((item,index)=>{ // 给歌曲列表每首歌添加点击事件  <!--author audio_src name poster_src-->
        //  搜索的歌名  <!--author audio_src name poster_src-->
          if(window.localStorage.getItem('searchResult') == this.$refs.name[index].innerHTML){
            this.$refs.audio.src =  this.$refs.audio_src[index].innerHTML; // 播放路径
            this.$refs.poster_img.src =  this.$refs.poster_src[index].src; // 海报地址
            this.$refs.player_title.textContent =   this.$refs.name[index].innerHTML; // 歌名
            this.$refs.player_author.textContent =   this.$refs.author[index].innerHTML; // 作者
          }
          item.onclick = ()=>{
            // console.log(e.target.style.color);
            // alert(index);
            // this.$refs.song[index].cssText += ';color: blue;';
            // console.log(this.$refs.song);
            item.style.cssText += ';color: blue;'; // 歌名变色
            this.$refs.songs[index].style.cssText += ';color: blue;';// 有作者的歌名变蓝色
            this.$refs.player_title.innerHTML = this.$refs.name[index].textContent; // 播放器中的标题内容改变
            this.$refs.player_author.innerHTML = this.$refs.author[index].textContent; // 播放器作者栏内容改变
            this.$refs.poster_img.src = this.$refs.poster_src[index].src; // 播放器中海报的路径
            // console.log(this.$refs.author[index].textContent);
            this.$refs.songList.forEach((value,key)=>{ // 重新调整样式,除了当前点击的item项,其他项变回原来的颜色
              if(index != key){ // 1 == 1 index = 0; key = 0,1,2,3,4, .....
                value.style.cssText += ';color: #000;'; // value 就是歌名
                this.$refs.songs[key].style.cssText += ';color: #AAAAAA;'; // 有作者的歌名
              }
            })
              /*
                用户点击一次播放歌曲就添加一条记录到浏览历史里面
                记录的东西为：海报 音频路径 歌曲名，作者 。
              */
            //  console.log(this.$refs.poster_src[index].src);
            // console.log(this.$refs.audio_src[index].innerHTML);
              this.recordBrowsingHistory.push({
                poster_src: this.$refs.poster_src[index].src, // 海报
                audio_src: this.$refs.audio_src[index].innerHTML, // 音频路径
                name:  this.$refs.name[index].textContent, // 歌名
                // name_fill: this.$refs.songs[index].textContent, // 歌名带作者
                author: this.$refs.author[index].textContent // 作者
              })
              window.localStorage.setItem('browsingHistory',JSON.stringify(this.recordBrowsingHistory));
              // console.log('sdf');
         
            // console.log(this.recordBrowsingHistory);
            this.$refs.audio.src =  this.$refs.audio_src[index].innerHTML; // 播放器中改变播放源
            // 给"我喜欢"图标添加点击事件，用户点击歌曲的"我喜欢"按钮,歌曲变为我喜欢
              this.$refs.loves[index].onclick = (e)=>{
                e.stopPropagation(); // 阻止事件冒泡
                if(this.$refs.loves[index].style.color == 'rgb(170, 170, 170)'){ // 心形没有变红就变红
                 console.log('暗->红');
                  /* 
                    1、"心形"变红
                    2、 用户点击"心形"添加动画，动画触发完毕之后删除
                  */
                  this.$refs.loves[index].style.cssText += ";color:red;"; // 1
                  this.$refs.loves[index].classList.add('hotHeart'); // 2
                  /*
                    点击"心形"往isLoveList添加歌曲信息(歌名、歌手、是否喜欢、歌曲的播放路径)
                    this.$refs.songs[index]
                    this.$refs.player_author.innerHTML = this.$refs.author[index].textContent; // 播放器作者栏内容改变
                    是否喜欢 isLove true喜欢 false不喜欢
                    this.$refs.audio_src[index].innerHTML
                  */
                   console.log('暗->红');
                    this.isLoveList.push({
                          name:  this.$refs.songs[index].textContent,
                          author: this.$refs.author[index].textContent,
                          id: index,
                          isLove: true,
                          audio_src: this.$refs.audio_src[index].innerHTML
                    })
                    // 用户喜欢的歌曲信息添加到浏览器
                    window.localStorage.setItem('loveList',JSON.stringify(this.isLoveList));
                  /*
                      1、移除心形动画
                      2、出现心形提示框
                      3、1000ms之后心形提示框消失同时计时事件消失
                      4、清除计时事件
                  */
                  this.$refs.loves[index].addEventListener('animationend',()=>{ 
                     this.$refs.loves[index].classList.remove('hotHeart'); // 1
                     this.$refs.hotHeartToastr.style.cssText += ';display:block;';  // 2
                     let triShowToastr = setInterval(()=>{   // 3
                        try{
                          this.$refs.hotHeartToastr.style.cssText += ';display:none;';
                          clearInterval(triShowToastr);  // 4
                        }catch(e){
                          new Error(e);
                        }
                      },1000);
                  }); 
               
                }else{
                  console.log('红->暗');
                  // console.log(this.$refs.loves[index].style.color);
                  this.$refs.loves[index].style.cssText += ";color:rgb(170, 170, 170);"; // "心型"变回原来的
                  console.log(this.isLoveList);
                  this.isLoveList.forEach((item,key)=>{
                    // console.log(item.name);
                    if(item.name == this.$refs.songs[index].textContent){ // 如果获取到当前歌曲的名字 == 已有isLoveList列表里面歌曲的名字,就删除
                      // console.log(key);
                      // console.log(typeof this.isLoveList);
                      this.isLoveList.splice(key,1);
                      // console.log(this.isLoveList);
                      // 用户喜欢的歌曲信息添加到浏览器
                      window.localStorage.setItem('loveList',JSON.stringify(this.isLoveList));
                      // 喜欢列表里面都没有数据了，是一个空数组就删除它
                      if(JSON.parse(window.localStorage.getItem('loveList')).length == 0){
                        window.localStorage.removeItem('loveList');
                      }
                    }
                  })
                }
              }
          }
        })
        // 用户如果之前点击了歌曲喜欢，刷新，歌曲的状态会保存，心形会变红/#AAA
        // console.log(JSON.parse(window.localStorage.getItem('loveList')).length);
         try{
            JSON.parse(window.localStorage.getItem('browsingHistory')).forEach((item)=>{ // 先把之前的记录放入一个browsingHistory数组里面
              this.recordBrowsingHistory.push(item);
            });
            // console.log(this.recordBrowsingHistory);
        }catch(e){
          // throw new Error;
        }

        try{
          JSON.parse(window.localStorage.getItem('loveList')).forEach((item,index)=>{
            if(item.isLove === true){
              this.$refs.loves[item.id].style.cssText += ";color: red;";
              this.isLoveList.push(item);
            }
          })
          // 如果从浏览器请求的是空数组就删除它
          if(JSON.parse(window.localStorage.getItem('loveList')).length == 0){
            window.localStorage.removeItem('loveList');
          }
        }catch(e){
          // throw new Error;
        }
        // 歌词界面到首页记录播放状态
       this.requirePreCurrentAudioInfo(); // requirePreCurrentAudioInfo
       
      })
      // console.log(this.songList);
    },
    durationchange(){ // 监视音频播放时间的总长度有没有改变
      this.cpp(0); // 重置进度条和进度点
      this.isPlay(); // 重置播放的状态，如果播放就暂停，暂停就播放
    },
    isPlay(){ // 是否播放
      if(this.$refs.audio.paused === true){
          // 播放歌曲
          this.$refs.audio.play();
          this.$refs.poster_img.classList.add('rotate');
          this.$refs.poster_img.style.cssText += ';animation-play-state: running;';
          this.$refs.player.innerHTML = `
            <svg style="width:100%;height:100%;max-height:100%;max-width:100%" t="1576412590262" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4133" width="200" height="200"><path d="M500.864 952.64c-239.648 0-434.656-194.976-434.656-434.624 0-239.68 195.008-434.624 434.656-434.624 239.68 0 434.656 194.944 434.656 434.624 0 239.68-195.008 434.624-434.656 434.624m0-933.28C225.92 19.36 2.24 243.104 2.24 518.016 2.24 792.96 225.92 1016.64 500.864 1016.64s498.656-223.68 498.656-498.624c0-274.912-223.68-498.624-498.656-498.624" p-id="4134"></path><path d="M404.864 326.016a32 32 0 0 0-32 32v320a32 32 0 0 0 64 0v-320a32 32 0 0 0-32-32M596.864 326.016a32 32 0 0 0-32 32v320a32 32 0 0 0 64 0v-320a32 32 0 0 0-32-32" p-id="4135"></path></svg>
          `;
        }else{
          // 暂停歌曲
          this.$refs.audio.pause();
          this.$refs.poster_img.style.cssText += ';animation-play-state: paused;';
          this.$refs.player.innerHTML = `
            <svg style="width:100%;height:100%" t="1576401147186" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4385" width="200" height="200"><path d="M226.592 896C167.616 896 128 850.48 128 782.736V241.264C128 173.52 167.616 128 226.592 128c20.176 0 41.136 5.536 62.288 16.464l542.864 280.432C887.648 453.792 896 491.872 896 512s-8.352 58.208-64.272 87.088L288.864 879.536C267.712 890.464 246.768 896 226.592 896z m0-704.304c-31.008 0-34.368 34.656-34.368 49.568v541.472c0 14.896 3.344 49.568 34.368 49.568 9.6 0 20.88-3.2 32.608-9.248l542.864-280.432c21.904-11.328 29.712-23.232 29.712-30.608s-7.808-19.28-29.712-30.592L259.2 200.96c-11.728-6.048-23.008-9.264-32.608-9.264z" p-id="4386"></path></svg>
          `;
        }
    },
    cutPattern(){ // 切换播放的模式  currentPlayerStatus 播放的状态 cutPattern refs playerPattern播放的模式
      // isLoop: false, // 是否循环播放
      // isRandom: false, // 是否随机播放
      // isOrder: true, // 是否顺序播放 默认是顺序播放
      event.stopPropagation(); // 阻止事件冒泡
      this.currentPlayerStatus += 1; // 进入下一个播放模式
      // console.log(this.playerPattern[this.currentPlayerStatus].img_src);
    if(this.currentPlayerStatus == 0){
      this.isOrder = true; // 开启顺序播放
      this.isLoop = false; // 关闭循环播放
      this.$refs.audio.removeAttribute('loop');
    }else if(this.currentPlayerStatus == 1){ // 随机播放模式
      this.isRandom = true; // 开启随机播放
      this.isOrder = false; // 关闭顺序播放

    }else if(this.currentPlayerStatus == 2){ // 循环播放模式
      this.isLoop = true; // 开启循环播放
      this.$refs.audio.setAttribute('loop','loop');
      this.isRandom = false; // 关闭随机播放
    }
      this.$refs.cutPattern.children[1].innerHTML =  this.playerPattern[this.currentPlayerStatus].name;
      this.$refs.cutPattern.children[0].src =  this.playerPattern[this.currentPlayerStatus].img_src;
      if(this.currentPlayerStatus == 2){ // 进入第三种模式,currentPlayerStatus = -1;
        this.currentPlayerStatus = -1;
      }
    },
    showPlayerList(){ // 显示播放列表
    // alert('sdf');
      event.stopPropagation(); // 阻止事件传播
      this.$refs.listenList.removeEventListener('animationend',this.adjustLayer);  // 取消弹出层注册的animationend事件
      this.$refs.listenList.classList.remove('enter-out');  // 移除出去的动画
      this.$refs.controlPanel.style.cssText += ';z-index: 1314;'; // 层级变为 1314
      this.$refs.listenList.classList.add('enter-in'); // 添加进入动画
      this.$refs.listSong.forEach((item,index)=>{
        item.onclick = (event)=>{
          event.stopPropagation(); // 阻止事件传播
          this.$refs.audio.src = this.recordBrowsingHistory[index].audio_src;
          this.$refs.poster_img.src = this.recordBrowsingHistory[index].poster_src;
          this.$refs.player_title.textContent =  this.recordBrowsingHistory[index].name;
          this.$refs.player_author.textContent =  this.recordBrowsingHistory[index].author;
          // console.log();
        }
      })
      // console.log(this.$refs.listSong);
    },
    hiddenPlayerPage(){ // 隐藏播放列表 
      if(this.$refs.listenList.className.indexOf('enter-in') != -1){
        this.$refs.listenList.classList.remove('enter-in');
      }
      this.$refs.listenList.classList.add('enter-out');
      this.$refs.listenList.addEventListener('animationend',this.adjustLayer); 
    },
    addSongListClick(){ // 给歌曲列表
      // console.log(this.$refs.songList);
        // console.log(this.$refs.audio.src);

    },
    adjustLayer(){ // 调整弹出层为-1314
      this.$refs.controlPanel.style.cssText += ';z-index: -1314;';
      // console.log('完毕');
    },
    ended(){
      if(this.isOrder == true){ // 如果是顺序播放
        this.changePlayerInfo(this.currentListen); // 改变播放的信息（歌名，作者，海报,播放的路径）
        this.currentListen += 1; // 下一首
        if(this.currentListen == this.recordBrowsingHistory.length - 1){
          this.currentListen = 0; // 重新从第一首播放
        }
      }
      if(this.isRandom == true){ // 如果是随机播放
        let random = Math.floor(Math.random() * (this.recordBrowsingHistory.length - 1)); // 生成歌曲的随机数
        this.changePlayerInfo(random); // 改变播放的信息（歌名，作者，海报,播放的路径）
        // console.log(random);
      }
    },
    nextSong(){
      if(this.isOrder == true){ // 如果是顺序播放
        this.changePlayerInfo(this.currentListen); // 改变播放的信息（歌名，作者，海报,播放的路径）
        this.currentListen += 1; // 下一首
        if(this.currentListen == this.recordBrowsingHistory.length - 1){
          this.currentListen = 0; // 重新从第一首播放
        }
      }
       if(this.isRandom == true){ // 如果是随机播放
        let random = Math.floor(Math.random() * (this.recordBrowsingHistory.length - 1)); // 生成歌曲的随机数
        this.changePlayerInfo(random); // 改变播放的信息（歌名，作者，海报,播放的路径）
      }
    },
    changePlayerInfo(index){  // 改变播放的信息（歌名，作者，海报,播放的路径）
      this.$refs.audio.src =  this.recordBrowsingHistory[index].audio_src;
      this.$refs.poster_img.src =  this.recordBrowsingHistory[index].poster_src;
      this.$refs.player_title.textContent =   this.recordBrowsingHistory[index].name;
      this.$refs.player_author.textContent =   this.recordBrowsingHistory[index].author;
    },
    requirePreCurrentAudioInfo(){
      // console.log(JSON.parse(window.localStorage.getItem('preCurrentAudioInfo').length));
      try{
          if(JSON.parse(window.localStorage.getItem('preCurrentAudioInfo').length) != 0){ // preCurrentAudioInfo有记录
            let name = JSON.parse(window.localStorage.getItem('preCurrentAudioInfo')).name.split('-');
            let songName = name[1].replace(/\s/g,''); // 得到歌名
            let author = name[0].replace(/\s/g,''); // 得到作者
            let poster_src;
            this.songList.forEach((item)=>{
              if(item.name == songName){
                poster_src = item.poster_src;
              }
            })
            this.$refs.audio.src = JSON.parse(window.localStorage.getItem('preCurrentAudioInfo')).audio_src; // 播放路径
            this.$refs.audio.currentTime = JSON.parse(window.localStorage.getItem('preCurrentAudioInfo')).currentTime; // 播放的时间
            this.$refs.poster_img.src =  poster_src; // 海报地址
            this.$refs.player_title.innerHTML = songName;
            this.$refs.player_author.innerHTML = author;
          }
      }catch(e){
        new Error(e)
      }
    }
  },
  mounted(){
      console.log(require('../assets/icon/随机播放.png'));
      this.getSongs(); // 请求歌词信息
      // 页面加载暂停图片旋转
      // 音频位置改变，进度条一起改变 
      // 音量改变 - 进度点和进度条跟着歌曲变化而变化
      this.$refs.audio.addEventListener('timeupdate',this.updatetime,false);
      // 点击进度条跳转到指定位置 (源来的进度条)
      this.$refs.originProgressBarBg.addEventListener('mousedown',this.jumpPosition,false);
      // 点击进度条跳转到指定位置 (改变之后的进度条)
      this.$refs.progressBarBg.addEventListener('mousedown',this.jumpPosition,false);
      // 开始拖动touchstart
      this.$refs.progressBar.addEventListener('touchstart',this.touchestart,false); 
      // 拖动中
      this.$refs.progressBar.addEventListener('touchmove',this.touchmove,false);
      // 拖动结束
      this.$refs.progressBar.addEventListener('touchend',()=>{
        this.flag = false;
      },false);
      this.$refs.audio.addEventListener('ended',this.ended,false); // 给播放器注册一个ended事件
      this.$refs.audio.addEventListener('durationchange',this.durationchange,false); // 音频的长度发生改变证明音频源切换
        //console.log(this.$refs.progressBar.getBoundingClientRect().left); 
  },
  beforeDestroy() {
    let currentAudioInfo = {
      name: this.$refs.player_title.innerHTML,
      author: this.$refs.player_author.innerHTML,
      currentTime: this.$refs.audio.currentTime,
      audio_src: this.$refs.audio.src
    }
    window.localStorage.setItem('currentAudioInfo',JSON.stringify(currentAudioInfo)); // 记录播放的状态 歌词名称、作者、播放源、currentTime
    try{
      window.localStorage.removeItem('preCurrentAudioInfo'); // 如果有销毁之前删除浏览器的preCurrentAudioInfo
    }catch(e){
      // new Error(e);
    }
    // console.log('页面销毁');
  }
}
</script>
<style type="scss" scoped>
#Index{
    width: 100%;
    height: 100%;
}
.bg-2CA2F9{
    background: #2CA2F9;
  }
  .font-size-16{
    font-size: 16px;
  }
  .ps-a{
    position: absolute;
  }
  .ps-r{
    position: relative;
  }
  /*图片*/
  .poster{
    -webkit-transition: all 18s;
    transition: all 18s;
  }
  /* 点击选中的心型动画 */
  .hotHeart{
    animation: hotHeart .5s 1 ease both;
  }
  /* 心形提示框动画 */

  @keyframes hotHeart {
    0%{
      transform: scale(1.0);
    }
    50%{
      transform: scale(1.5)
    }
    100%{
      transform: scale(1.0)
    }
  }
  .rotate{
    -webkit-animation: rotate 18s infinite linear;
    animation: rotate 18s infinite linear; 
  }
  /*旋转动画*/
  @keyframes rotate{
    0%{
      -webkit-transform: rotateZ(0deg);
      transform: rotateZ(0deg);
    }
    100%{
      -webkit-transform: rotateZ(360deg);
      transform: rotateZ(360deg);
    }
  }
  .enter-in{
    animation: heightChange  .5s  ease forwards;
  }
  .enter-out{
    animation: heightChangeReverse  .5s  ease forwards;
  }
  /* 歌曲列表动画 */
  @keyframes heightChange{
    0%{
      bottom: -50%;
    }
    100%{
    bottom: 0;
    }
  }
   @keyframes heightChangeReverse{
    0%{
      bottom: 0;
    }
    100%{
    bottom: -50%;
    }
  }
</style>   
