<?php
	include("../../include/include.php");
	checklogin();
	$id = intval($_GET['id']);
	
	$sqlstr="SELECT * FROM ".TABLEPRE."user_register WHERE id=$id";
	$arrData = getrow($sqlstr);
if (submitcheck('username'))
{
	if (intval($_POST['user_register_id'])){
		$sqlstr="SELECT * FROM ".TABLEPRE."user_register WHERE id=".intval($_POST['user_register_id']);
		$arrRegister = getrow($sqlstr);
	}
	//print_r($arrRegister);exit;
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
		$obj->User["password"]  = ($arrRegister['PASSWORD'])?$arrRegister['PASSWORD']:md5($obj->Post["userpwd"]);		
		$obj->User["zname"]	= $obj->Post["zname"];	
		$obj->User["groupid"] = $obj->Post["select_group"];
		$obj->User["my_sort"]	= $my_sort;		
		$obj->User["cityid"] = $obj->Post["cityid"];
		$obj->User["description"] = $obj->Post["description"];
		$obj->User["istop"] = $obj->Post["istop"];
		$obj->User["stype"] = $obj->Post["stype"];
		$obj->User["slevel"] = $obj->Post["slevel"];
		//�ϴ�ͼƬ
		$max=rand(100000,999999);
		$up_name=date("Ymd").$max.date("His");
		if ($_FILES['logo_image']['type']=="image/pjpeg" or $_FILES['logo_image']['type']=="image/jpeg"  or $_FILES['logo_image']['type']=='image/jpg'  or $_FILES['logo_image']['type']=="image/gif")
			{
			if ($_FILES['logo_image']['type']=="image/pjpeg" or $_FILES['logo_image']['type']=="image/jpeg"  or $_FILES['logo_image']['type']=='image/jpg' )
			{$l_name=".jpg";}
			if ($_FILES['logo_image']['type']=="image/gif")
			{$l_name=".gif";}
				$new_name=$up_name.$l_name;
				// �����ļ���		
				$filename="../../upload/images/".$new_name;
				if (move_uploaded_file($_FILES['logo_image']['tmp_name'],$filename))
				{		
						$xiaoxi="�ϴ�ͼƬ�ɹ���";		
						chmod($filename,0777);
						$obj->User["logo_image"] = $new_name;
				} 
		}
		
		
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
				if ($arrRegister){
					$db->query("UPDATE ".TABLEPRE."user_register SET status=1 WHERE id=$arrRegister[id]"); 	
				}
				$siteid = $obj->getInsertId();
				init_site_info($siteid);
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

function init_site_info($siteid){
	for($i=1;$i<=10;$i++) {
		$index_set['fid'] = $i;
		$index_set['ftype'] = 1;
		$index_set['ftitle'] = '����';
		$index_set['fcontent'] = '';
		$index_set['flink'] = '';
		$index_set['img_left'] = '';
		$index_set['img_right'] = '';
		$index_set['plink'] = '';
		$index_set['sid'] = 0;
		$index_set['rownum'] = 8;
		$index_set['tlength'] = 30;
		$index_set['siteid'] = $siteid;		
		//print_r($index_set);exit;
		inserttable('index_set',$index_set,1);
	}
	return true;
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
	<?php if (!$arrData) {?>
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
	<?php } ?>
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
          <TD colspan="3">��վ���</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <form name="form" method="post" action="site_add.php?action=action"  onSubmit="return onSubmit()" enctype="multipart/form-data">
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B8E094">
   <tr> 
      <td  bgcolor="#FFFFFF">��վ����</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="zname" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px" value="<?=$arrData['zname']?>"></td>
    </tr>
    <tr> 
      <td width="100" bgcolor="#FFFFFF">��¼��</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="username" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px" value="<?=$arrData['username']?>"><div id="divuserid" /> </td>
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
      <td height="30" bgcolor="#FFFFFF">��������</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp;
        <select name="cityid">
		<?php
            foreach ($citys as $k => $city ) {
                echo "<option value=$k>$city</option>\n";
            }
        ?>
        </select>
        </td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">����</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp;
        <select name="stype">
		<?php
            foreach ($siteTypes as $k => $type ) {
                echo "<option value=$k>$type</option>\n";
            }
        ?>
        </select>
        </td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">����</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp;
        <select name="slevel">
		<?php
            foreach ($siteLevels as $k => $level ) {
                echo "<option value=$k>$level</option>\n";
            }
        ?>
        </select>
        </td>
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
      <td height="30" bgcolor="#FFFFFF">��վ���</td>
      <td height="30" bgcolor="#FFFFFF"><textarea name="description" cols="120" rows="20"></textarea></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">LOGO</td>
      <td height="30" bgcolor="#FFFFFF"><input type="file" name="logo_image" /></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">�Ƽ�</td>
      <td height="30" bgcolor="#FFFFFF">
      	<input type="radio" name="istop" value="1" <?php if($webset['isblank']) echo 'checked';?>>��
        <input type="radio" name="istop" value="0" <?php if(!$webset['isblank']) echo 'checked';?>>��
      </td>
    </tr>
    
    <tr> 
      <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"> 
      <input type="hidden" name="select_group" value="-1">
       <input type="hidden" name="user_register_id" value="<?=$arrData['id']?>">
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
