<?
	include("../../include/include.php");
	checklogin();
$file = "../../upload/config/gq.txt";
if (isset($_POST['truesubmit']) && intval($_POST['truesubmit'])==1)
{ 
$allowstatus = trim($_POST['allowstatus']);

$fp = fopen($file,"w"); 
fputs($fp, $allowstatus); 
fclose($fp);
?>
<script language=javascript>
    alert('设置成功！');
      location.href="set.php";
</script>
<?
}
$allowstatus = intval(file_get_contents($file));
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>

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
          <TD><font color="#FFFFFF"><strong>供求信息发布调置</strong></font></TD>
		   </TR>
        <TR>
          <TD height="543" bgColor=#f8f9fc valign="top">
		 <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form" method="post" action="set.php">
                      <tr bgcolor="#FFFFFF"> 
                        <td width="14%">是否允许发布：</td>
                        <td width="86%"><label>
                          <input type="radio" name="allowstatus" value="1" <?php if ($allowstatus==1) echo 'checked';?>>
                        是
                        <input type="radio" name="allowstatus" value="0" <?php if ($allowstatus==0) echo 'checked';?>>
                        否
                        </label></td>
                      </tr>
                      <tr bgcolor="#FFFFFF"> 
                        <td colspan="2" align="center"><input type="hidden" name="truesubmit" id="truesubmit" value="1"> <input type="submit" value="提交" name="b1" > 
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
