<?php
/**
 * Plugin Name: 迷津音乐播放器
 * Version: 1.1
 * Plugin URL: http://www.qingzz.cn/
 * Description: 播放器为开源的播放器,本地化,后台支持自定义专辑名称,输入歌单ID和单曲ID,支持网易、虾米、百度、QQ音乐！
 * Author: 前辈和小指嘿嘿^_^
 * Author Email: qingzz@qingzz.cn
 * Author URL: http://auv.qingzz.cn/
 */

!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view(){
	include(EMLOG_ROOT.'/content/plugins/qingzz_music/qingzz_music_config.php');
	?>
	<link href="/content/plugins/qingzz_music/style/style.min.css" type="text/css" rel="stylesheet" />
	<div class="com-hd">
		<b>播放器设置</b>
		<?php
		if(isset($_GET['setting'])){
			echo "<span class='actived'>设置保存成功! </span>";
		} else {
			echo "<span class='warning'>点击保存后请耐心等候,完成解析将自动跳转! </span>";
		}
		?>
	</div>
	<form action="./plugin.php?plugin=qingzz_music&action=setting" method="post">
		<table class="tb-set">
			<tr>
				<td align="right" width="40%"><b>自定义专辑名字：</b><br />(显示在音乐列表中的 精选曲目 )</td>
				<td><input type="text" class="txt" name="albumname" value="<?php echo $config["albumName"];?>" /></td>
			</tr>
			<tr>
				<td align="right" width="40%"><b>专辑后缀：</b><br />(精选曲目 - 与君共享)</td>
				<td><input type="text" class="txt" name="albumsubname" value="<?php echo $config["albumSubname"];?>" /></td>
			</tr>
			<tr>
				<td align="right"><b>歌单ID：</b><br />(填写歌单ID使用'|'分割，解析完成后推荐删除)</td>
				<td align="left"><b>单曲ID：</b><br />(填写单曲ID使用'|'分割)</td>
			</tr>
			<tr>
				<td  align="right"><textarea class="txt txt-lar" name="songsheetlist"><?php echo $config["songsheetList"];?></textarea></td>
				<td  align="left"><textarea class="txt txt-lar" name="songidlist"><?php echo $config["songIdList"];?></textarea></td>
			</tr>
			<tr>
				<td align="right"><b>小指提示：</b><br />(点击保存解析获取歌曲ID和歌名<br />耐心等候，会自动跳转回来)</td>
				<td align="left"><input type="submit" value="保存" /></td>
			</tr>
			<tr>
				<td align="right"><b>歌曲列表：</b><br />(已添加 <?php echo substr_count($config['songnameList'],'|'); ?> 首)</td>
				<td align="left"><?php echo str_replace('|',"<br />",$config['songnameList']); ?></td>
			</tr>
		</table>
	</form>
	<div>
		<h5>填写说明:</h5>
			可使用网易云音乐、虾米音乐、百度音乐和QQ音乐的歌单和单曲。<br>
			网易云音乐ID需要在数字后面加上wy，虾米音乐在后面加上xm<br>
			百度音乐在后面加上bd，QQ音乐在后面加上qq<br>
			个人推荐使用网易云音乐和虾米音乐<br>
			格式：<br>
			<pre>歌单ID|歌单ID</pre>
			<pre>歌曲ID|歌曲ID</pre>
			例如：<br>
			<pre>74452528wy|8540918xm|7171bd|1719644639qq</pre>
			<pre>29713754wy|1775751240xm|242078437bd|004IYRNO0Bl7LNqq</pre>
			<p>音乐ID可以在相应播放页面的地址栏中获得</p>
			<p>保存后自动解析歌单ID,将里面包含的歌曲ID去重后添加到单曲ID列表的后面,解析完成后推荐删除歌单ID</p>
			<p><a href="http://www.qingzz.cn/" data-ke-src="http://www.qingzz.cn/" target="_blank">迷津渡口</a><br>
			  <br>
	  </p>
	</div>
<script>
$('#qingzz_music').addClass('sidebarsubmenu1');
</script>
	<?php
}

function plugin_setting(){
	include(EMLOG_ROOT.'/content/plugins/qingzz_music/other/function.php');
	$songsheetlist=isset($_POST['songsheetlist'])?trim(str_replace(" ","",str_replace("\n", "",str_replace("\r\n", "",$_POST['songsheetlist']))),'|'):'';;
	$songidlist=isset($_POST['songidlist'])?trim(str_replace(" ","",str_replace("\n", "",str_replace("\r\n", "",$_POST['songidlist']))),'|'):'';;
	$songsheetlistarr=array_unique(array_filter(explode("|",$songsheetlist)));
	$songsheetlist=implode('|', $songsheetlistarr);
	foreach ($songsheetlistarr as $value) {
		$songidlist.=parseSheet($value);
	}
	$songidlistarr=array_unique(array_filter(explode("|",$songidlist)));
	$songidlist=implode('|',$songidlistarr);
	$songnamelist='';
	foreach ($songidlistarr as $value) {
		$songnamelist.=parseSongId($value).'|';
	}
	$songnamelist=trim($songnamelist);
	$newConfig = '<?php
	$config = array(
	"albumName" => "'.$_POST['albumname'].'",
	"albumSubname" => "'.$_POST['albumsubname'].'",
	"songsheetList" => "'.$songsheetlist.'",
	"songIdList" => "'.$songidlist.'",
	"songnameList" => "'.$songnamelist.'",
);';
	@file_put_contents(EMLOG_ROOT.'/content/plugins/qingzz_music/qingzz_music_config.php', $newConfig);
}
?>