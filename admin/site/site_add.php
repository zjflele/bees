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
		$obj->User["password"]  = ($arrRegister['PASSWORD'])?$arrRegister['PASSWORD']:md5($obj->Post["userpwd"]);		
		$obj->User["zname"]	= $obj->Post["zname"];	
		$obj->User["groupid"] = $obj->Post["select_group"];
		$obj->User["my_sort"]	= $my_sort;		
		$obj->User["cityid"] = $obj->Post["cityid"];
		$obj->User["description"] = $obj->Post["description"];
		$obj->User["istop"] = $obj->Post["istop"];
		$obj->User["stype"] = $obj->Post["stype"];
		$obj->User["slevel"] = $obj->Post["slevel"];
		//上传图片
		$max=rand(100000,999999);
		$up_name=date("Ymd").$max.date("His");
		if ($_FILES['logo_image']['type']=="image/pjpeg" or $_FILES['logo_image']['type']=="image/jpeg"  or $_FILES['logo_image']['type']=='image/jpg'  or $_FILES['logo_image']['type']=="image/gif")
			{
			if ($_FILES['logo_image']['type']=="image/pjpeg" or $_FILES['logo_image']['type']=="image/jpeg"  or $_FILES['logo_image']['type']=='image/jpg' )
			{$l_name=".jpg";}
			if ($_FILES['logo_image']['type']=="image/gif")
			{$l_name=".gif";}
				$new_name=$up_name.$l_name;
				// 构造文件名		
				$filename="../../upload/images/".$new_name;
				if (move_uploaded_file($_FILES['logo_image']['tmp_name'],$filename))
				{		
						$xiaoxi="上传图片成功！";		
						chmod($filename,0777);
						$obj->User["logo_image"] = $new_name;
				} 
		}
		
		
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
				if ($arrRegister){
					$db->query("UPDATE ".TABLEPRE."user_register SET status=1 WHERE id=$arrRegister[id]"); 	
				}
				$siteid = $obj->getInsertId();
				init_site_info($siteid);
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

function init_site_info($siteid){
	for($i=1;$i<=10;$i++) {
		$index_set['fid'] = $i;
		$index_set['ftype'] = 1;
		$index_set['ftitle'] = '活动版块';
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
	<?php if (!$arrData) {?>
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
          <TD colspan="3">子站添加</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <form name="form" method="post" action="site_add.php?action=action"  onSubmit="return onSubmit()" enctype="multipart/form-data">
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B8E094">
   <tr> 
      <td  bgcolor="#FFFFFF">子站名称</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="zname" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px" value="<?=$arrData['zname']?>"></td>
    </tr>
    <tr> 
      <td width="100" bgcolor="#FFFFFF">登录名</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="username" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px" value="<?=$arrData['username']?>"><div id="divuserid" /> </td>
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
      <td height="30" bgcolor="#FFFFFF">所属地区</td>
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
      <td height="30" bgcolor="#FFFFFF">类型</td>
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
      <td height="30" bgcolor="#FFFFFF">级别</td>
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
      <td height="30" bgcolor="#FFFFFF">子站简介</td>
      <td height="30" bgcolor="#FFFFFF"><textarea name="description" cols="120" rows="20"></textarea></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">LOGO</td>
      <td height="30" bgcolor="#FFFFFF"><input type="file" name="logo_image" /></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">推荐</td>
      <td height="30" bgcolor="#FFFFFF">
      	<input type="radio" name="istop" value="1" <?php if($webset['isblank']) echo 'checked';?>>是
        <input type="radio" name="istop" value="0" <?php if(!$webset['isblank']) echo 'checked';?>>否
      </td>
    </tr>
    
    <tr> 
      <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"> 
      <input type="hidden" name="select_group" value="-1">
       <input type="hidden" name="user_register_id" value="<?=$arrData['id']?>">
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
