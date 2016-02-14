<?
	require_once '../../include/include.php';
	checklogin();	
	$datetime=date("Y-m-d H:i:s");
	if($id=='')
	{
		echo "<script>window.close();</script>";
		exit;
	}
	else
	{
		$sql = "update ".TABLEPRE."flash set isshow=1,show_time='$datetime' where id=$id";
		echo  $sql;
		mysql_query($sql,$conn);
	}
?>