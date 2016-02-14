<?php
	include("../../include/include.php");
	include("../../include/market_type.php");
	checklogin();	
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
		$market['pname'] = trim($_POST['pname']);
		$market['typeid'] = intval($_POST['typeid']);
		$market['guige'] = trim($_POST['guige']);
		$market['price'] = trim($_POST['price']);
		$market['btime'] = trim($_POST['btime']);
		$market['dtime'] = trim($_POST['dtime']);
		$market['paddress'] = trim($_POST['paddress']);
		$market['pfrom'] = trim($_POST['pfrom']);
		$market['description'] = trim($_POST['description']);
		$market['uname'] = trim($_POST['uname']);
		$market['phone'] = trim($_POST['phone']);
		$market['email'] = trim($_POST['email']);
		$market['other'] = trim($_POST['other']);
		//print_r($market);exit;
		updatetable('market',$market,"id=$id");	
		//add_log(1,'market/edit.php','编辑市场行情->'.trim($_POST['pname']));
		$referer = ($_POST['referer'])?$_POST['referer']:'manage.php';
		alertmessage("修改成功！",1,$referer);		
	}	
	if ($id){		
		$marketinfo = $db->GetRow("select * from ".TABLEPRE."market where id=".$id);
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
          <TD width="13%" colspan="1">市场行情修改</TD>
		  <TD width="87%" colspan="2"></TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top"><br>
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form" method="post" action="">						
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">商品名称：</td>
                        <td width="81%"><input name="pname" type="text" id="title" size="40" value="<?=$marketinfo['pname']?>"></td>
					  </tr>					  	
					 <tr bgcolor="#FFFFFF">
                        <td width="19%">商品类型：</td>
                        <td width="81%">
						<SELECT id=typeid title=商品类别 style="WIDTH: 100px" name=typeid>
						<OPTION value="" selected select="select">请选择</OPTION> 
						<?php
							foreach ($market_type as $k => $v){
								echo "<OPTION value=$k>$v</OPTION>";
							}
						?>
						</SELECT>						</td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">商品规格：</td>
                        <td width="81%"><input name="guige" type="text" id="guige" size="30" value="<?=$marketinfo['guige']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">商品报价：</td>
                        <td width="81%"><input name="price" type="text" id="price" size="30" value="<?=$marketinfo['price']?>"></td>
					  </tr><tr bgcolor="#FFFFFF">
                        <td width="19%">报价时间：</td>
                        <td width="81%"><input name="btime" type="text" id="btime" onClick="SelectDate(this,'yyyy-MM-dd')" readonly="true" style="width:100px;" value="<?=$marketinfo['btime']?>"></td>
					  </tr><tr bgcolor="#FFFFFF">
                        <td width="19%">有效时间：</td>
                        <td width="81%"><input name="dtime" type="text" id="dtime" onClick="SelectDate(this,'yyyy-MM-dd')" readonly="true" style="width:100px;" value="<?=$marketinfo['dtime']?>"></td>
					  </tr><tr bgcolor="#FFFFFF">
                        <td width="19%">产品产地：</td>
                        <td width="81%"><input name="paddress" type="text" id="paddress" size="80" value="<?=$marketinfo['paddress']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">信息来源：</td>
                        <td width="81%"><input name="pfrom" type="text" id="pfrom" size="30" value="<?=$marketinfo['pfrom']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%" valign="top">简要说明：</td>
                        <td width="81%"><textarea name="description" id="description" cols="100" rows="8"><?=$marketinfo['description']?></textarea>						</td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">联系人：</td>
                        <td width="81%"><input name="uname" type="text" id="uname" size="30" value="<?=$marketinfo['uname']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">联系电话：</td>
                        <td width="81%"><input name="phone" type="text" id="phone" size="30" value="<?=$marketinfo['phone']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">Email：</td>
                        <td width="81%"><input name="email" type="text" id="email" size="30" value="<?=$marketinfo['email']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">其他联系方式：</td>
                        <td width="81%"><input name="other" type="text" id="other" size="40" value="<?=$marketinfo['other']?>"></td>
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
	   	$("#typeid").val(<?=$marketinfo['typeid']?>);
	   </script>
		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
