<?php
date_default_timezone_set('Asia/Tokyo');
header("Content-Type: text/html; charset=UTF-8");
require_once(__DIR__.'/cache/phpfastcache.php');
phpfastcache::setup("storage","auto");
for($i=4;$i>=0;$i-=1){
	$data[$i]=get(date("Y/m/d",strtotime("-${i} day")));
}
//デバッグ用
//$data[$i]=get("2014/05/03");
$alldata=explode("\n",implode('',$data));
$number=count($alldata);
for($n=0;$n<$number;$n++){
	if(strpos($alldata[$n],'QUA')===false||substr($alldata[$n],33,33)!=4){
		$alldata[$n]='';
	}
}
$alldata=array_values(array_filter($alldata));
$number=count($alldata);
for($m=0;$m<$number;$m++){
	$shingen[]=mb_substr($alldata[$m],29,mb_strpos(mb_substr($alldata[$m],29),'/'));
}
$shingenD[]=array_filter(array_count_values($shingen),'filter');
//デバッグ用
//print_r($shingenD);
//print_r($shingen5);
//print_r($alldata);
//print_r($shingen);
function get($day){
	$url = "http://api.p2pquake.com/v1/userquake?date=${day}";
	try {
	$cache=phpfastcache();
	$html= $cache->get($url);
    if ($html==false) {
      $html = file_get_contents($url, false, NULL);
	  $html= mb_convert_encoding($html, "UTF-8", "SJIS");
      if($html!==false) {
		$cache->set($url,$html,60);
      }
      else {
		  die("エラー地震情報APIへの接続に失敗しました<br>");
      }
	}
	} catch (Exception $e) {
		die("ERROR地震情報APIへの接続に失敗しました。<br>"); 
	}
	return $html;
}
function filter($var){
    return ($var>=12)? TRUE : FALSE;
}
?>