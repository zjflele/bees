<?php
	include("../../include/include.php");
	checklogin();
if (submitcheck('username'))
{

//-------------------判断用户名是否已经注册-------------------------
  $sqlstr="select username from ".TABLEPRE."users where username ='".$username."'";
  $myrs=mysql_query($sqlstr,$myconn);
  $recnum=mysql_num_rows($myrs);
  if ($recnum!=0)
  {
	alertmessage("登录名[ $username]已经被使用，请使用别的名称！",2);
    exit();
  }
//---------------------判断用户是否已经注册------------------------
  $sqlstr="select zname from ".TABLEPRE."users where zname ='".$zname."'";
  $myrs=mysql_query($sqlstr,$myconn);
  $recnum=mysql_num_rows($myrs);
  if ($recnum!=0)
  {
  	alertmessage("已经注册过同名用户，不要重复注册！",2);
    exit();
  }  		
		$group_count=count($group);
		for ($n=0;$n<$group_count;$n++)
		{
		  if ($n==$group_count-1) 
		  {$group_n=$group[$n];} else { $group_n=$group[$n].","; }
		  $my_sort.=$group_n;
		}
		$obj=new EasyDB(users);
		$obj->AcceptType="USER";	
		$obj->User["username"]  = $obj->Post["username"];
		$obj->User["password"]  = md5($obj->Post["userpwd"]);		
		$obj->User["zname"]	= $obj->Post["zname"];	
		$obj->User["groupid"] = $obj->Post["select_group"];
		$obj->User["my_sort"]	= $my_sort;		
		$obj->IDVars="username";		
		if($obj->Having()>0)
		{
			$js = new Javascript();
			$js->Begin();
			$js->Alert("您要添加的用户名已经存在！");
			$js->GoToUrl($_SERVER['PHP_SELF']);
			$js->End();
			exit();
		}
		else
		{
			if($obj->Insert())
			{
			$js=new Javascript();
			$js->Begin();
			$js->Alert("添加用户成功！");
			$js->GoToUrl($_SERVER['PHP_SELF']);
			$js->End();
			exit();
		     }
		    else
		    {
			alertmessage("添加失败！",2);
			exit();
		     }
		}
 
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<SCRIPT language="JavaScript1.2">
function havenoChar(theelement)
{//含有非法字符 返回 false
   text="abcdefghijklmnopqrstuvwxyz1234567890._-";
   for(i=0;i<=theelement.length-1;i++)
   {
      char1=theelement.charAt(i);
      index=text.indexOf(char1);
      if(index==-1)
      {
        return false; 
      }
   }
   return true;
}
</script>
<script language="vbscript">
function checkform()
	tag=0
	if form.username.value=""  then
		msgbox("必须填写用户名")
		form.username.focus 
		tag=1
	elseif havenoChar(form.username.value)<>true then
		msgbox("您的用户名有错误，请按规定填写！")
		form.username.focus 
		tag=1
	elseif len(form.username.value)<4 or len(form.username.value)>20 then
	    msgbox("用户名要求在4位到20位之间")
	    form.username.focus  
	    tag=1
	elseif form.userpwd.value=""  then
		msgbox("请填写密码")
		form.userpwd.focus 
		tag=1
	elseif havenoChar(form.userpwd.value)<>true then
		msgbox("您的密码有错误，请按规定填写！")
		form.userpwd.focus
		tag=1
	elseif form.userpwd.value<>form.userpwds.value then
	    msgbox("两次输入的密码不一致")
	    form.userpwd.focus 
		tag=1
	elseif len(form.userpwd.value)<4 or len(form.userpwd.value)>20 then
	    msgbox("密码要求在4位到20位之间")
	    form.userpwd.focus 
	    tag=1
	end if
	if tag=0 then form.submit()
End Function
//-->
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
          <TD colspan="3">用户添加</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <form name="form" method="post" action="user_add.php?action=action"  onSubmit="return onSubmit()">
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B8E094">
   
    <tr> 
      <td width="100" bgcolor="#FFFFFF">用户名</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="username" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"><div id="divuserid" /> </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">密码</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="password" name="userpwd" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px">        
         [注：4-20个字符（a-z，A-Z，0-9，._-）]</td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">重复密码</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="password" name="userpwds" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"><div id="divpassword" /> </td>
    </tr>
	<tr> 
      <td  bgcolor="#FFFFFF">用户名称</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="zname" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"></td>
    </tr>
	 <tr> 
      <td height="30" bgcolor="#FFFFFF">所在组</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp;
        <select name="select_group">
          <option value=0 selected>选择组</option>
<?php
$sql="select id,groupname from ".TABLEPRE."usergroup where id <>''";
$myrs=mysql_query($sql,$myconn);
while($rec=mysql_fetch_array($myrs)){
	echo "<option value=$rec[id]>$rec[groupname]</option>\n";
	}
?>
        </select></td>
    </tr>
	 <tr bgcolor="#FFFFFF">
                        <td valign="top">拥有版块：</td>
                        <td><? 
						$sql="select * from ".TABLEPRE."sort where id<>'' and hight=1";
						$myrs=mysql_query($sql,$myconn);
						while($rec=mysql_fetch_assoc($myrs))
						{
							echo "<input name='group[]' type='checkbox' value='$rec[id]'>$rec[name]"."　　<BR />";						
							$sub_myrs=mysql_query("select * from ".TABLEPRE."sort where parentid=$rec[id] and hight=2",$myconn);
							while($sub_rec=mysql_fetch_assoc($sub_myrs))
							{
								echo "<img src='/images/corner-dots.gif'><input name='group[]' type='checkbox' value='$sub_rec[id]'>$sub_rec[name]"."　　<BR />";	
							}
						}
						?></td>
                      </tr>
    <tr> 
      <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"> 
        <input type="button" name="send_user" value="提交" onClick="checkform();"></td>
    </tr>
  </table>
</form>
		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
