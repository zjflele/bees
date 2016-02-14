<?
	include("../../include/include.php");
	checklogin();
	$ac = trim($_GET['ac']);
	$id = intval($_GET['id']);
	
	if (submitcheck('editall')){
		if ($_POST['name']){
			foreach ($_POST['name'] as $k => $name){
				$db->query("update ".TABLEPRE."index_menu set display=".intval($_POST['order'][$k]).",name='$name' where id=$k");
			}
		}
	}
	
	if (submitcheck('addmenu'))
	{
		if ($_POST['name']=="")	alertmessage("请填写导航名称!",2);			
		$arr['name'] = trim($_POST['name']); 
		$arr['stype'] = intval($_POST['stype']); 
		$arr['sid'] = intval($_POST['sid']); 
		$arr['slink'] = trim($_POST['slink']); 
		$arr['display'] = intval($_POST['display']); 
		$arr['siteid'] = $_SESSION['bees_SiteId'];
		//print_r($arr);
		$nid = inserttable("index_menu",$arr,1);
	}
	if (submitcheck('editmenu'))
	{
		if ($_POST['name']=="")	alertmessage("请填写导航名称!",2);			
		$arr['name'] = trim($_POST['name']); 
		$arr['stype'] = intval($_POST['stype']); 
		$arr['sid'] = intval($_POST['sid']); 
		$arr['slink'] = trim($_POST['slink']); 
		$arr['display'] = intval($_POST['display']); 
		$arr['siteid'] = $_SESSION['bees_SiteId'];
		$where = "id=".intval($_POST['mid']); 
		//print_r($arr);
		$nid = updatetable("index_menu",$arr,$where);
		alertmessage("修改成功!",1,'index_menu1.php');
	}
	if ($ac=='edit' && $id){
		$minfo = getrow("select * from ".TABLEPRE."index_menu where id=$id");
	}
	
	if ($ac=='del' && $id){
		$db->query("delete from ".TABLEPRE."index_menu where id=$id");
		alertmessage("删除成功!",1,'index_menu1.php');	
	}
	
	$arrMenu = getlist("select * from ".TABLEPRE."index_menu where sheight=1 and siteid=".$_SESSION['bees_SiteId']." order by display asc,id asc");
	//一级分类列表
	$arrSort1 = getlist("SELECT id, name FROM `".TABLEPRE."sort` WHERE hight =1 AND id in (".$_SESSION['bees_MySortId'].")");
	
		
	//print_r($_SESSION['bees_MySortId']);exit;
	
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script type="text/javascript" src="/js/jquery.js"></script>
<script language=javascript>
<!--
function del(http)
{
 if (window.confirm("你是否真的要删除，删除之后就不能恢复") ){
 window.open(http,"删除","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,width=100,height=200,top=990,left=1025") 
 }
}
function winopen(url)                    
     {                    
        window.open(url,"search","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=440,height=175,top=80,left=100");
}
//-->
</script>
<style type="text/css">
.hover td{
	border-top: 1px dotted #DEEFFB;
}
.hover:hover {
	background: #F5F9FD;
}

textarea, input, select {
padding: 2px;
border: 1px solid;
background: #F9F9F9;
color: #333;
resize: none;
border-color: #666 #CCC #CCC #666;
}

body, td, input, textarea, select, button {
color: #555;
font: 12px "Lucida Grande", Verdana, Lucida, Helvetica, Arial, sans-serif;
}
</style>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="95%" align=center 
      border=0>
        <TBODY>
        <TR class=header align=left>
          <TD><font color="#FFFFFF"><strong>首页导航管理</strong></font></TD>
		   </TR>
        <TR>
          <TD height="543" bgColor=#f8f9fc valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td> 
								  <form action="" method="post"> 
								  <table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
								  <tr> 
                                        <td bgcolor="#FFFFFF">
										一级分类
										</td></tr>
                                      <tr> 
                                        <td bgcolor="#FFFFFF">
										
										 <table width="100%" cellpadding="3" cellspacing="0" border="0">
                                            
                                              <?
				if ($arrMenu){
					foreach ($arrMenu as $k => $v){
				  ?>                                              
											   <tr class="hover">
											  <td height="23" align="left"  width="5px;"> 
											  <img src=../images/dian.gif align=absmiddle>						  
											  </td>
											  <td align="left" width="80px;"> 											   
											  	<input type="text" style="width:50px;" name="order[<?=$v['id']?>]" value="<?=$v['display']?>">					  
											  </td>
											  <td align="left" width="170px;">											  
											  <input type="text"  style="width:150px;" name="name[<?=$v['id']?>]" value="<?=$v['name']?>">						  
											  </td>
											  <td align="left">	                     
                                               <a href='index_menu2.php?mid=<?=$v['sid']?>'>编辑子栏目</a>
												<a href="index_menu1.php?ac=edit&id=<?=$v["id"]?>')"><img src="../images/edit.png" alt="编辑" width="12" height="13" border="0" align="absmiddle"></a> 
                                                <a href="index_menu1.php?ac=del&id=<?=$v["id"]?>"><img src="../images/del.png" alt="删除" width="11" height="13" border="0" align="absmiddle"></a>
												</td>
												</tr>
										   <?
											 $i+=1;  					
											}
											}
											?>
                                            											
                                          </table>
																		  </td>
                                      </tr>
                                    </table>
									<table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                      <tr> 
                                        <td align="left" bgcolor="#E9F8FE">										
										<input type="submit" name="editall" style="width:100px;" value="批量修改">
										</td>
                                      </tr>
									  </table>
									  </form>
									</td>
                                </tr>
                                <tr> 
                                  <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                  <td> 
								  <?php if ($ac=='edit' && $id){?>
								  <table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                      <tr> 
                                        <td align="left" bgcolor="#E9F8FE"><font color="#FF0000">编辑导航：</font></td>
                                      </tr>
                                      <tr> 
                                        <form name="form1" method="post">
                                          <td bgcolor="#FFFFFF"> <div align="center"> <br>
                                          <table width="58%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                            <tr  bgcolor="#FFFFFF">
                                              <td width="23%" align=right>
                                                导航名称：</td>
                                                    <td width="77%" align=left><input type="text" name="name" size="20" value="<?=$minfo['name']?>" onMouseOver=this.focus() onFocus=this.select()></td>
                                            </tr>
                                            <tr bgcolor="#FFFFFF">
                                              <td width="23%" rowspan="2" align=right valign="top">导航类型：</td>
                                                    <td width="77%" align=left>
                                                      <input name="stype" type="radio" value="1" <?php if ($minfo['stype']==1) echo "checked";?>>文章分类
                                                      <select name="sid" id="sid">
                                                  <? foreach ($arrSort1 as $k => $v){
												  		echo "<option value='$v[id]'>$v[name]</option>";	
													}
												  ?>												 
                                              </select>												  </td>
										    </tr>                                           
                                            <tr bgcolor="#FFFFFF">
                                              <td width="77%" align=left>
                                                <input name="stype" type="radio" value="2" <?php if ($minfo['stype']==2) echo "checked";?>>
                                                其它链接
                                              地址：<input type="text" name="slink" size="40" value="<?=$minfo['slink']?>" onMouseOver=this.focus() onFocus=this.select()>　</td>
										    </tr>
											<script>
												  	document.getElementById('sid').value="<?=$minfo['sid']?>";													
											</script>
											<tr  bgcolor="#FFFFFF">
                                              <td width="23%" align=right>
                                                显示顺序：</td>
                                                    <td width="77%" align=left><input type="text" name="display" size="20"   value="<?=$minfo['display']?>"></td>
                                            </tr>
                                            <tr bgcolor="#FFFFFF">
                                              <td colspan="2" align=center>
											  <input type="hidden" name="mid" value="<?=$minfo['id']?>">
                                                <input type="submit" name="editmenu" value="修改类别"></td>
                                            </tr>
                                            </table>
                                              <br>
                                          </div></td>
                                        </form>
                                      </tr>
                                    </table>
								  
								  <?php }else{ ?>
								  
								  <table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                      <tr> 
                                        <td align="left" bgcolor="#E9F8FE"><font color="#FF0000">添加新导航：</font></td>
                                      </tr>
                                      <tr> 
                                        <form name="form1" method="post">
                                          <td bgcolor="#FFFFFF"> <div align="center"> <br>
                                          <table width="58%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                            <tr  bgcolor="#FFFFFF">
                                              <td width="23%" align=right>
                                                导航名称：</td>
                                              <td width="77%" align=left><input type="text" name="name" size="20" onMouseOver=this.focus() onFocus=this.select()></td>
                                            </tr>
                                            <tr bgcolor="#FFFFFF">
                                              <td width="23%" rowspan="2" align=right valign="top">导航类型：</td>
                                                    <td width="77%" align=left>
                                                      <input name="stype" type="radio" value="1" checked>文章分类
                                                      <select name="sid">
                                                        <? foreach ($arrSort1 as $k => $v){
												  		echo "<option value='$v[id]'>$v[name]</option>";	
													}
												  ?>
                                              </select>												  </td>
										    </tr>                                           
                                            <tr bgcolor="#FFFFFF">
                                              <td width="77%" align=left>
                                                <input name="stype" type="radio" value="2">
                                                其它链接
                                              地址：<input type="text" name="slink" size="40" onMouseOver=this.focus() onFocus=this.select()>　</td>
										    </tr>
											<tr  bgcolor="#FFFFFF">
                                              <td width="23%" align=right>
                                                显示顺序：</td>
                                              <td width="77%" align=left><input type="text" name="display" size="20"  value="1"></td>
                                            </tr>
                                            <tr bgcolor="#FFFFFF">
                                              <td colspan="2" align=center>
                                                <input type="submit" name="addmenu" value="添加类别"></td>
                                            </tr>
                                            </table>
                                              <br>
                                          </div></td>
                                        </form>
                                      </tr>
                                    </table>
									
									<?php }?>
									
									
									</td>
                                </tr>
                              </table></TD>
		  </tr>
          </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
