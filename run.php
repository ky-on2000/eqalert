<?php
date_default_timezone_set('Asia/Tokyo');
require __DIR__.'/get.php';
require __DIR__.'/twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
$ck="HYxUUsHqmLEJZIlJs7rO8j01e";
$cs="Xx5xl6gmSDR9bIcrgVtXWgITGdzJpFWPV1o7uu8J79JNHF8Tyh";
$at="4712110981-dwS1v92kSeBzJPbueIwbkIOYBFdZfcgnjlATDxm";
$as="oAnyxfWvPgG5QXobSeIa3lxHz54ROYKPUFm5HBeAFVU5Z";
$o=count($shingenD);
while($o!==0){
	$o-=1;
	foreach($shingenD[$o] as $key=>$value){
		tweet('【注意】'.$key.'を震源とする地震がこの5日間で'.$value.'回発生しています。念のため地震や火山活動に注意してください。',$ck,$cs,$at,$as);
		file_put_contents("date.txt",date("Y/m/d"));
	}
}
if(date("Y/m/d",strtotime("-1 day"))==file_get_contents("date.txt")){
	tweet(date(Y年m月d日).'現在、群発地震は起きていません。',$ck,$cs,$at,$as);
	file_put_contents("date.txt",date("Y/m/d"));
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
