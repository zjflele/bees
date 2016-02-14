<?php
include("./include.php");
$nowtime = date('Y-m-d');
$sql="select id from ".TABLEPRE."visit_count where vtime='$nowtime'";
$myrs=mysql_query($sql,$myconn);
$row = mysql_fetch_array($myrs);
if ($row){
	mysql_query("UPDATE ".TABLEPRE."visit_count SET vnum=vnum+1 WHERE id=".$row['id'],$myconn);
}else{
	mysql_query("INSERT INTO `".TABLEPRE."visit_count` (`id` ,`vnum` ,`vtime` ) VALUES (NULL , '1', '$nowtime')",$myconn);
}
?>