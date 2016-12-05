<?php
/**
 * Plugin Name: 迷津音乐播放器
 * Version: 1.1
 * Plugin URL: http://www.qingzz.cn/
 * Description: 播放器为开源的播放器,本地化,后台支持自定义专辑名称,输入歌单ID和单曲ID,支持网易、虾米、百度、QQ音乐！
 * Author: 未知
 * Author Email: qingzz@qingzz.cn
 * Author URL: http://auv.qingzz.cn/
 */

!defined('EMLOG_ROOT') && exit('access deined!');

function qingzz_music_load(){
	echo '<link href="'.BLOG_URL.'content/plugins/qingzz_music/style/player.min.css" rel="stylesheet" type="text/css">'."\n";
	//echo '<link href="http://libs.baidu.com/fontawesome/4.0.3/css/font-awesome.css" rel="stylesheet" type="text/css">'."\n";//调用百度公共文件加快速度
	//echo '<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>'."\n";
}
function qingzz_music_list(){
  ?>

<div id="wenkmPlayer">

  <div class="player">

    <div class="infos">

      <div class="songstyle"><i class="fa fa-music"></i> <span class="song"></span></div>

      <div class="timestyle"><i class="fa fa-clock-o"></i> <span class="time">00:00 / 00:00</span></div>

      <div class="artiststyle"><i class="fa fa-user"></i> <span class="artist"></span><span class="moshi"><i class="loop fa fa-random current"></i> 随机播放</span></div>

      <div class="artiststyle"><i class="fa fa-folder"></i> <span class="artist1"></span><span class="geci"></span></div>

    </div>

    <div class="control">

      <i class="loop fa fa-retweet" title="顺序播放"></i>

      <i class="prev fa fa-backward" title="上一首"></i>

      <div class="status">

        <b>

          <i class="play fa fa-play" title="播放"></i>

          <i class="pause fa fa-pause" title="暂停"></i>

        </b>

      </div>

      <i class="next fa fa-forward" title="下一首"></i>

      <i class="random fa fa-random current" title="随机播放"></i>

    </div>

    <div class="musicbottom">

      <div class="volume">

        <i class="mute fa fa-volume-off"></i>

        <i class="volumeup fa fa-volume-up"></i>

        <div class="progress">

          <div class="volume-on ts5">

            <div class="drag" title="音量"></div>

          </div>

        </div>

      </div>

      <div class="switch-playlist">

        <i class="fa fa-bars" title="播放列表"></i>

      </div>

      <div class="switch-ksclrc">

        <i class="fa fa-toggle-on" title="关闭歌词"></i>

      </div>

      <div class="switch-default">

        <i class="fa fa-refresh" title="切换默认专辑"></i>

      </div>

      <div class="switch-down">

        <a class="down"><i class="fa fa-cloud-download" title="歌曲下载"></i></a>

      </div>

    </div>

    <div class="cover"></div>

  </div>

  <div class="playlist">

    <div class="playlist-bd">

      <div class="album-list">

        <div class="musicheader"></div>

        <div class="list"></div>

      </div>

      <div class="song-list">

        <div class="musicheader"><span></span></div>

        <div class="list"><ul></ul></div>

      </div>

    </div>

  </div>

  <div class="switch-player">

    <i class="fa fa-angle-right" style="margin-top: 20px;"></i>

  </div>

</div>

<div id="wenkmTips"></div>

<div id="wenkmLrc"></div>

<div id="wenkmKsc"></div>

<script language="javascript" src="<?php echo BLOG_URL;?>content/plugins/qingzz_music/js/mousewheel.min.js"></script>
<script language="javascript" src="<?php echo BLOG_URL;?>content/plugins/qingzz_music/js/scrollbar.min.js"></script>
<script language="javascript" src="<?php echo BLOG_URL;?>content/plugins/qingzz_music/js/player.min.js"></script>

<?php
}
function qingzz_music_menu() {
  echo '<div class="sidebarsubmenu" id="qingzz_music"><a href="./plugin.php?plugin=qingzz_music">迷津音乐播放器</a></div>';
}
addAction('index_head', 'qingzz_music_load');
addAction('index_footer', 'qingzz_music_list');
addAction('adm_sidebar_ext', 'qingzz_music_menu');