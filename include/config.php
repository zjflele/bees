<?php

  define("TITLE","河北省野生植物数据库");
  define("TABLEPRE","zhiwu_");
  define("USER_NAME","用户");
  define("SERVER_ID","1");  
  define("MD5_KEY","zhiwu");
  define("WEB_PATH",$_SERVER["DOCUMENT_ROOT"].'/');
  $pagesize=20;

  if ($_GET){
	  foreach ($_GET as $key => $value){
		 $$key = $value;
	  }
  }

  if ($_POST){
	  foreach ($_POST as $key => $value){
		 $$key = $value;
	  }
  }
  
  $videoType = array(
  					1=>"视频",
  				);
  $pictureType = array(
					1=>"塞罕坝风光",
					2=>"森林旅游",	
					3=>"林业产业",	
  				);
  $citys = array(
					1=>"石家庄",
					2=>"保定",
					3=>"张家口",
					4=>"承德",
					5=>"沧州",
					6=>"邢台",
					7=>"衡水",
					8=>"邯郸",
					9=>"秦皇岛",
					10=>"唐山",
					11=>"廊坊",		
					12=>"定州",	
					13=>"辛集",				
  				);
							
?>