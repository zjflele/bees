<?
	require_once '../../include/include.php';
	checklogin();
	$status = intval($_GET['status']);
	$id = intval($_GET['id']);
	if($id=='')
	{
		echo "<script>window.close();</script>";
		exit;
	}
	else
	{
		echo $sql = "update market set status='$status' where id=$id";
		$db->query($sql);
	}
?>