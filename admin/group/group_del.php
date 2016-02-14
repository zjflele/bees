<?
	include("../../include/include.php");
	checklogin();

$ddt=trim($id);
  $sqlstr="select *  from ".TABLEPRE."sort where id =".$ddt." ";
  $myrs=mysql_query($sqlstr,$conn);
  $rec=mysql_fetch_array($myrs);
  $sort_f=$rec["parentid"];
  $sortname = $rec['name'];
  $sqlstr="select * from ".TABLEPRE."sort where parentid =".$ddt." ";
  //echo $sqlstr;
  $myrs=mysql_query($sqlstr,$conn);
  $rec=mysql_num_rows($myrs);
  //echo  $rec;
 if ($rec) {
?>
<script language=javascript>
     alert("还有子栏目，不能删除！")
	 window.close();
</script>
<?
    exit();
  }
  else {
  $sqlstr="delete from ".TABLEPRE."sort where id=".$ddt." ";
  $myrs=mysql_query($sqlstr,$conn);
   }
if (!$myrs) {
?>
<script language=javascript>
     alert("删除失败，请与管理员联系！")
	 window.close();
</script>
<?
    exit();
  }
  else {
  $sqlstr="select * from ".TABLEPRE."sort where parentid =".$sort_f." ";
  //echo $sqlstr;
  $myrs=mysql_query($sqlstr,$conn);
  $rec=mysql_num_rows($myrs);
  if (!$rec)
  {
  $sql = "update ".TABLEPRE."sort set yn_mo=1 where id=$sort_f";
  $myrs=mysql_query($sql,$conn);
  }
?>
<script language=javascript>
    alert('删除成功！');
    window.close();
</script>
<?
  }
?>