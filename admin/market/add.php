<?php
	include("../../include/include.php");
	include("../../include/market_type.php");
	checklogin();	
	if (submitcheck('b1'))
	{
		$market['username'] = $_SESSION["bees_UserName"];
		$market['uid'] = $_SESSION["bees_UserId"];
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
		$market['siteid'] = trim($_SESSION['bees_SiteId']);
		$market['other'] = trim($_POST['other']);
		$market['addtime'] = date('Y-m-d H:i:s');
		//print_r($market);exit;
		$mid = inserttable('market',$market,1);
		if ($mid){
			//add_log(1,'market/add.php','����г�����->'.trim($_POST['pname']));
			alertmessage("��ӳɹ���",3);
		}else{
			alertmessage("���ʧ�ܣ�",3);
		}
	}			
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/sdate.js"></script>
<script language="javascript">
	function winalert()
	{
		
		if(document.form.year.value=='')
		{
			alert('��ѡ�����');
			document.form.year.focus();
			return false;
		}
		document.form.submit();
	}
</script>	
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
          <TD width="13%" colspan="1">�г����鷢��</TD>
		  <TD width="87%" colspan="2"></TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top"><br>
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form" method="post" action="">						
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">��Ʒ���ƣ�</td>
                        <td width="81%"><input name="pname" type="text" id="title" size="40" value="<?=$market['pname']?>"></td>
					  </tr>					  	
					 <tr bgcolor="#FFFFFF">
                        <td width="19%">��Ʒ���ͣ�</td>
                        <td width="81%">
						<SELECT id=typeid title=��Ʒ��� style="WIDTH: 100px" name=typeid>
						<OPTION value="" selected select="select">��ѡ��</OPTION> 
						<?php
							foreach ($market_type as $k => $v){
								echo "<OPTION value=$k>$v</OPTION>";
							}
						?>
						</SELECT>						</td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">��Ʒ���</td>
                        <td width="81%"><input name="guige" type="text" id="guige" size="30" value="<?=$market['guige']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">��Ʒ���ۣ�</td>
                        <td width="81%"><input name="price" type="text" id="price" size="30" value="<?=$market['price']?>"></td>
					  </tr><tr bgcolor="#FFFFFF">
                        <td width="19%">����ʱ�䣺</td>
                        <td width="81%"><input name="btime" type="text" id="btime" onClick="SelectDate(this,'yyyy-MM-dd')" readonly="true" style="width:100px;" value="<?=$market['btime']?>"></td>
					  </tr><tr bgcolor="#FFFFFF">
                        <td width="19%">��Чʱ�䣺</td>
                        <td width="81%"><input name="dtime" type="text" id="dtime" onClick="SelectDate(this,'yyyy-MM-dd')" readonly="true" style="width:100px;" value="<?=$market['dtime']?>"></td>
					  </tr><tr bgcolor="#FFFFFF">
                        <td width="19%">��Ʒ���أ�</td>
                        <td width="81%"><input name="paddress" type="text" id="paddress" size="80" value="<?=$market['paddress']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">��Ϣ��Դ��</td>
                        <td width="81%"><input name="pfrom" type="text" id="pfrom" size="30" value="<?=$market['pfrom']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%" valign="top">��Ҫ˵����</td>
                        <td width="81%"><textarea name="description" id="description" cols="100" rows="8"><?=$market['description']?></textarea>						</td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">��ϵ�ˣ�</td>
                        <td width="81%"><input name="uname" type="text" id="uname" size="30" value="<?=$market['uname']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">��ϵ�绰��</td>
                        <td width="81%"><input name="phone" type="text" id="phone" size="30" value="<?=$market['phone']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">Email��</td>
                        <td width="81%"><input name="email" type="text" id="email" size="30" value="<?=$market['email']?>"></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="19%">������ϵ��ʽ��</td>
                        <td width="81%"><input name="other" type="text" id="other" size="40" value="<?=$market['other']?>"></td>
					  </tr>
					  
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="submit" value="�ύ" name="b1">
                            <input type="reset" name="Submit22" value="��д">                        </td>
                      </tr>
                    </form>
                  </table>
	  <script>
	   	$("#typeid").val(<?=$market['typeid']?>);
	   </script>
		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
