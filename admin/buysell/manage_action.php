<?
	include("../../include/include.php");
?>
<?
//-------------��ͨ--------------
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
//------------ɾ��---------------
if ($caozuo=='del')
{
echo $xz1;
for ($i=1; $i<=20; $i++) {
if ($xz[$i]<>"")
{
//ɾ��������Ϣ
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
     alert("��Ϣ�޸�ʧ�ܣ�")
</script>
<?
    exit();
  }
  else {
  ?>
<script language=javascript>
    alert('��Ϣ�޸ĳɹ���');
	window.opener.location.reload();
	window.close();
</script>
<? 
}
?>
<meta http-equiv="content-type" content="text/html; charset=gb2312">