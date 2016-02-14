<?php
	include("../../include/include.php");
	checklogin();	
	if (submitcheck('b1'))
	{
		$data['userid'] = $_SESSION["bees_UserId"];
		$data['siteid'] = trim($_SESSION['bees_SiteId']);
		$data['jydw'] = trim($_POST['jydw']);
		$data['daibiaoren'] = trim($_POST['daibiaoren']);
		$data['address'] = trim($_POST['address']);
		$data['telphone'] = trim($_POST['telphone']);
		$data['mobile'] = trim($_POST['mobile']);
		$data['xukezheng'] = trim($_POST['xukezheng']);
		$data['pinzhong'] = trim($_POST['pinzhong']);
		$data['enddate'] = trim($_POST['enddate']);		
		//print_r($data);exit;
		$mid = inserttable('chaxun_xukezheng',$data,1);
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
						<TD><font color="#FFFFFF"><strong>许可证添加</strong></font></TD>
					</TR>
					<TR>
						<TD height="543" bgColor=#f8f9fc valign="top">
						<table width="80%" border="0" align="center" cellpadding="4"
							cellspacing="1" bgcolor="#9999FF">
							<form name="form" method="post" enctype="multipart/form-data"  action="xukezheng_add.php?action=action">
                            
							<tr bgcolor="#FFFFFF">
								<td width="14%">生产/经营单位：</td>
								<td width="86%"><input name="jydw" type="text" id="jydw" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">法定代表人：</td>
								<td width="86%"><input name="daibiaoren" type="text" id="daibiaoren" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">地址：</td>
								<td width="86%"><input name="address" type="text" id="address" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">联系电话：</td>
								<td width="86%"><input name="telphone" type="text" id="telphone" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">联系手机：</td>
								<td width="86%"><input name="mobile" type="text" id="mobile" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">许可证编号：</td>
								<td width="86%"><input name="xukezheng" type="text" id="xukezheng" size="50"></td>
							</tr>							
							<tr bgcolor="#FFFFFF">
								<td>生产/经营品种：</td>
								<td><input name="pinzhong" type="text" id="pinzhong" size="50"></td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td>有效日期：</td>
								<td><input name="enddate" type="text" id="enddate"
									value="<?=date("Y-m-d")?>" size="20"> <font color="#FF0000">*</font>
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
