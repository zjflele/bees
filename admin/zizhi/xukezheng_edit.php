<?php
	include("../../include/include.php");
	checklogin();	
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
		$data['jydw'] = trim($_POST['jydw']);
		$data['daibiaoren'] = trim($_POST['daibiaoren']);
		$data['address'] = trim($_POST['address']);
		$data['telphone'] = trim($_POST['telphone']);
		$data['mobile'] = trim($_POST['mobile']);
		$data['xukezheng'] = trim($_POST['xukezheng']);
		$data['pinzhong'] = trim($_POST['pinzhong']);
		$data['enddate'] = trim($_POST['enddate']);	
		//print_r($market);exit;
		updatetable('chaxun_xukezheng',$data,"id=$id");	
		//add_log(1,'market/edit.php','编辑市场行情->'.trim($_POST['pname']));
		$referer = ($_POST['referer'])?$_POST['referer']:'xukezheng_manage.php';
		alertmessage("修改成功！",1,$referer);		
	}	
	if ($id){		
		$marketinfo = $db->GetRow("select * from ".TABLEPRE."chaxun_xukezheng where id=".$id);
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
          <TD width="13%" colspan="1"><font color="#FFFFFF"><strong>许可证</strong></font>修改</TD>
		  <TD width="87%" colspan="2"></TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top"><br>
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form" method="post"  action="">
                            
							<tr bgcolor="#FFFFFF">
								<td width="14%">生产/经营单位：</td>
								<td width="86%"><input name="jydw" type="text" id="jydw" size="50" value="<?=$marketinfo['jydw']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">法定代表人：</td>
								<td width="86%"><input name="daibiaoren" type="text" id="daibiaoren" size="50" value="<?=$marketinfo['daibiaoren']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">地址：</td>
								<td width="86%"><input name="address" type="text" id="address" size="50" value="<?=$marketinfo['address']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">联系电话：</td>
								<td width="86%"><input name="telphone" type="text" id="telphone" size="50" value="<?=$marketinfo['telphone']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">联系手机：</td>
								<td width="86%"><input name="mobile" type="text" id="mobile" size="50" value="<?=$marketinfo['mobile']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">许可证编号：</td>
								<td width="86%"><input name="xukezheng" type="text" id="xukezheng" size="50" value="<?=$marketinfo['xukezheng']?>"></td>
							</tr>							
							<tr bgcolor="#FFFFFF">
								<td>生产/经营品种：</td>
								<td><input name="pinzhong" type="text" id="pinzhong" size="50" value="<?=$marketinfo['pinzhong']?>"></td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td>有效日期：</td>
								<td><input name="enddate" type="text" id="enddate"
									value="<?=$marketinfo['enddate']?>" size="20"> <font color="#FF0000">*</font>
								</td>
							</tr>
							
							
							<tr bgcolor="#FFFFFF">
								<td colspan="2" align="center">
                                 <input type="hidden" name="referer" value="<?=iconv('utf-8','gbk',$_SERVER['HTTP_REFERER'])?>">
                                <input type="submit" value="提交" name="b1" > 
                                <input type="reset" name="Submit22" value="重写"></td>
							</tr>
							</form>
                  </table>
	   <script>
	   </script>
		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
