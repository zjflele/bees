<?
	require_once '../../include/include.php';
	checklogin();
	if($status=='' or $id=='')
	{
		echo "<script>window.close();</script>";
		exit;
	}
	else
	{
		$sql = "update ".TABLEPRE."buysell set pass='$status' where sellid=$id";		
		mysql_query($sql,$conn);
	}
?>