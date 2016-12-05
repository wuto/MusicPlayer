<?php if(!defined('EMLOG_ROOT')){die('err');}
include(EMLOG_ROOT.'/content/plugins/qingzz_music/qingzz_music_config.php');

?>
var wenkmList=[{
song_album:"<?php echo $config["albumName"];?>",
song_album1:"<?php echo $config["albumSubname"];?>",
song_file:"/",song_name:"<?php echo $config["songnameList"];?>".split("|"),
song_id:"<?php echo $config["songIdList"];?>".split("|")
}];