<?php

  define("TITLE","�ӱ�ʡҰ��ֲ�����ݿ�");
  define("TABLEPRE","zhiwu_");
  define("USER_NAME","�û�");
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
  					1=>"��Ƶ",
  				);
  $pictureType = array(
					1=>"�����ӷ��",
					2=>"ɭ������",	
					3=>"��ҵ��ҵ",	
  				);
  $citys = array(
					1=>"ʯ��ׯ",
					2=>"����",
					3=>"�żҿ�",
					4=>"�е�",
					5=>"����",
					6=>"��̨",
					7=>"��ˮ",
					8=>"����",
					9=>"�ػʵ�",
					10=>"��ɽ",
					11=>"�ȷ�",		
					12=>"����",	
					13=>"����",				
  				);
							
?>