<?php
 	ini_set("error_reporting",E_ERROR);
 	session_start();
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/adodb/adodb.inc.php");
                

	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/conn.php");	
        
        
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php"); 
   

	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/function.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/function.inc.php");	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/obj.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/vars.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/stddb.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/javascript.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/string.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/easydb.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/page.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/file.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/upload.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/shtml.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/template.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/makeThumb.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/sqlin.php");	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/include/FileIO.class.php");	
        
        
	$webset = unserialize(FileIO::getFileContent($_SERVER["DOCUMENT_ROOT"] . "/include/webset.conf"));
	if ($webset['isclose'] && strpos($_SERVER['REQUEST_URI'],'admin')===false){
		//print_r($_SERVER);
		echo $webset['close_notice'];exit;
	}

	//ÅÐ¶ÏÖ÷Õ¾ÉèÖÃ
	$webset = unserialize(FileIO::getFileContent( dirname(WEBROOT) . "/include/webset.conf"));
	if ($webset['other_site']['isclose']['wutaishan'] && strpos($_SERVER['REQUEST_URI'],'admin')===false){
		echo $webset['other_site']['close_notice']['wutaishan'];exit;
	}
        
	if (!$footer)
		$footer = GetValueFromTable('fcontent','index_set','fid=14');
	
	$siteid = intval($_GET['siteid']);
?>
