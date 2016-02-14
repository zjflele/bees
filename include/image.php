<?php
 //FileName:authimg.php
 //Description:
 //Creater:alvar
 //Createtime:2006-5-4
 //Lastmodtime:

 session_start();
?>
<?php 
//生成验证码图片 
Header("Content-type: image/PNG"); 
srand((double)microtime()*1000000);//播下一个生成随机数字的种子，以方便下面随机数生成的使用

//session_start();//将随机数存入session中
$_SESSION['authnum']="";
$im = imagecreate(70,20) or die("Cant's initialize new GD image stream!");  //制定图片背景大小
$black = ImageColorAllocate($im, 0,0,0); //设定三种颜色
$white = ImageColorAllocate($im, 255,255,255); 
$gray = ImageColorAllocate($im, 200,200,200); 

imagefill($im,0,0,$gray); //采用区域填充法，设定（0,0）

//生成数字和字母混合的验证码方法
$ychar="0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
$list=explode(",",$ychar);
for($i=0;$i<4;$i++){
 $randnum=rand(0,35);
 $authnum.=$list[$randnum];
}

//while(($authnum=rand()%100000)<10000); //生成随机的五们数
//将五位整数验证码绘入图片 
$_SESSION['authnum']=$authnum;

imagestring($im, 5, 10, 3, $authnum, $black);
// 用 col 颜色将字符串 s 画到 image 所代表的图像的 x，y 座标处（图像的左上角为 0, 0）。
//如果 font 是 1，2，3，4 或 5，则使用内置字体

for($i=0;$i<200;$i++) //加入干扰象素 
{ 
$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
imagesetpixel($im, rand()%70 , rand()%30 , $randcolor); 
} 
ImagePNG($im); 
ImageDestroy($im); 

?>

