<?
	include("../../include/include.php");
?>
<?
//print_r($mid);exit;
//-------------开通--------------
if ($caozuo=='tj')
{
	for ($i=1; $i<=20; $i++) {
		if ($mid[$i]<>"")
		{
			$sqlstr="update market set status=1 where id='$mid[$i]'";
			//echo $sqlstr;
			$myrs=mysql_query($sqlstr,$myconn);
		}
	}
}


//------------删除---------------
if ($caozuo=='del')
{
	echo $xz1;
	for ($i=1; $i<=20; $i++) {
		if ($mid[$i]<>"")
		{
			//删除文字信息
		  $sqlstr="delete from market where id=$mid[$i] ";
		  //echo $sqlstr;
		  $myrs=mysql_query($sqlstr,$myconn);
		  //window.opener.location.reload();
		}
	}
}

//-----------批量编辑---------------
if ($caozuo=='edit_all')
{
	if ($_POST['typeid']){
		$market['typeid'] = intval($_POST['typeid']);	
	}
	if ($_POST['paddress']){
		$market['paddress'] = trim($_POST['paddress']);	
	}
	if ($_POST['uname']){
		$market['uname'] = trim($_POST['uname']);	
	}
	if ($_POST['phone']){
		$market['phone'] = trim($_POST['phone']);	
	}
	if ($_POST['pfrom']){
		$market['pfrom'] = trim($_POST['pfrom']);	
	}
	for ($i=1; $i<=20; $i++) {
		if ($mid[$i]<>"")
		{
			//删除文字信息
			updatetable('market',$market,"id=".$mid[$i]);
		 	$myrs = 1;
		}
	}
		
}
?>
<?
 if (!$myrs)
 {
?>
	<script language=javascript>
         history.back()
         alert("信息修改失败！")
    </script>
<?
    exit();
  }
  else {
  ?>
	<script language=javascript>
        alert('信息修改成功！');
        window.opener.location.reload();
        window.close();
    </script>
<? 
}
?>
<meta http-equiv="content-type" content="text/html; charset=gb2312">