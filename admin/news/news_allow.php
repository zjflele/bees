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
		$sql = "update ".TABLEPRE."article set pass='$status' where id=$id";		
		mysql_query($sql,$conn);
	}
?>