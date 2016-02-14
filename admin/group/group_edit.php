<?
	include("../../include/include.php");
	checklogin();

if ($_POST['action']=='edit')
{
$sql="select * from ".TABLEPRE."sort where id=".$pid."";
$myrs=mysql_query($sql,$conn);
$rec=mysql_fetch_array($myrs);
$ndirlist=$rec["parentlist"]."->[<a href=P_S?pid=".$id.">".$name."</a>]";
 $name = trim($_POST['name']); 
 $tourl = trim($_POST['tourl']); 
 $istop = trim($_POST['istop']);
 $display = intval($_POST['display']);
 $info = trim($_POST['info']);
$sql = "update ".TABLEPRE."sort set parentlist='$ndirlist',name='$name',tourl='$tourl',istop='$istop',display='$display',info='$info' where id=$id";
$myrs=mysql_query($sql,$conn);
// ------------------------- 进行校验 ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("信息失败！")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('信息修改成功！');
    window.close()
</script>
<?
  }
}
  $sqlstr="select * from ".TABLEPRE."sort where id=".$id." ";
  $myrs=mysql_query($sqlstr,$conn);
  $rec_n=mysql_fetch_array($myrs)
?>
<html>
<head>
<title><?php
echo $html_title;
?></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="../image/MAIN.CSS" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table border="0" width="463" cellspacing="1" cellpadding="0" style="font-size: 9pt" bgcolor="#9999FF" align="center">
  <center>
    <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="2"> <p align="center"><font color="#ff0000"><b>栏 
          目 修 改</b></font></p></td>
    </tr>
  </center>
  <form method="post" action="group_edit.php" name="info">
    <tr> 
      <td width="199" height="20" align="right" bgcolor="#f5f5f5" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4">ID：</td>
      <td width="261" height="20" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5"> 
        <?=$rec_n["id"]?>
        <input type="hidden" name="id" value="<?=$rec_n["id"]?>"> <input name="pid" type="hidden" id="pid" value="<?=$rec_n["parentid"]?>"> 
      </td>
    </tr>	
    <tr> 
      <td align="right" height="20" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5"> 
        栏目名称：</td>
      <td width="261" height="20" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5"> 
        <?
	  $text = $rec_n["parentlist"];
	  $text = str_replace("P_S", "group_edit.php", $text);
	  $text = str_replace("pid", "id", $text);
	  echo $text;
	  ?>      </td>
    </tr>
    <tr> 
      <td height="20" align="right" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5">修改为：</td>
      <td width="261" height="20" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5"> 
        <input name="name" type="text" id="name" onMouseOver=this.focus() value="<?=$rec_n["name"]?>" size="12"> 
      </td>
    </tr>
	 
	 <tr> 
      <td height="20" align="right" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5">显示顺序：</td>
      <td width="261" height="20" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5"> 
       <input name="display" type="text" id="display" onMouseOver=this.focus() value="<?=$rec_n["display"]?>" size="12"> 
       </td>
    </tr>
	<tr> 
      <td height="20" align="right" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5">链接地址：</td>
      <td width="261" height="20" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5"> 
        <input name="tourl" type="text" id="tourl" value="<?=$rec_n["tourl"]?>" size="20"> 
      </td>
    </tr>
    <tr> 
      <td height="20" align="right" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5">链接地址：</td>
      <td width="261" height="20" style="padding-left: 12; padding-right: 12; padding-top: 4; padding-bottom: 4" bgcolor="#f5f5f5"> 
        <input name="info" type="text" id="info" value="<?=$rec_n["info"]?>" size="20"> 
      </td>
    </tr>
    <tr align="center" bgcolor="#EBECED"> 
      <td colspan="2" height="30"> 
	   <input type="hidden" name="action" value="edit">
	  <input type="submit" value="提交" name="b1" > 
        &nbsp; <input type="reset" value="重写" name="b1"> </td>
    </tr>
  </form>
</table>
</body>
</html>
