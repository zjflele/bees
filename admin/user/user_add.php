<?php
	include("../../include/include.php");
	checklogin();
if (submitcheck('username'))
{

//-------------------�ж��û����Ƿ��Ѿ�ע��-------------------------
  $sqlstr="select username from ".TABLEPRE."users where username ='".$username."'";
  $myrs=mysql_query($sqlstr,$myconn);
  $recnum=mysql_num_rows($myrs);
  if ($recnum!=0)
  {
	alertmessage("��¼��[ $username]�Ѿ���ʹ�ã���ʹ�ñ�����ƣ�",2);
    exit();
  }
//---------------------�ж��û��Ƿ��Ѿ�ע��------------------------
  $sqlstr="select zname from ".TABLEPRE."users where zname ='".$zname."'";
  $myrs=mysql_query($sqlstr,$myconn);
  $recnum=mysql_num_rows($myrs);
  if ($recnum!=0)
  {
  	alertmessage("�Ѿ�ע���ͬ���û�����Ҫ�ظ�ע�ᣡ",2);
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
			$js->Alert("��Ҫ��ӵ��û����Ѿ����ڣ�");
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
			$js->Alert("����û��ɹ���");
			$js->GoToUrl($_SERVER['PHP_SELF']);
			$js->End();
			exit();
		     }
		    else
		    {
			alertmessage("���ʧ�ܣ�",2);
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
{//���зǷ��ַ� ���� false
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
		msgbox("������д�û���")
		form.username.focus 
		tag=1
	elseif havenoChar(form.username.value)<>true then
		msgbox("�����û����д����밴�涨��д��")
		form.username.focus 
		tag=1
	elseif len(form.username.value)<4 or len(form.username.value)>20 then
	    msgbox("�û���Ҫ����4λ��20λ֮��")
	    form.username.focus  
	    tag=1
	elseif form.userpwd.value=""  then
		msgbox("����д����")
		form.userpwd.focus 
		tag=1
	elseif havenoChar(form.userpwd.value)<>true then
		msgbox("���������д����밴�涨��д��")
		form.userpwd.focus
		tag=1
	elseif form.userpwd.value<>form.userpwds.value then
	    msgbox("������������벻һ��")
	    form.userpwd.focus 
		tag=1
	elseif len(form.userpwd.value)<4 or len(form.userpwd.value)>20 then
	    msgbox("����Ҫ����4λ��20λ֮��")
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
          <TD colspan="3">�û����</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <form name="form" method="post" action="user_add.php?action=action"  onSubmit="return onSubmit()">
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B8E094">
   
    <tr> 
      <td width="100" bgcolor="#FFFFFF">�û���</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="username" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"><div id="divuserid" /> </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">����</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="password" name="userpwd" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px">        
         [ע��4-20���ַ���a-z��A-Z��0-9��._-��]</td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">�ظ�����</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="password" name="userpwds" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"><div id="divpassword" /> </td>
    </tr>
	<tr> 
      <td  bgcolor="#FFFFFF">�û�����</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="zname" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"></td>
    </tr>
	 <tr> 
      <td height="30" bgcolor="#FFFFFF">������</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp;
        <select name="select_group">
          <option value=0 selected>ѡ����</option>
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
                        <td valign="top">ӵ�а�飺</td>
                        <td><? 
						$sql="select * from ".TABLEPRE."sort where id<>'' and hight=1";
						$myrs=mysql_query($sql,$myconn);
						while($rec=mysql_fetch_assoc($myrs))
						{
							echo "<input name='group[]' type='checkbox' value='$rec[id]'>$rec[name]"."����<BR />";						
							$sub_myrs=mysql_query("select * from ".TABLEPRE."sort where parentid=$rec[id] and hight=2",$myconn);
							while($sub_rec=mysql_fetch_assoc($sub_myrs))
							{
								echo "<img src='/images/corner-dots.gif'><input name='group[]' type='checkbox' value='$sub_rec[id]'>$sub_rec[name]"."����<BR />";	
							}
						}
						?></td>
                      </tr>
    <tr> 
      <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"> 
        <input type="button" name="send_user" value="�ύ" onClick="checkform();"></td>
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
