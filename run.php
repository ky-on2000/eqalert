<?php
date_default_timezone_set('Asia/Tokyo');
ini_set('display_errors', '1');
require __DIR__.'/get.php';
require __DIR__.'/twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
$ck="**********";
$cs="**********";
$at="**********";
$as="**********";
$o=count($shingenD);
$check=file_get_contents("date.txt");
if($check="2016/10/18"){
	if($o==0){
		tweet(date(Y年m月d日).'現在、群発地震は起きていません。',$ck,$cs,$at,$as);
		file_put_contents("date.txt",date("Y/m/d"));
	}else{
		while($o!==0){
			$o-=1;
			foreach($shingenD[$o] as $key=>$value){
				tweet('【注意】'.$key.'を震源とする地震がこの5日間で'.$value.'回発生しています。念のため地震や火山活動に注意してください。',$ck,$cs,$at,$as);
				file_put_contents("date.txt",date("Y/m/d"));
			}
		}
	}
}else{
	echo "えらー";
}
function tweet($message,$ck,$cs,$at,$as){
try{
	//config
	$connection = new TwitterOAuth($ck, $cs, $at, $as);
	$content = $connection->get("account/verify_credentials");
	$statues = $connection->post("statuses/update", ["status" =>$message]);
} catch (Exception $e) {
	print "ERROR:".$e->getMessage();
}
}
?>
