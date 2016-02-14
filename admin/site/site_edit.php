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
			if($obj->Update())
			{
			$js=new Javascript();
			$js->Begin();
			$js->Alert("修改成功！");
			$js->GoToUrl("site_manage.php");
			$js->End();
			exit();
		     }
		    else
		    {
			alertmessage("更新失败！",2);
			exit();
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
	elseif havenoChar(form.userpwd.value)<>true then
		msgbox("您的密码有错误，请按规定填写！")
		form.userpwd.focus
		tag=1
	elseif form.userpwd.value<>form.userpwds.value then
	    msgbox("两次输入的密码不一致")
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
          <TD colspan="3">用户编辑</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <form name="form" method="post" action="site_edit.php?action=action"  onSubmit="return onSubmit()" enctype="multipart/form-data">
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B8E094">
   <tr> 
      <td  bgcolor="#FFFFFF">子站名称</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text"  value="<?=$obj->GetField("zname")?>" name="zname" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"></td>
    </tr>
    <tr> 
      <td width="100" bgcolor="#FFFFFF">用户名</td>
      <td  height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="text" name="username" value="<?=$obj->GetField("username")?>" readonly style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"><div id="divuserid" /> </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">密码</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="password" name="userpwd" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px"></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">重复密码</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="password" name="userpwds" style="background-color: #FFFFFF; border-color: green; border-style: solid; border-width: 0px 0px 1px">
        <span class="PadLeft20">(此项为空则密码不变)</span></td>
    </tr>
	
	 <tr> 
      <td height="30" bgcolor="#FFFFFF">所属地区</td>
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
      <td height="30" bgcolor="#FFFFFF">类型</td>
      <td height="30" bgcolor="#FFFFFF">&nbsp;&nbsp;
        <select name="stype">
		<?php
            foreach ($siteTypes as $k => $type ) {
				$selected = ($obj->GetField('stype')==$k)?'selected':'';
                echo "<option value=$k  $selected>$type</option>\n";
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
				$selected = ($obj->GetField('slevel')==$k)?'selected':'';
                echo "<option value=$k $selected>$level</option>\n";
            }
        ?>
        </select>
        </td>
    </tr>
	<tr bgcolor="#FFFFFF">
                        <td>拥有版块：</td>
                        <td><? 
						$sql="select * from ".TABLEPRE."sort where id<>'' and hight=1";
						$myrs=mysql_query($sql,$myconn);
						$group=explode(",",$obj->GetField("my_sort"));					
						while($rec=mysql_fetch_assoc($myrs))
						{								
							$checked=getIsPrivacy($group,$rec[id]);				
							echo "<input name='group[]' type='checkbox' value='$rec[id]' $checked>$rec[name]"."　　<BR />";
							$sub_myrs=mysql_query("select * from ".TABLEPRE."sort where parentid=$rec[id] and hight=2",$myconn);
							while($sub_rec=mysql_fetch_assoc($sub_myrs))
							{
								$checked=getIsPrivacy($group,$sub_rec[id]);	
								echo "<img src='/images/corner-dots.gif'><input name='group[]' type='checkbox' value='$sub_rec[id]' $checked>$sub_rec[name]"."　　<BR />";	
							}
						}

						function getIsPrivacy($group,$id){
							$group_count=count($group);
							for ($nn=0;$nn<$group_count;$nn+=1)
							{ 
								if($group[$nn]==$id) 
									return 'checked';  
								}	
						}
						?></td>
                      </tr>
     <tr> 
      <td height="30" bgcolor="#FFFFFF">子站简介</td>
      <td height="30" bgcolor="#FFFFFF"><textarea name="description" cols="120" rows="20"><?php echo $obj->GetField('description');?></textarea></td>
    </tr>  
    <tr> 
      <td height="30" bgcolor="#FFFFFF">LOGO</td>
      <td height="30" bgcolor="#FFFFFF"><input type="file" name="logo_image" /></td>
    </tr>
    <tr> 
      <td height="30" bgcolor="#FFFFFF">推荐</td>
      <td height="30" bgcolor="#FFFFFF">
      	<input type="radio" name="istop" value="1" <?php if($obj->GetField('istop')) echo 'checked';?>>是
        <input type="radio" name="istop" value="0" <?php if(!$obj->GetField('istop')) echo 'checked';?>>否
      </td>
    </tr>               
    <tr> 
      <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"> 
        <input type="button" onClick=checkform() name="send_user" value="提交"></td>
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
