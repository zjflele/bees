<?php
	include("../../include/include.php");
	checklogin();
	$id = intval($_GET['id']);
	
	$sqlstr="SELECT * FROM ".TABLEPRE."user_register WHERE id=$id";
	$arrData = getrow($sqlstr);
	//print_r($arrData);

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY>
        <TR class=header align=left>
          <TD colspan="2">会员审核管理</TD>
		  <TD width="91%" > 	   　
		   </TD>
          </TR>
        <TR>
          <TD height="543" colspan="3" valign="top" bgColor=#f8f9fc>

		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr> 
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><table cellspacing="0" cellpadding="0" border="0" width="95%" align="center" style="word-break:break-all;" class="tableout">
<tr><td bgcolor="#DDE3EC">

<table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
					  
					  <tr bgcolor="#FFFFFF">
                        <td width="14%">登 录 名：</td>
                        <td width="86%"><?=$arrData['username']?></td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="14%">协会名称：</td>
                        <td width="86%"><?=$arrData['zname']?></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td width="14%">真实姓名：</td>
                        <td width="86%"><?=$arrData['realname']?></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td width="14%">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</td>
                        <td width="86%"><?=$arrData['sex']?></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td width="14%">许可证号：</td>
                        <td width="86%"><?=$arrData['xukezheng_num']?></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td width="14%">证件截图：</td>
                        <td width="86%"><img src="../../../upload/images/<?=$arrData['xukezheng_pic']?>" width="400" height="400"></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td width="14%">联系方式：</td>
                        <td width="86%"><?=$arrData['connect']?></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td width="14%">电子邮箱：</td>
                        <td width="86%"><?=$arrData['email']?></td>
                      </tr>
                                         
					 
                  </table>


</td></tr></table>  </td>
              </tr>
            </table>
				</td>
              </tr>
            </table>
			
		  </TD>
		  </tr>
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
