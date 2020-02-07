<?php
namespace app\user\controller;
use think\Controller;
class Index  extends Controller
{
    public function index()
    {

    }
    public function readTextFile($songName){ // 读取对应歌的lrc文件
        header("Content-Type:text/html;charset=utf-8"); 
        $url = "http://localhost:8080/audioplayer/tp5/public/static/user/lrc/".$songName.".lrc"; 
        $contents = file_get_contents($url); 
        $contents = iconv("gb2312", "utf-8//IGNORE",$contents); 
        return $contents;
    }
     public function getAT(){// 获取歌词中的作者和标题
          $songName = input('param.songName'); // 得到传过来的值
          $songName = rawurlencode($songName); // 编码
          $contents = $this->readTextFile($songName); // 调用读取到的歌词文件
          preg_match_all('/ar.*/',$contents,$lyricsar);  // 从歌词文件中-获取-歌曲信息（作者）
          preg_match_all('/ti.*/',$contents,$lyricsti);  // 从歌词文件中-获取-歌曲信息（标题）
          $lyricsInfo = array_merge($lyricsar,$lyricsti); 
          return json($lyricsInfo);
    }
    public function getLyricsTime(){ // 获取歌词中的时间
         $songName = input('param.songName'); // 得到传过来的值
         $songName = rawurlencode($songName); // 编码
         $contents = $this->readTextFile($songName); // 调用读取到的歌词文件
         preg_match_all('/[0-9]*:[0-9]{2}/',$contents,$lyrics_time); // 从歌词文件中-获取-时间
         return json($lyrics_time);
    }
    public function getLyrics(){ // 获取歌词中的内容部分
          $songName = input('param.songName'); // 得到传过来的值
          $songName = rawurlencode($songName); // 编码
          $contents = $this->readTextFile($songName); // 调用读取到的歌词文件
          preg_match_all('/][^\s].*/',$contents,$lyrics); // 从歌词文件中-获取-歌词
          return json($lyrics);
    }
    public function getSongs(){ // 获取歌曲列表
        return json(db('song')->select());
    }
    public function searchContent(){ // 检索歌曲列表有什么歌曲
        $searchContent = input('param.searchContent');
        if(!empty($searchContent)){ // 如果传入进来的$searchContent为空就不读数据库
            $datas =  db('song')->where('song','like','%'.$searchContent.'%')->select();
            return json($datas);
        }else{
            return json('null');
        }
       
        // return json(input('param.searchContent'));
    }
   
}