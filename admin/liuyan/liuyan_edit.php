<?
	include("../../include/include.php");
	checklogin();
?>
<?
if ($action=='action')
{

   $updtime=date("Y-m-d H:i:s");
   $sql="UPDATE `".TABLEPRE."liuyan` SET `name` = '$name' ,`title` = '$title' ,`email` = '$email' ,`tel` = '$tel' ,`neirong` = '$neirong' ,`huifu` = '$huifu' ,`hfshijian` = '$updtime' ,`y_n` = '$y_n' WHERE `id` = '$id'";
//echo $sql;
$myrs=mysql_query($sql,$myconn);
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
    alert('信息发布成功！');
    window.close()
</script>
<?
  }
}
  $sqlstr="select * from ".TABLEPRE."liuyan where id=".$id." ";
  $myrs=mysql_query($sqlstr,$myconn);
  $rec=mysql_fetch_array($myrs)
?>
<HTML>
<HEAD>
<TITLE>留言管理平台</TITLE>
<script language="vbscript">
<!--
function checkform()

	tag=0
	if form.title.value=""  then
		msgbox("请填写信息标题")
		form.title.focus 
		tag=1
	elseif form.name.value=""  then
		msgbox("请添加您的姓名")
		form.name.focus 
		tag=1
	elseif form.email.value=""  then
		msgbox("请添加你的邮箱地址")
		form.email.focus 
		tag=1
	end if
	if tag=0 then form.submit()
End Function
//-->
</script>
<META content="text/html; charset=gb2312" http-equiv=Content-Type>
<META content="MSHTML 5.00.2920.0" name=GENERATOR>
<link rel="stylesheet" href="./admin.css" type="text/css">
</HEAD>
<BODY leftMargin=0 topMargin=0 style="font-size:12px;">
<table width="550" border="0" cellspacing="0" cellpadding="0" align="center" height="100%">
  <tr> 
      
    <td valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="35"> 
                  
            <div align="center"><b><font color="#FF0000" size="3">留 言 回 复</font></b></div>
                </td>
              </tr>
              <tr> 
                <td> 
                  
            <table style="border-collapse: collapse" bgcolor=#9999FF border=0 cellspacing=1 cellpadding=3 width="100%">
              <form name="form" method="post" action="liuyan_edit.php?action=action">
                <tr bgcolor="#CCCCCC"> 
                  <td background="../../images/bj_biao1.jpg">
<div align="right">留言标题：</div></td>
                  <td background="../../images/bj_biao1.jpg"> 
                    <input name="title" type="text" id="title" value="<?=$rec["title"]?>" size="50"> 
                    <font color="#FF0000">*</font> </td>
                </tr>
                <tr bgcolor="#CCCCCC"> 
                  <td background="../../images/bj_biao1.jpg">
<div align="right">留言人：</div></td>
                  <td background="../../images/bj_biao1.jpg"> 
                    <input name="name" type="text" id="name" value="<?=$rec["name"]?>" size="10">
                    <font color="#FF0000">*</font> <input name="id" type="hidden" id="id" value="<?=$rec["id"]?>"></td>
                </tr>
                <tr bgcolor="#CCCCCC"> 
                  <td background="../../images/bj_biao1.jpg">
<div align="right">电子邮件：</div></td>
                  <td background="../../images/bj_biao1.jpg"> 
                    <input name="email" type="text" id="email" value="<?=$rec["email"]?>" size="20"> 
                    <font color="#FF0000">*</font> </td>
                </tr>
                <tr bgcolor="#CCCCCC"> 
                  <td background="../../images/bj_biao1.jpg">
<div align="right">电话：</div></td>
                  <td background="../../images/bj_biao1.jpg"> 
                    <input name="tel" type="text" id="tel" value="<?=$rec["tel"]?>" size="20"> 
                  </td>
                </tr>
                <tr bgcolor="#CCCCCC"> 
                  <td background="../../images/bj_biao1.jpg">
<div align="right">信息内容：</div></td>
                  <td background="../../images/bj_biao1.jpg"> 
                    <textarea name="neirong" cols="50" rows="6" id="neirong"><?=$rec["neirong"]?></textarea> 
                    <font color="#FF0000">*</font> </td>
                </tr>
                <tr background="../images/bj_biao1.jpg"> 
                  <td width="88" align=right background="../../images/bj_biao1.jpg" bgcolor="#FFFFFF">回复内容：</td>
                  <td width="447" background="../../images/bj_biao1.jpg" bgcolor="#FFFFFF">
<textarea name="huifu" cols="50" rows="6" id="huifu"><?=$rec["huifu"]?></textarea> 
                  </td>
                </tr>
                <tr background="../images/bj_biao1.jpg"> 
                  <td align=right background="../../images/bj_biao1.jpg" bgcolor="#FFFFFF">通过审核：</td>
                  <td background="../../images/bj_biao1.jpg" bgcolor="#FFFFFF"> 
                    <input type="checkbox" name="y_n" value="1" 
					<?
					if ($rec["y_n"]==1)
					echo "checked";
					?>
					> </td>
                </tr>
                <tr background="../../images/bj_biao1.jpg"> 
                  <td colspan="2" align=right bgcolor="#FFFFFF"> 
                    <div align="center"> 
                      <input type="button" value="提交" name="b1"  onClick=checkform()>
                      <input type="submit" name="Submit22" value="重写">
                    </div></td>
                </tr>
              </form>
            </table>
                </td> 
              </tr>
            </table>
    </td>
    </tr>
  </table>
</BODY>
</HTML>
