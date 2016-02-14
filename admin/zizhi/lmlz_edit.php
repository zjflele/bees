<?php
	include("../../include/include.php");
	checklogin();	
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
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
		//print_r($market);exit;
		updatetable('chaxun_lmlz',$data,"id=$id");	
		//add_log(1,'market/edit.php','编辑市场行情->'.trim($_POST['pname']));
		$referer = ($_POST['referer'])?$_POST['referer']:'lmlz_manage.php';
		alertmessage("修改成功！",1,$referer);		
	}	
	if ($id){		
		$dataInfo = $db->GetRow("select * from ".TABLEPRE."chaxun_lmlz where id=".$id);
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
								<td width="14%">良种名称：</td>
								<td width="86%"><input name="title" type="text" id="title" size="50" value="<?=$dataInfo['title']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">树种：</td>
								<td width="86%"><input name="shuzhong" type="text" id="shuzhong" size="50" value="<?=$dataInfo['shuzhong']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">学名：</td>
								<td width="86%"><input name="xueming" type="text" id="xueming" size="50" value="<?=$dataInfo['xueming']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">良种编号：</td>
								<td width="86%"><input name="bianhao" type="text" id="bianhao" size="50" value="<?=$dataInfo['bianhao']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">良种类型：</td>
								<td width="86%">
                                <select name="leixing">
                                	<option value="无性系">无性系</option>
                                    <option value="引种">引种</option>
                                </select></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td width="14%">选育时间：</td>
								<td width="86%"><input name="xuanyu_date" type="text" id="xuanyu_date" size="50" value="<?=$dataInfo['xuanyu_date']?>"></td>
							</tr>							
							<tr bgcolor="#FFFFFF">
								<td width="14%">原产地点：</td>
								<td width="86%"><input name="yuanchandi" type="text" id="yuanchandi" size="50" value="<?=$dataInfo['yuanchandi']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td>适宜种植范围：</td>
								<td><input name="zhongzhifanwei" type="text" id="zhongzhifanwei" size="50" value="<?=$dataInfo['zhongzhifanwei']?>"></td>
							</tr>
                            <tr bgcolor="#FFFFFF">
								<td>品种特性：</td>
								<td><input name="texing" type="text" id="texing" size="50" value="<?=$dataInfo['texing']?>"></td>
							</tr>
                            
							<tr bgcolor="#FFFFFF">
								<td>审定日期：</td>
								<td><input name="shending_date" type="text" id="shending_date"
									value="<?=$dataInfo['shending_date']?>" size="20"> <font color="#FF0000">*</font>
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
