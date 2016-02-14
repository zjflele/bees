<?php	
	include("../../include/include.php");
	$sdate = trim($_GET['s']);
	$edate = trim($_GET['e']);
	$sqlstr="select * from ".TABLEPRE."visit_count where vtime>='$sdate' and vtime<='$edate'";	
	$myrs = mysql_query($sqlstr,$myconn);
	while($rec = mysql_fetch_array($myrs)){
		$arrVisit['vtime'][] = $rec['vtime'];
		$arrVisit['vnum'][] = $rec['vnum'];
	}

	header("content-type:text/xml");
	echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	echo '<chart>'."\n";
	echo '<series>'."\n";
	foreach($arrVisit['vtime'] as $k => $v){
		echo '<value xid="'.$k.'">'.$v.'</value>'."\n";
	}	
	echo '</series>'."\n";
	echo '<graphs>'."\n";
	echo '<graph gid="1">'."\n";
	foreach($arrVisit['vnum'] as $k => $v){
		echo '<value xid="'.$k.'">'.$v.'</value>'."\n";
	}
	echo '</graph>'."\n";
	echo '</graphs>'."\n";
	echo '</chart>';	
?>