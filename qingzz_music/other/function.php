<?php
// 播放器后台解析歌曲代码
error_reporting(0);
function parseSheet($songsheetstr) {
		$type=substr($songsheetstr,-2);
		$songsheetid=substr($songsheetstr, 0, -2);
		$play_list='';

		if($type=='wy'){
    		$data = get_curl('http://music.163.com/api/playlist/detail?id='.$songsheetid,0,'http://music.163.com/');
    		$arr = json_decode($data, true);
    		foreach ($arr["result"]["tracks"] as $value) {
			    $music_id = $value["id"];
			    $play_list .= '|'.$music_id.'wy';
    		}
		}elseif($type=='xm'){
			$data=get_curl('http://www.xiami.com/song/playlist/id/'.$songsheetid.'/type/3/cat/json');
			$arr=json_decode($data, true);
			foreach ($arr["data"]["trackList"] as $value) {
			    $music_id = $value["songId"];
			    $play_list .= '|'.$music_id.'xm';
    		}
		}elseif($type=='bd'){
			$data=get_curl('http://tingapi.ting.baidu.com/v1/restserver/ting?from=webapp_music&method=baidu.ting.diy.gedanInfo&listid='.$songsheetid);
			$arr=json_decode($data,true);
			foreach ($arr["content"] as $value) {
			    $music_id = $value["song_id"];
			    $play_list .= '|'.$music_id.'bd';
    		}
		}elseif($type=='qq'){
			$data=get_curl('http://c.y.qq.com/qzone/fcg-bin/fcg_ucc_getcdinfo_byids_cp.fcg?type=1&json=1&utf8=1&onlysong=0&format=jsonp&jsonpCallback=playlistinfoCallback&inCharset=utf8&outCharset=utf-8&disstid='.$songsheetid);
			$data=substr($data,21,-1);
			$arr=json_decode($data,true);
			foreach($arr["cdlist"][0]["songlist"] as $value) {
				$music_id = $value["songmid"];
			   	 $play_list .= '|'.$music_id.'qq';
			}
		}
		return $play_list;
}

function parseSongId($songidstr) {
	$type=substr($songidstr,-2);
	$singlesongid=substr($songidstr, 0, -2);
		if($type=='wy'){
			$data=get_curl('http://music.163.com/api/song/detail/?ids=%5B'.$singlesongid.'%5D',0,'http://music.163.com/');
			$arr=json_decode($data, true);
			$SongName=$arr['songs'][0]['name'];
			$Artist=$arr['songs'][0]['artists'][0]['name'];
			$Album=$arr['songs'][0]['album']['name'];
			$ListenUrl=$arr['songs'][0]['mp3Url'];
			$PicUrl=$arr['songs'][0]['album']['picUrl'];
		}elseif($type=='xm'){

			$data=get_curl('http://www.xiami.com/song/playlist/id/'.$singlesongid.'/type/0/cat/json');

			$arr=json_decode($data, true);

			$SongName=$arr['data']['trackList'][0]['title'];

			$Artist=$arr['data']['trackList'][0]['artist'];

			$Album=$arr['data']['trackList'][0]['album_name'];

			$ListenUrl=ipcxiami($arr['data']['trackList'][0]['location']);

			$LrcUrl=$arr['data']['trackList'][0]['lyric'];

			$PicUrl=$arr['data']['trackList'][0]['album_pic'];

		}elseif($type=='bd'){

			$data=get_curl('http://music.baidu.com/data/music/fmlink?songIds='.$singlesongid.'&type=mp3&rate=320');

			$arr=json_decode($data,true);

			//print_r($arr);exit;

			preg_match('!music/(\d+)/!',$arr['data']['songList'][0]['songLink'],$json);

			$songid=$json[1];

			$SongName=$arr['data']['songList'][0]['songName'];

			$Artist=$arr['data']['songList'][0]['artistName'];

			$Album=$arr['data']['songList'][0]['albumName'];

			$ListenUrl='http://musicdata.baidu.com/data2/music/'.$songid.'/'.$songid.'.mp3';

			$LrcUrl=$arr['data']['songList'][0]['lrcLink'];

			$PicUrl=$arr['data']['songList'][0]['songPicRadio'];

		}elseif($type=='qq'){
			$data=get_curl('http://c.y.qq.com/v8/fcg-bin/fcg_play_single_song.fcg?songmid='.$singlesongid.'&tpl=yqq_song_detail&format=jsonp&callback=getOneSongInfoCallback&g_tk=938407465&jsonpCallback=getOneSongInfoCallback&loginUin=0&hostUin=0&format=jsonp&inCharset=utf8&outCharset=utf-8&notice=0&platform=yqq&needNewCode=0');
			$data=substr($data,23,-1);
			$arr=json_decode($data,true);
			$SongName=$arr["data"][0]["title"];

			$Artist=$arr["data"][0]['singer'][0]['name'];

			$Album=$arr["data"][0]['album']['name'];

			$id=$arr["data"][0]['id'];
			$ListenUrl='http://stream1.qqmusic.qq.com/'.$id.'.mp3';
			$PicUrl='http://y.gtimg.cn/music/photo_new/T002R300x300M000'.$arr["data"][0]["album"]["mid"].'.jpg';
		}

		return $SongName;

}

function get_curl($url, $post=0, $referer=0, $cookie=0, $header=0, $ua=0, $nobaody=0)

{

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

	$httpheader[] = "Accept:application/json";

	$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";

	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";

	$httpheader[] = "Connection:close";

	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);

	if ($post) {

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	}

	if ($header) {

		curl_setopt($ch, CURLOPT_HEADER, true);

	}

	if ($cookie) {

		curl_setopt($ch, CURLOPT_COOKIE, $cookie);

	}

	if($referer){

		if($referer==1){

			curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');

		}else{

			curl_setopt($ch, CURLOPT_REFERER, $referer);

		}

	}

	if ($ua) {

		curl_setopt($ch, CURLOPT_USERAGENT, $ua);

	}

	else {

		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (MSIE 9.0; Windows NT 6.1; Trident/5.0)");

	}

	if ($nobaody) {

		curl_setopt($ch, CURLOPT_NOBODY, 1);

	}

	curl_setopt($ch, CURLOPT_ENCODING, "gzip");

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$ret = curl_exec($ch);

	curl_close($ch);

	return $ret;

}

function ipcxiami($location){

	$count = (int)substr($location, 0, 1);

	$url = substr($location, 1);

	$line = floor(strlen($url) / $count);

	$loc_5 = strlen($url) % $count;

	$loc_6 = array();

	$loc_7 = 0;

	$loc_8 = '';

	$loc_9 = '';

	$loc_10 = '';

	while ($loc_7 < $loc_5){

	$loc_6[$loc_7] = substr($url, ($line+1)*$loc_7, $line+1);

	$loc_7++;

	}

	$loc_7 = $loc_5;

	while($loc_7 < $count){

	$loc_6[$loc_7] = substr($url, $line * ($loc_7 - $loc_5) + ($line + 1) * $loc_5, $line);

	$loc_7++;

	}

	$loc_7 = 0;

	while ($loc_7 < strlen($loc_6[0])){

	$loc_10 = 0;

	while ($loc_10 < count($loc_6)){

	$loc_8 .= @$loc_6[$loc_10][$loc_7];

	$loc_10++;

	}

	$loc_7++;

	}

	$loc_9 = str_replace('^', 0, urldecode($loc_8));

	return $loc_9;

}