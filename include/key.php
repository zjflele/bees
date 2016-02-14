<?php
header("Content-Type: image/jpeg");
//echo "12345";
session_start();
$w=60;
$h=20;
$s=15;
$r=0;
$f="arial.ttf";
srand(time());
$max=rand(10000,99999);
$_SESSION["Hebly_yanzheng"]=$max;
$strlen=strlen($max);
if(strlen($max)<5){
	for($i=0;$i<5-$strlen;$i++){
		$max="0".$max;	
	}
}
$image=imagecreate($w,$h);
$white=imagecolorallocate($image,255,255,255);
$black=imagecolorallocate($image,0,0,0);
/*
$arr=imagettfbbox($s,$r,$f,$max);
$x=($arr[0]+$arr[2]+$arr[4]+$arr[6])/4;
$y=($arr[1]+$arr[3]+$arr[5]+$arr[7])/2;
imagettftext($image,$s,$r,15,20,$black,$f,$max);
*/
$x=($w-5*imagefontwidth(5))/2;
$y=($h-imagefontheight(5))/2;
imagestring($image,5,$x,$y,$max,$black);
imagejpeg($image);
imagedestroy($image);

?>
