<?php
	include("../../include/include.php");
	checklogin();	
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
		$data['name'] = trim($_POST['name']);
		$data['sex'] = trim($_POST['sex']);
		$data['cardnum'] = trim($_POST['cardnum']);
		$data['beizhu'] = trim($_POST['beizhu']);
		$data['enddate'] = trim($_POST['enddate']);	
		//print_r($market);exit;
		updatetable('chaxun_jcry',$data,"id=$id");	
		//add_log(1,'market/edit.php','编辑市场行情->'.trim($_POST['pname']));
		$referer = ($_POST['referer'])?$_POST['referer']:'jcry_manage.php';
		alertmessage("修改成功！",1,$referer);		
	}	
	if ($id){		
		$marketinfo = $db->GetRow("select * from ".TABLEPRE."chaxun_jcry where id=".$id);
	}		
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/sdate.js"></script>
	
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
          <TD width="13%" colspan="1"><font color="#FFFFFF"><strong>检查人员</strong></font>修改</TD>
		  <TD width="87%" colspan="2"></TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top"><br>
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form" method="post" action="">						
					  		<tr bgcolor="#FFFFFF">
								<td width="14%">姓名：</td>
								<td width="86%"><input name="name" type="text" id="name" size="50" value="<?=$marketinfo['name']?>"> <font color="#FF0000">*</font></td>
							</tr>
							 <tr bgcolor="#FFFFFF">
                        		<td>姓别：</td>
                        		<td>
                                <select name="sex">
                                	<option value="男">男</option>
                                    <option value="女">女</option>
                                </select>
                                </td>
					  		</tr>
							<tr bgcolor="#FFFFFF">
								<td>许可证号码：</td>
								<td><input name="cardnum" type="text" id="cardnum" size="50" value="<?=$marketinfo['cardnum']?>"></td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td>有效日期：</td>
								<td><input name="enddate" type="text" id="enddate"
									value="<?=$marketinfo['enddate']?>" size="20"> <font color="#FF0000">*</font>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td>备注：</td>
								<td><textarea name="beizhu" cols="60" rows="8" id="beizhu"><?=$marketinfo['beizhu']?></textarea>
								</td>
							</tr>
					  
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center">
                        <input type="hidden" name="referer" value="<?=iconv('utf-8','gbk',$_SERVER['HTTP_REFERER'])?>">
                        <input type="submit" value="提交" name="b1">
                            <input type="reset" name="Submit22" value="重写">                        </td>
                      </tr>
                    </form>
                  </table>
	   <script>
	   	$("#sex").val(<?=$marketinfo['sex']?>);
	   </script>
		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
