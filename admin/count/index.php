<?php
	include("../../include/include.php");	
	if (trim($_POST['startCount'])){
		$s_date = trim($_POST['s_date']);
		$e_date = trim($_POST['e_date']);
		$uname = trim($_POST['username']);
		$arrUser = explode(",",substr($uname,0,strlen($uname)-1));		
		if ($arrUser){
			foreach ($arrUser as $key => $u){
			  if ($u==''){
			  	unset($arrUser[$key]);
			  }else{
				$userData[$u]['articleNum'] = GetValueFromTable("count(*)","article","username='$u' AND date>='$s_date' AND date<='$e_date'");
				$userData[$u]['videoNum'] = GetValueFromTable("count(*)","video","username='$u' AND addtime>='$s_date' AND addtime<='$e_date'");
				$userData[$u]['totalnum'] = $userData[$u]['articleNum']+$userData[$u]['videoNum'];
			 }
			}
		}
	}
	$sqlstr_user="select username,zname from ".TABLEPRE."users";
	$user_query = @mysql_query($sqlstr_user);
	while($row = @mysql_fetch_assoc($user_query)){
		$userList[$row['username']] = $row['zname'];
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<link rel="stylesheet" href="/js/nyroModal/nyroModal.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/nyroModal/jquery.min.js"></script>
<script type="text/javascript" src="/js/nyroModal/jquery.nyroModal.pack.js"></script>
<SCRIPT language="javascript">
	function addOption(source,assigned,hidden) {
	var  resobj = document.getElementById(source);
	var  assobj = document.getElementById(assigned);
	var  hpercobj = document.getElementById(hidden);
	var fl = resobj.length -1;
	var au = assobj.length -1;
	var users = "x";
	//build array of assiged users
	for (au; au > -1; au--) {
		users = users + "," + assobj.options[au].value + ","
	}
	
	//Pull selected resources and add them to list
	for (fl; fl > -1; fl--) {
		if (resobj.options[fl].selected && users.indexOf("," + resobj.options[fl].value + ",") == -1) {
			t = assobj.length;
			opt = new Option(resobj.options[fl].text, resobj.options[fl].value);
			hpercobj.value += resobj.options[fl].value+",";
			assobj.options[t] = opt;
			assobj.value=resobj.options[fl].value;	
			assobj.focus();		
		}
	}
}

function removeOption(source,assigned,hidden) {
	var  resobj = document.getElementById(source);
	var  assobj = document.getElementById(assigned);
	var  hpercobj = document.getElementById(hidden);
	fl = assobj.length -1;
	
	for (fl; fl > -1; fl--) {
		if (assobj.options[fl].selected) {			
			//remove from hperc_assign
			var selValue = assobj.options[fl].value;			
			var re = ".*(,"+selValue+",).*";
			var hiddenValue = hpercobj.value;
			
			if (hiddenValue) {			
				var b = hiddenValue.match(re);
				if (b[1]) {					 
					hiddenValue = hiddenValue.replace(b[1], ',');
				}
				hpercobj.value = hiddenValue;
				
				assobj.options[fl] = null;
			}
//alert(form.hperc_assign.value);
		}
	}
}
</script>
<script type="text/javascript" src="../../js/sdate.js"></script>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY><form name="form1" method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=action">
        <TR class=header align=left>
          <TD colspan="2">数据汇总统计</TD>
		  <TD width="91%" >&nbsp;</TD>
          </TR> </form>
        <TR>
          <TD height="543" colspan="3" valign="top" bgColor=#f8f9fc><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr> 
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="center"><br>
                  <br><table cellspacing="0" cellpadding="0" border="0" width="71%" align="center" style="word-break:break-all;" class="tableout">
<tr><td bgcolor="#DDE3EC">
<form name="form1" method="post" action="index.php">
  <div align="center"><strong>数据汇总统计</strong>　  </div>
<table border="0" cellspacing="1" cellpadding="4" width="100%">
<tr class="header">
  <td width="120">用户名：</td>
  <td valign="middle" align="left"> 
  <input name="username"  id="username" type="hidden" value=","/>
  <select name="username_source" id="username_source" style="width:150px" size="5" class="text" multiple="multiple" ondblclick="addOption('username_source','username_assigned','username')">
    <?php 
	   if ($userList){
			foreach ($userList as $key => $value){
				echo "<option value='".$key."'>".$value."</option>";	
			}
		}		
		?>
  </select>
  <input name="button22" type="button" class="button" onClick="removeOption('username_source','username_assigned','username')" value="&lt;" />
   <input name="button3" type="button" class="button" onClick="addOption('username_source','username_assigned','username')" value="&gt;" />
   <select name="username_assigned" id="username_assigned" style="width:150px" size="5" class="text" multiple="multiple" ondblclick="removeOption('username_source','username_assigned','username')">
   <?php    		
		if ($arrUser){
			foreach ($arrUser as $u){
				echo "<option value='".$u."'>".$userList[$u]."</option>";	
			}
		}
   ?>
    </select>
   </td>
</tr>
<tr class="header">
  <td>选择起始日期：</td>
  <td align="left"> <input type="text" name="s_date" id="s_date" onclick="SelectDate(this,'yyyy-MM-dd')" readonly="true"  style="width:100px;" /></td>
</tr>
<tr class="header">
  <td>选择结束日期：</td>
  <td align="left"> <input type="text" name="e_date" id="e_date" onclick="SelectDate(this,'yyyy-MM-dd')" readonly="true"  style="width:100px;" /></td>
</tr>
<tr class="header">
  <td colspan=2 align="center"><input type=submit name="startCount" value="开 始 统 计"></td>
</tr>
</table>
<script language="javascript">
	<?php if ($uname) { ?>
	document.getElementById("username").value='<?=$uname?>';
	<?php }?>
	document.getElementById("s_date").value='<?=$s_date?>';
	document.getElementById("e_date").value='<?=$e_date?>';	
</script>
<div align="right">　  </div>
</form></td></tr></table> 
<?
	if (trim($_POST['startCount'])){
?> 
                  <p><strong><font size="3">查询结果</font></strong></p>
<table cellspacing="0" cellpadding="0" border="0" width="95%" align="center" style="word-break:break-all;" class="tableout">
<tr><td bgcolor="#DDE3EC">
<table border="0" cellspacing="1" cellpadding="4" width="100%" align="center">
<tr class="header">
<td width="15%">用户名</td>
  <td width="20%" align="center">新闻文章</td>
  <td width="15%" align="center">视频</td>	
  <td width="10%" align="center">合计</td>
</tr>
<?php if ($userData){
			foreach ($userData as $u => $arr){
?>
	<tr bgcolor="#F8F9FC">
	  <td><?=$userList[$u]?></td>
	  <td align="right"><?=$arr['articleNum'];if ($arr['articleNum']) {?>[<a href="../news/news_manage.php?username=<?=$u?>&s_date=<?=$s_date?>&e_date=<?=$e_date?>">详细数据</a>][<a href="./sort_list.php?username=<?=$u?>&s_date=<?=$s_date?>&e_date=<?=$e_date?>" target="_blank" class="nyroModal">分类查询</a>]<?php }?></td>
	  <td align="right"><?=$arr['videoNum'];if ($arr['videoNum']) {?>[<a href="../video/manage.php?username=<?=$u?>&s_date=<?=$s_date?>&e_date=<?=$e_date?>">详细数据</a>]<?php }?></td>
	  <td align="right"><?=$arr['totalnum']?></td>
	</tr>
<?
	}}
?>	
</table></td>
	</tr>
</table>
<?
	}
?>
</td>
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
