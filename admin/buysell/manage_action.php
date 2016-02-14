<?
	include("../../include/include.php");
?>
<?
//-------------开通--------------
if ($caozuo=='tj')
{
for ($i=1; $i<=20; $i++) {
if ($xz[$i]<>"")
{
$sqlstr="update ".TABLEPRE."buysell set pass=1 where sellid='$xz[$i]'";
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
if ($xz[$i]<>"")
{
//删除文字信息
  $sqlstr="delete from ".TABLEPRE."buysell where sellid=$xz[$i] ";
  //echo $sqlstr;
  $myrs=mysql_query($sqlstr,$myconn);
  //window.opener.location.reload();
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