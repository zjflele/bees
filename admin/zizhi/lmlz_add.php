<?php
	include("../../include/include.php");
	checklogin();	
	if (submitcheck('b1'))
	{
		$data['userid'] = $_SESSION["bees_UserId"];
		$data['siteid'] = trim($_SESSION['bees_SiteId']);
		$data['title'] = trim($_POST['title']);
		$data['shuzhong'] = trim($_POST['shuzhong']);
		$data['xueming'] = trim($_POST['xueming']);
		$data['bianhao'] = trim($_POST['bianhao']);
		$data['leixing'] = trim($_POST['leixing']);
		$data['xuanyu_date'] = trim($_POST['xuanyu_date']);
		$data['shending_date'] = trim($_POST['shending_date']);
		$data['yuanchandi'] = trim($_POST['yuanchandi']);
		$data['zhongzhifanwei'] = trim($_POST['zhongzhifanwei']);
		$data['texing'] = trim($_POST['texing']);		
		//print_r($data);exit;
		$mid = inserttable('chaxun_lmlz',$data,1);
		if ($mid){
			alertmessage("��ӳɹ���",3);
		}else{
			alertmessage("���ʧ�ܣ�",3);
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
						<TD><font color="#FFFFFF"><strong>��ľ�������</strong></font></TD>
					</TR>
					<TR>
						<TD height="543" bgColor=#f8f9fc valign="top">
						<table width="80%" border="0" align="center" cellpadding="4"
							cellspacing="1" bgcolor="#9999FF">
							<form name="form" method="post" enctype="multipart/form-data"  action="lmlz_add.php?action=action">
                            
							<tr bgcolor="#FFFFFF">
								<td width="14%">�������ƣ�</td>
								<td width="86%"><input name="title" type="text" id="title" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">���֣�</td>
								<td width="86%"><input name="shuzhong" type="text" id="shuzhong" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">ѧ����</td>
								<td width="86%"><input name="xueming" type="text" id="xueming" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">���ֱ�ţ�</td>
								<td width="86%"><input name="bianhao" type="text" id="bianhao" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">�������ͣ�</td>
								<td width="86%">
                                <select name="leixing">
                                	<option value="����ϵ">����ϵ</option>
                                    <option value="����">����</option>
                                </select></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">ѡ��ʱ�䣺</td>
								<td width="86%"><input name="xuanyu_date" type="text" id="xuanyu_date" size="50"></td>
							</tr>	
                            <tr bgcolor="#FFFFFF">
								<td width="14%">ԭ���ص㣺</td>
								<td width="86%"><input name="yuanchandi" type="text" id="yuanchandi" size="50"></td>
							</tr>						
							
                            <tr bgcolor="#FFFFFF">
								<td>������ֲ��Χ��</td>
								<td><input name="zhongzhifanwei" type="text" id="zhongzhifanwei" size="50"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td>Ʒ�����ԣ�</td>
								<td><input name="texing" type="text" id="texing" size="50"></td>
							</tr>
                            
							<tr bgcolor="#FFFFFF">
								<td>�����ڣ�</td>
								<td><input name="shending_date" type="text" id="shending_date"
									value="<?=date("Y-m-d")?>" size="20"> <font color="#FF0000">*</font>
								</td>
							</tr>
							
							
							<tr bgcolor="#FFFFFF">
								<td colspan="2" align="center"><input type="submit" value="�ύ" name="b1" > <input type="reset"
									name="Submit22" value="��д"></td>
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
