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
     alert("��������Ŀ������ɾ����")
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
     alert("ɾ��ʧ�ܣ��������Ա��ϵ��")
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
    alert('ɾ���ɹ���');
    window.close();
</script>
<?
  }
?>