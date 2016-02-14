<?php
	include("../../include/include.php");
	checklogin();	
	if (submitcheck('b1'))
	{
		$data['userid'] = $_SESSION["bees_UserId"];
		$data['siteid'] = trim($_SESSION['bees_SiteId']);
		$data['name'] = trim($_POST['name']);
		$data['sex'] = trim($_POST['sex']);
		$data['cardnum'] = trim($_POST['cardnum']);
		$data['beizhu'] = trim($_POST['beizhu']);
		$data['enddate'] = trim($_POST['enddate']);		
		//print_r($data);exit;
		$mid = inserttable('chaxun_jcry',$data,1);
		if ($mid){
			alertmessage("添加成功！",3);
		}else{
			alertmessage("添加失败！",3);
		}
	}			
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>

</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center
	bgColor=#ffffff border=0>
	<TBODY>
		<TR>
			<TD><BR>
			<BR>
			<TABLE class=tableout cellSpacing=1 cellPadding=6 width="95%"
				align=center border=0>
				<TBODY>
					<TR class=header align=left>
						<TD><font color="#FFFFFF"><strong>检查人员添加</strong></font></TD>
					</TR>
					<TR>
						<TD height="543" bgColor=#f8f9fc valign="top">
						<table width="80%" border="0" align="center" cellpadding="4"
							cellspacing="1" bgcolor="#9999FF">
							<form name="form" method="post" enctype="multipart/form-data"  action="jcry_add.php?action=action">
                            
							<tr bgcolor="#FFFFFF">
								<td width="14%">姓名：</td>
								<td width="86%"><input name="name" type="text" id="name" size="50"> <font color="#FF0000">*</font></td>
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
								<td><input name="cardnum" type="text" id="cardnum" size="50"></td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td>有效日期：</td>
								<td><input name="enddate" type="text" id="enddate"
									value="<?=date("Y-m-d")?>" size="20"> <font color="#FF0000">*</font>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td>备注：</td>
								<td><textarea name="beizhu" cols="60" rows="8" id="beizhu"></textarea>
								</td>
							</tr>
							
							<tr bgcolor="#FFFFFF">
								<td colspan="2" align="center"><input type="submit" value="提交" name="b1" > <input type="reset"
									name="Submit22" value="重写"></td>
							</tr>
							</form>
						</table>

						</TD>
					</tr>
				</TBODY>
			</TABLE>
		
		
		<TR bgColor=#ffffff>
			<TD align=middle><BR>
			<BR>
			<BR>
			</TD>
		</TR>
	</TBODY>
</TABLE>
</body>
</html>
