<?php
	include("../../include/include.php");
	checklogin();
	if (submitcheck('username'))
	{		
	    $group_count=count($group);
		for ($n=0;$n<$group_count;$n++)
		{
		  if ($n==$group_count-1) 
		  {$group_n=$group[$n];} else { $group_n=$group[$n].","; }
		  $my_sort.=$group_n;
		}
		$obj=new EasyDB(users);
		//$obj->Debug=true;
		$obj->AcceptType="USER";	
		$obj->User["username"]  = $obj->Post["username"];
		if ($obj->Post["userpwd"]!='' && $obj->Post["userpwds"]!='')
			$obj->User["password"]  = md5($obj->Post["userpwd"]);		
		$obj->User["zname"]	= $obj->Post["zname"];	
		$obj->User["cityid"] = $obj->Post["cityid"];
		$obj->User["description"] = $obj->Post["description"];
		
		$obj->IDVars="username";
			if($obj->Update())
			{
			$js=new Javascript();
			$js->Begin();
			$js->Alert("�޸ĳɹ���");
			$js->End();
			
		     }
		    else
		    {
			alertmessage("����ʧ�ܣ�",2);			
		     }
		
 
}
?>
<? 
	$id = ($_GET["id"])?intval($_GET["id"]):$_SESSION['bees_UserId'];
	if($id)
	{
		$obj = new EasyDB(users);
		$obj->AcceptType="USER";
		$obj->User["userid"] 		= $id;		
		$obj->IDVars="userid";
		$obj->Select();
		$obj->FetchLine();
		$privacy = unserialize($obj->GetField("privacy"));
	}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script type="text/javascript" src="user_add.js"></script>
<SCRIPT language=JavaScript1.2>
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
	elseif havenoChar(form.userpwd.value)<>true then
		msgbox("���������д����밴�涨��д��")
		form.userpwd.focus
		tag=1
	elseif form.userpwd.value<>form.userpwds.value then
	    msgbox("������������벻һ��")
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
          <TD colspan="3">��վ�������</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <form name="form" method="post" action="sub_site_edit.php?action=action"  onSubmit="return onSubmit()" enctype="multipart/form-data">
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B8E094">
   <tr> 
      <td  bgcolor="#FFFFFF">վ������</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text"  value="<?=$obj->GetField("zname")?>" name="zname" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"></td>
    </tr>
    <tr> 
      <td width="100" bgcolor="#FFFFFF">�û���</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="username" value="<?=$obj->GetField("username")?>" readonly style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"><div id="divuserid" /> </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">����</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="password" name="userpwd" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">�ظ�����</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="password" name="userpwds" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px">
        <span class="PadLeft20">(����Ϊ�������벻��)</span></td>
    </tr>
	
	 <tr> 
      <td height="30" bgcolor="#FFFFFF">��������</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp;
                
        <select name="cityid">
<?php
	foreach ($citys as $k => $city ) {
		$selected = ($obj->GetField('cityid')==$k)?'selected':'';
		echo "<option value=$k $selected>$city</option>\n";
	}
?>
        </select>
        <input type=hidden name="id" value="<?=$id?>"></td>
    </tr>
	
     <tr> 
      <td height="30" bgcolor="#FFFFFF">��վ���</td>
      <td height="30" bgcolor="#FFFFFF"><textarea name="description" cols="120" rows="20"><?php echo $obj->GetField('description');?></textarea></td>
    </tr>  
         
    <tr> 
      <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"> 
        <input type="button" onClick=checkform() name="send_user" value="�ύ"></td>
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
