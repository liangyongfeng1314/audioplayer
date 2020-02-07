<template>
  <div id="Lyrics">
      <b-container fluid class="container" >
          <!-- 背景图 -->
          <img src="../assets/images/lyrics_bg.jpg" alt="lyrics_bg" class="bg"/>
          <b-row style="position: relative" > <!---返回按钮 歌名-->
            <b-col cols="2" class="p-2 " style="height:50px;position:relative;z-index:1314">
                <svg  @click="back()" t="1576585285909" class="icon back" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1286" width="200" height="200"><path d="M224.45 538.68l575.11-346.21-0.05-68.75-575.03 345.61-0.03 69.35z" p-id="1287" fill="#ffffff"></path><path d="M224.45 538.68l575.08 356.96v-69.52L224.48 469.33l-0.03 69.35z" p-id="1288" fill="#ffffff"></path></svg>
            </b-col>
            <b-col cols="12" ref="songName" class=" p-2 text-center text-white " style="height:50px;font-size:20px;position:absolute;left:0;right:0;top:0">
                我梦见我梦见我
            </b-col>
          <!--音频控制器-->
          <audio  ref="audio">
              <source src="../assets/audio/本兮 - 樱花的眼泪.mp3" />
          </audio>
          </b-row>
          <div ref="parentContainer" class=""  style="margin-top: 13%;height: 390px;padding-top: 60%;transition: all 2s;overflow:hidden" > <!--歌词界面-->
            <div  class=""  style="height: 100%;overflow: scroll" ref="scrollContainer" >
              <div ref="childContainer" style="transition: all 2s;position： relative">
                <div ref="childElement" :key="index" :value="item.content" v-for="(item,index) in lyrics"  class="text-center" style="line-height: 40px"  @click="getHeight()">
                  {{item.content}}
                </div>
              </div>
            </div>
          </div>
          <b-row class="px-4 w-100" ref="parentDistance" style="position:fixed;bottom:5%;"> <!--1 音乐操作界面-->
            <b-col cols="12" class="" style="height: 100px;"><!--1.1-->
              <b-row class=""> <!--1.11 第一行第一列 -->
                <b-col cols="12" class="text-center" style="height: 40px;line-height:40px" ><!---->
                  <b-row style="font-size: 12px" class="">
                    <b-col cols="2 " ref="currentTime" style="font-size: 19px">0:00</b-col>
                    <b-col cols="8" style="position:relative;">
                      <div ref="originProgressBar" class="bg-danger w-100" style="position:absolute;height:3px;top:48%"></div> <!--原始进度条-->
                      <div ref="progressBar" class="bg-primary w-0" style="position:absolute;height:3px;top:48%"></div> <!--改变之后的进度条-->
                      <div ref="point" class="bg-info" style="position:absolute;height:10px;top:40%;left:0;width:5%;border-radius:50%"></div> <!--进度点-->
                    </b-col>
                    <b-col cols="2 " ref="duration" style="font-size: 19px;padding-left: 15px">0:00</b-col>
                  </b-row>
                </b-col>
                <b-col cols="12" class="">
                    <b-row class="w-100" style="text-align:center" >
                      <div class="p-1 bg-danger" style="width:12%;height: 40px;margin-left:25%;margin-top:10px;border-radius: 50%">
                          <svg @click="preSong()" style="width: 100%;height: 100%;" t="1576935945400" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="839" width="200" height="200"><path d="M364.302083 465.602819L687.954365 218.588294c38.416414-29.327534 93.791393-1.929039 93.791392 46.396277v494.029051c0 48.325316-55.374979 75.725617-93.791392 46.398084L364.302083 558.397181c-30.600916-23.357989-30.600916-69.436372 0-92.794362zM238.945254 780.798397V451.684117v-164.562559c0-19.628152-5.904521-60.475733 17.057907-75.841215 25.523642-17.068744 59.747828 1.210165 59.747828 31.919454v493.676839c0 19.628152 5.915358 60.473927-17.047069 75.841215-25.53448 17.068744-59.758666-1.211971-59.758666-31.919454z" fill="#ffffff" p-id="840"></path></svg>
                      </div>
                      <div class="p-1 bg-danger" style="width:16%;height: 50px;margin-left:5%;border-radius: 50%" @click="player()" ref="player">
                          <svg style="width: 89%;height: 89%;margin-left:3px;margin-top:10%" t="1576938553993" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1613" width="200" height="200"><path d="M256 896V128l512 384z" p-id="1614" fill="#ffffff"></path></svg>
                      </div>
                       <div class="p-1 bg-danger" style="width:12%;height: 40px;margin-top:10px;margin-left:5%;border-radius: 50%">
                          <svg @click="nextSong()" style="width: 100%;height: 100%" t="1576939461713" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2900" width="200" height="200"><path d="M655.706179 465.602819L332.053897 218.588294c-38.414608-29.327534-93.791393-1.929039-93.791392 46.396277v494.029051c0 48.325316 55.376785 75.725617 93.791392 46.398084l323.652282-247.014525c30.602722-23.357989 30.602722-69.436372 0-92.794362zM781.064814 780.798397V451.684117v-164.562559c0-19.628152 5.904521-60.475733-17.057907-75.841215-25.523642-17.068744-59.747828 1.210165-59.747828 31.919454v493.676839c0 19.628152-5.915358 60.473927 17.047069 75.841215 25.532673 17.068744 59.758666-1.211971 59.758666-31.919454z" fill="#ffffff" p-id="2901"></path></svg>                      </div>
                    </b-row>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
      </b-container>
      <!-- <ul>
        <li :key="index" :value="item" v-for="(item,index) in lyrics">{{item.time}}</li>
      </ul> -->
  </div>
</template>
<script>
import Axios from 'axios'
export default {
  data() {
    return {
      lyricsInfo: [], // 歌词 - 歌曲信息部分
      lyricsTime: [], // 歌词 - 时间部分
      lyricsContent: [], // 歌词 - 歌词内容部分
      isMove: false,  // 是否已经触摸 默认为false
      lyrics: [], // 歌词 歌的时间和歌的内容
      position: { // 音频操作界面
        originDistance: 0, // 进度点到最左边的距离
        originClientX: 0,  // 进度点当前的坐标
      },
      childElementHeight: 0, // 第一个循环项的高度
      eachElementOffset: 0, // 距离scrollTop的距离，做中间值的传递
      record: 0, // 记录前三句歌曲的位置
      isRise: true, // 是否可以升高
      jValue :7.5, // 每次上升10%,上升三次
      lyricsOffset: [], //歌词居中显示时的偏移量 
      name: '', // 歌曲名称
      songNmae: '', // 歌曲名称带作者
      audio_src: '', // 播放的路径
      audio_currentTime: '', // 播放的时间
      currentListen: -1, // 记录当前用户正在听的歌曲
      browsingHistory: [], // 用户的听歌记录
    }
  },
  methods:{
    getHeight(){
        // this.childElement = this.$refs.childElement[0].offsetHeight; //  获取循环第一个项的高度
        // console.log(this.childElement);
    //   console.log(this.$refs.childElement[0].offsetHeight);
    //  this.$refs.childContainer.style.cssText += `;transform:translateY(${-this.$refs.childElement[0].offsetHeight}px);`;
    //   console.log(this.$refs.childContainer.offsetHeight);
    },
    back(){ // 返回首页
      this.$router.go(-1);
    },
    player(){
      if(this.$refs.audio.paused == true){
          this.$refs.player.innerHTML 
            = '<svg style="width: 70%; height: 70%;margin-top:19%" t="1576938677204" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2393" width="200" height="200"><path d="M757.52 73.107h-62.493c-34.526 0-62.498 27.984-62.498 62.511v749.948c0 34.526 27.974 62.493 62.498 62.493h62.493c34.516 0 62.502-27.968 62.502-62.493v-749.953c-0.001-34.524-27.984-62.509-62.502-62.509z" p-id="2394" fill="#ffffff"></path><path d="M320.054 73.107h-62.502c-34.526 0-62.498 27.984-62.498 62.511v749.948c0 34.526 27.974 62.493 62.498 62.493h62.502c34.505 0 62.493-27.968 62.493-62.493v-749.953c-0.001-34.524-27.984-62.509-62.493-62.509z" p-id="2395" fill="#ffffff"></path></svg>'
          this.$refs.audio.play();
          // this.childElementHeight = this.$refs.childElement[0].offsetHeight; //  获取循环第一个项的高度
          // console.log( this.childElementHeight);
      }else{
          this.$refs.player.innerHTML =
            '<svg style="width: 89%;height: 89%;margin-left:3px;margin-top:10%" t="1576938553993" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1613" width="200" height="200"><path d="M256 896V128l512 384z" p-id="1614" fill="#ffffff"></path></svg>'
          this.$refs.audio.pause();
      }
    },
    playerReverse(){
      this.$refs.player.innerHTML 
          = '<svg style="width: 70%; height: 70%;margin-top:19%" t="1576938677204" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2393" width="200" height="200"><path d="M757.52 73.107h-62.493c-34.526 0-62.498 27.984-62.498 62.511v749.948c0 34.526 27.974 62.493 62.498 62.493h62.493c34.516 0 62.502-27.968 62.502-62.493v-749.953c-0.001-34.524-27.984-62.509-62.502-62.509z" p-id="2394" fill="#ffffff"></path><path d="M320.054 73.107h-62.502c-34.526 0-62.498 27.984-62.498 62.511v749.948c0 34.526 27.974 62.493 62.498 62.493h62.502c34.505 0 62.493-27.968 62.493-62.493v-749.953c-0.001-34.524-27.984-62.509-62.493-62.509z" p-id="2395" fill="#ffffff"></path></svg>'
        this.$refs.audio.play();
        // console.log( this.childElementHeight);
    },
    preSong(){ // 上一首
      console.log(this.currentListen);
      if(this.currentListen < 0){
        this.currentListen = 0;
      }
      if(this.currentListen <= this.browsingHistory.length - 1){
        this.$refs.audio.src = this.browsingHistory[this.currentListen].audio_src; // 切换歌曲的播放路径
        this.$refs.songName.innerHTML = this.browsingHistory[this.currentListen].name; // 切换歌曲的名字
        this.songNmae = `${this.browsingHistory[this.currentListen].author} - ${this.browsingHistory[this.currentListen].name}`
        this.requestLyrics(); // 重新请求歌词文件
      }
      this.currentListen = this.currentListen - 1;
    
    },
    nextSong(){ // 下一首
      this.currentListen = this.currentListen + 1;
      if(this.currentListen <= this.browsingHistory.length - 1){
        console.log(this.currentListen);
        this.$refs.audio.src = this.browsingHistory[this.currentListen].audio_src; // 切换歌曲的播放路径
        this.$refs.songName.innerHTML = this.browsingHistory[this.currentListen].name; // 切换歌曲的名字
        this.songNmae = `${this.browsingHistory[this.currentListen].author} - ${this.browsingHistory[this.currentListen].name}`
        this.requestLyrics(); // 重新请求歌词文件
      }
      // console.log(this.songNmae);
      if(this.currentListen == this.browsingHistory.length - 1){
        this.currentListen = -1;
      }
    },
    cpp(value){ // change(改变) - progressBar(进度条) - progressPoint(进度点)
        this.$refs.progressBar.style.cssText += `;width: ${value}%;`; // 进度条
        this.$refs.point.style.cssText += `;left: ${value}%;`; // 进度点
    },
    transTime(value){ // 时间转化 value为当前播放器的秒数
      let m = parseInt(value / 60); // 分钟
      let s = parseInt(value % 60); // 秒钟
       if(s < 10){  // 如果秒数小于10，前面补一个0
        s = `0${s}`
      }
      if(m < 10){
        m = `0${m}`
      }
      let currentTime = `${m}:${s}`;
      return currentTime;     
    },
     timeUpdate(){ // 音频播放位置改变 进度条和进度点一起改变 
    
    // console.log(this.$refs.childContainer.offsetHeight);
    try{
      let value = (this.$refs.audio.currentTime /this.$refs.audio.duration) * 100;  // 播放的进度
      this.cpp(value);
    }catch(e){
      new Error(e);
    }
      // ---------------------------------------------------------------------------------------------------------------
      try{
        this.$refs.duration.innerHTML = this.transTime(this.$refs.audio.duration); // 获取这首歌的总时间并渲染在页面指定位置
        let showCurrentTime = this.transTime(this.$refs.audio.currentTime).replace(/\d{1}/,''); // 获取歌当前格式化的时间并渲染在页面指定位置
        this.$refs.currentTime.innerHTML = showCurrentTime;  // 歌词界面显示当前的时间
        this.lyricsTime.forEach((item,index)=>{ // 如果页面一进来就大于第三句就定位到指定的句子
        if(this.lyricsTime[index] < this.transTime(this.$refs.audio.currentTime) && this.lyricsTime[index + 1] > this.transTime(this.$refs.audio.currentTime)){
              this.$refs.scrollContainer.scrollTop = this.lyricsOffset[index];
          } 
        })
      }catch(e){
        new Error(e);
      }
      
      this.riseLyrics();  // 如果一开始进度在第三句歌词之后就升高歌词界面
      // let lyrics = this.$refs.childElement; // 歌词部分
      // let currentTime = this.transTime(this.$refs.audio.currentTime); // 00:00格式的时间
      // console.log(currentTime);
        // console.log(this.transTime(this.$refs.audio.currentTime));        
      this.lyrics.forEach((item,index)=>{
        // 读到哪哪里改变颜色
        if(this.transTime(this.$refs.audio.currentTime) > this.lyricsTime[index] && this.transTime(this.$refs.audio.currentTime) < this.lyricsTime[index + 1]){
            this.$refs.childElement[index].style.cssText += ';color: #DC3545;';
        }else{
            this.$refs.childElement[index].style.cssText += ';color: #000;';
        }
        if(item.time == this.transTime(this.$refs.audio.currentTime)) { // 获取到的时间 == 当前的时间
            this.record = this.record + 1;
            // 上升三次之后停止上升
            if(this.record == 4 || this.record == 8 || this.record == 12 && this.isRise == true){
              // console.log(this.record);
              let paddingTop = this.$refs.parentContainer.style.paddingTop.replace(/%/,''); // 去掉获取到的padding-top的单位(%)
              //  console.log('之前' + this.$refs.parentContainer.style.paddingTop);
              let changeValue = parseInt(paddingTop)  - this.jValue;
              //  console.log('改中: ' + this.$refs.parentContainer.style.paddingTop);
              this.$refs.parentContainer.style.cssText += `;padding-top: ${changeValue}%;`;
              // console.log('改了: ' + this.$refs.parentContainer.style.paddingTop);
              this.jValue = this.jValue + 7.5; // 升了之后加10,第二次提升的高度
              // console.log('执行');
            }else if(this.record > 16 && this.record%4 == 1){ // 双数
               this.$refs.scrollContainer.scrollTop = this.lyricsOffset[index];
            }
        }
      })
    },
    jumpPosition(e){ // 点击哪个位置就那个位置开始播放
      let originProgressBarWidth = this.$refs.originProgressBar.offsetWidth; //  原始进度条的宽度
      let rate = e.offsetX / originProgressBarWidth;
      // 当前播放的进度 总进度 * rate
      this.$refs.audio.currentTime = this.$refs.audio.duration * rate;
      this.riseLyrics(); // 如果一开始进度在第三句歌词之后就升高歌词界面
      // 点击进度条定位歌词
      // console.log(this.lyricsTime);
      // console.log(this.transTime(this.$refs.audio.currentTime));
      this.lyricsTime.forEach((item,index)=>{
       if(this.lyricsTime[index] < this.transTime(this.$refs.audio.currentTime) && this.lyricsTime[index + 1] > this.transTime(this.$refs.audio.currentTime)){
            this.$refs.scrollContainer.scrollTop = this.lyricsOffset[index];
            // console.log('执行');
        } 
        // console.log(item);
      })
      // 改变进度点和进度条的位置
      let changeValue = rate*100;
      this.cpp(changeValue);
   },
    touchstart(e){
      this.isMove = true; // 开始触摸
      this.$refs.originClientX = e.touches[0].clientX; // 之前一开始的坐标
      this.$refs.originDistance = this.$refs.point.offsetLeft; // 之前进度点的距离
    },
    touchmove(e){
      if(this.isMove == true){
        // 原来的距离 + 移动的距离
        let length = (e.touches[0].clientX - this.$refs.originClientX) + this.$refs.originDistance; // 移动的距离
        let rate = length / this.$refs.originProgressBar.offsetWidth;
        this.$refs.audio.currentTime = this.$refs.audio.duration * rate;
        let valueChange = rate * 100;
    
        this.cpp(valueChange);
      }
    },
    riseLyrics(){ // 如果一开始进度在第三句歌词之后就升高歌词界面
      try{
        let dealCurrentTime = this.transTime(this.$refs.audio.currentTime).replace(/\d{1}/,''); // 获取当前歌格式化的时间 格式: 0:00
        if(dealCurrentTime > this.lyricsTime[2]){ // 大于第三句歌词的时间就是不升高了，直接一次升到位，并设置isRise = false;
          this.isRise = false; // 不能上升
          for(let i=0;i <= 2;i++){ // 自动改变
            this.jValue = this.jValue + 7.5;
            this.$refs.parentContainer.style.cssText += `;padding-top: ${parseInt(this.$refs.parentContainer.style.paddingTop.replace(/%/,'')) + (-this.jValue)}%;`;
          }
        }else{
          this.isRise = true; // 可以上升
          this.$refs.parentContainer.style.cssText += `;padding-top: ${60}%;`;
        }
      }catch(e){
        new Error(e);
      }
    },
    async requestLyrics(){ // 请求歌词
      new Promise((resolved,rejected)=>{
        Axios.post('/audioplayer/tp5/public/index.php/user/Index/getAT',{'songName':this.songNmae}).then((res)=>{
          this.lyricsInfo = res.data.join(','); // 数组分割为字符串，用逗号作为分隔符
          this.lyricsInfo = this.lyricsInfo.replace(/(ar|ti|:|])/g,''); // 把ar|ti|:|]出现都是替换为空字符
          this.lyricsInfo = this.lyricsInfo.split(','); // 以逗号为起点，把字符串分割为数组
          if(this.lyricsInfo.length != 0){
            resolved('请求歌词信息成功');
            console.log('请求歌词信息成功');
          }else{
            rejected('请求歌词信息失败');
          }
        })
      }).then(()=>{ // 请求歌词 - 时间部分
        new Promise((resolved,rejected)=>{
          Axios.post('/audioplayer/tp5/public/index.php/user/Index/getLyricsTime',{'songName':this.songNmae}).then((res)=>{
            // console.log(res.data[0]);
            this.lyricsTime = []; // 请求之前清空数组
            res.data[0].forEach((item)=>{ // 添加进lyricsTime数组
              this.lyricsTime.push(item);
            })
            if(this.lyricsTime.length != 0){
              resolved('请求时间部分完成');
              console.log('请求时间部分完成');
            }else{
              rejected('请求时间部分失败');
              console.log('请求时间部分失败');
            }
          })
        }).then(()=>{
            new Promise((resolve)=>{ // 请求歌词 - 歌词内容部分
              Axios.post('/audioplayer/tp5/public/index.php/user/Index/getLyrics',{'songName':this.songNmae}).then((res)=>{
                this.lyricsContent = []; // 请求之前清空数组
                res.data[0].forEach((item)=>{
                  this.lyricsContent.push(item.replace(']',''));
                })
                // 把歌词时间和歌词内容放入一个数组对象里面
                this.lyrics = []; // 请求之前清空数组
                this.lyricsTime.forEach((item,index)=>{
                  this.lyrics.push({
                    time: item,
                    content: this.lyricsContent[index]
                  })
                });
                resolve('请求歌词内容部分完成');
                console.log('请求歌词内容部分完成');
              }).then(()=>{
                  this.childElementHeight = this.$refs.childElement[0].offsetHeight; //  获取循环第一个项的高度
                  this.eachElementOffset = 0; // 传值的中间跳板
                  this.lyricsOffset = []; // 请求之前清空数组
                  this.lyrics.forEach((item,index)=>{
                    if(index > 3){ // 偏移量
                      this.eachElementOffset += this.childElementHeight;
                      // console.log(index  + ":" + this.$refs.scrollContainer.scrollTop);
                      this.lyricsOffset.push(this.eachElementOffset); // 设置每句歌词的偏移量
                    }else{
                      this.lyricsOffset.push(this.eachElementOffset); // 设置每句歌词的偏移量
                    }
                  })
              })
            })
        })
      })
    },
    async requrestPlayerInfo(){ // 请求当前 播放歌曲的信息，之前页面过来的歌曲信息
      new Promise(resolve=>{
        // name: '', // 歌曲名称
        // songNmae: '', // 歌曲名称带作者
        // audio_src: '', // 播放的路径
        // audio_currentTime: '', // 播放的时间
        let res = JSON.parse(window.localStorage.getItem('currentAudioInfo'));
        this.name = res.name;
        this.songNmae = `${res.author} - ${this.name}`;
        // console.log(this.songNmae);
        this.audio_src = res.audio_src;
        this.audio_currentTime = res.currentTime;
        if(this.name != '' && this.songNmae != '' && this.audio_src != '' && this.audio_currentTime != ''){
          this.$refs.songName.innerHTML = this.name; // 歌曲的名字带作者
          this.$refs.audio.src = this.audio_src; // 当前播放的路径
          console.log(this.$refs.audio.src);
          this.$refs.audio.currentTime = this.audio_currentTime; // 当前播放的时间

          if(this.$refs.audio.currentTime != this.$refs.audio.duration){
             this.$refs.player.innerHTML 
            = '<svg style="width: 70%; height: 70%;margin-top:19%" t="1576938677204" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2393" width="200" height="200"><path d="M757.52 73.107h-62.493c-34.526 0-62.498 27.984-62.498 62.511v749.948c0 34.526 27.974 62.493 62.498 62.493h62.493c34.516 0 62.502-27.968 62.502-62.493v-749.953c-0.001-34.524-27.984-62.509-62.502-62.509z" p-id="2394" fill="#ffffff"></path><path d="M320.054 73.107h-62.502c-34.526 0-62.498 27.984-62.498 62.511v749.948c0 34.526 27.974 62.493 62.498 62.493h62.502c34.505 0 62.493-27.968 62.493-62.493v-749.953c-0.001-34.524-27.984-62.509-62.493-62.509z" p-id="2395" fill="#ffffff"></path></svg>'
            this.$refs.audio.play();
          }
          resolve('获取歌曲信息成功');
        }
      }).then(()=>{ // 获取完歌曲信息请求歌曲文件
          this.requestLyrics(); //  请求歌词文件，获取歌词文件的 时间，信息，歌词
      })
    },
    durationchange(){ // 监视音频播放时间的总长度有没有改变
      this.cpp(0); // 重置进度条和进度点
      this.playerReverse(); // 重置播放的状态，如果播放就暂停，暂停就播放
    },
  },
  mounted(){
    this.requrestPlayerInfo(); // 请求歌曲信息 
    try{
      JSON.parse(window.localStorage.browsingHistory).forEach((item)=>{
        this.browsingHistory.push(item);
      });
    }catch(e){
      new Error(e);
    }
    
    // console.log(this.browsingHistory);
    // 点击原始进度条播放位置改变
    this.$refs.originProgressBar.addEventListener('click',this.jumpPosition);
    // 播放位置改变 进度点和进度条的位置也会发生改变
    this.$refs.audio.addEventListener('timeupdate',this.timeUpdate);
     // 点击当前进度条播放位置改变
    this.$refs.progressBar.addEventListener('click',this.jumpPosition);
    // 进度点添加touchstart事件
    this.$refs.point.addEventListener('touchstart',this.touchstart); 
    // 进度点添加touchmove事件
    this.$refs.point.addEventListener('touchmove',this.touchmove);
    //  进度点添加touchend事件
    this.$refs.point.addEventListener('touchend',()=>{
      this.isMove = false; // 关闭触摸
    });
    // console.log(this.$refs.audio);
    this.$refs.audio.addEventListener('ended',()=>{
      console.log('结束');
      // 播放完就结束歌曲
        this.$refs.player.innerHTML =
            '<svg style="width: 89%;height: 89%;margin-left:3px;margin-top:10%" t="1576938553993" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1613" width="200" height="200"><path d="M256 896V128l512 384z" p-id="1614" fill="#ffffff"></path></svg>'
    },false);
    this.$refs.audio.addEventListener('durationchange',this.durationchange,false); // 音频的长度发生改变证明音频源切换
  },
  beforeDestroy() {
     let preCurrentAudioInfo = {
      name: this.songNmae,
      currentTime: this.$refs.audio.currentTime,
      audio_src: this.$refs.audio.src
    }
    // console.log(this.$refs.songNmae);
    window.localStorage.setItem('preCurrentAudioInfo',JSON.stringify(preCurrentAudioInfo));
    console.log('页面销毁');
  }
}
</script>
<style lang="scss" scoped>
  body,html{
    box-sizing: border-box;
  }
  *,
  *::before,
  *::after{
    padding: 0;
    margin: 0;
  }
  #Lyrics{
      width: 100%;
      height: 100%;
    .container{
      width: 100%;
      height: 100%;
    }
    .bg{
        width: 100%;
        height: 100%;
        max-width:100%;
        max-height: 100%;
        position: absolute;
        filter: contrast(80%);
        z-index: -1314;
      }  
      .back{
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-width: 100%;
      }
  }

</style>