<?
	include("../../include/include.php");
	checklogin();

if (isset($_POST['truesubmit']) && intval($_POST['truesubmit'])==1)
{ 
 $question = trim($_POST['question']);
 $answer = trim($_POST['answer']);
  $id = intval($_POST['id']);
  $sql="UPDATE `".TABLEPRE."question_answer` SET `question` = '$question',`answer` = '$answer' WHERE  `id` = '$id'";
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
    alert('修改成功！');
      location.href="question_manage.php";
</script>
<?
  }
}

if(@$_GET["id"])
	{
		$obj = new EasyDB(question_answer);
		$obj->AcceptType="USER";
		$obj->User["id"] 		= $obj->Get["id"];		
		$obj->IDVars="id";
		$obj->Select();
		$obj->FetchLine();
	}	
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script language="vbscript">
<!--
function checkform()
	tag=0
	if form.question.value=""  then
		msgbox("请填写问题")
		form.question.focus 
		tag=1
	elseif form.answer.value=""  then
		msgbox("请填写答案")
		form.answer.focus 
		tag=1      
	end if
	if tag=0 then form.submit()
End Function
//-->
</script>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="95%" align=center 
      border=0>
        <TBODY>
        <TR class=header align=left>
          <TD><font color="#FFFFFF"><strong>供求验证问题添加</strong></font></TD>
		   </TR>
        <TR>
          <TD height="543" bgColor=#f8f9fc valign="top">
		 <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form" method="post" action="question_edit.php">
                      <tr bgcolor="#FFFFFF"> 
                        <td width="14%">问题：</td>
                        <td width="86%"> <input name="question" type="text" id="question" size="50" value="<?=$obj->GetField("question")?>"></td>
                      </tr>
					  <tr bgcolor="#FFFFFF"> 
                        <td>答案：</td>
                        <td> <input name="answer" type="text" id="answer"  size="20" value="<?=$obj->GetField("answer")?>"></td>
                      </tr>
                      <tr bgcolor="#FFFFFF"> 
                        <td colspan="2" align="center"><input type="hidden" name="id" id="id" value="<?=$obj->GetField("id")?>"><input type="hidden" name="truesubmit" id="truesubmit" value="1"> <input type="button" value="提交" name="b1"  onClick=checkform()> 
                          <input type="reset" name="Submit22" value="重写"> </td>
                      </tr>
                    </form>
                  </table> 
		  
		  </TD>
		  </tr>
          </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
