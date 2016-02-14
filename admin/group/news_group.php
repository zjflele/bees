<?
	include("../../include/include.php");
	checklogin();
	$pid = intval($_REQUEST['pid']);
	$ac = trim($_GET['ac']);
	$id = intval($_GET['id']);
	
	if (submitcheck('editall')){
		if ($_POST['name']){
			foreach ($_POST['name'] as $k => $name){
                                $curSortInfo = getrow("select * from ".TABLEPRE."sort  where id=$k");
                                $parentInfo = getrow("select * from ".TABLEPRE."sort  where id=".$curSortInfo['parentid']);
                                $ndirlist=$parentInfo["parentlist"]."->[<a href=P_S?pid=".$k.">".$name."</a>]";
				$db->query("update ".TABLEPRE."sort set parentlist='$ndirlist',display=".intval($_POST['order'][$k]).",name='$name',info='".trim($_POST['info'][$k])."',tourl='".trim($_POST['tourl'][$k])."' where id=$k");
			}
		}
	}
	
	if (submitcheck('hbsort')){
		if ($_POST['new_sort_name']=="") alertmessage("请填写分类名称!",2);
		$arr['name'] = trim($_POST['new_sort_name']); 
		$arr['parentid'] = intval($_POST['pid']); 
		$arr['hight'] = intval($_POST['hight'])+1; 
		$nid = inserttable("sort",$arr,1);
		$hb = 1;
	}
	
	if (submitcheck('addsort'))
	{
		if ($_POST['dirname']=="")	alertmessage("请填写分类名称!",2);			
		$arr['name'] = trim($_POST['dirname']); 
		$arr['parentid'] = intval($_POST['pid']); 
		$arr['hight'] = intval($_POST['hight'])+1; 
		$arr['tourl'] = trim($_POST['tourl']); 
		$arr['info'] = trim($_POST['info']); 
		$nid = inserttable("sort",$arr,1);
	}
	
	if ($ac=='del' && $id){
		$db->query("delete from ".TABLEPRE."sort where id=$id");
		alertmessage("删除成功!",1,'news_group.php?pid='.$pid);	
	}
	
	if ($nid){
		$myrs=$db->query("select * from ".TABLEPRE."sort where id=".$pid);
		$rec=$myrs->fetchRow();
		$ndirlist=$rec["parentlist"]."->[<a href=P_S?pid=".$nid.">".$arr['name']."</a>]";
		$ndiridlist=$rec["idlist"].$nid."|";


		$sql = "update ".TABLEPRE."sort set parentlist='$ndirlist',idlist='$ndiridlist',yn_mo=1 where id=$nid";
		$db->query($sql);
		$sql = "update ".TABLEPRE."sort set yn_mo=0 where id=$pid";
		$db->query($sql);
		
		if ($hb){
			$str_sorts = implode(',',$_POST['sorts']);
			$db->query("delete from ".TABLEPRE."sort where id in (".$str_sorts.")");//删除补合并分类
			$db->query("UPDATE ".TABLEPRE."article SET sort_id=$nid,sort_f='".$ndiridlist."' where sort_id in (".$str_sorts.")");//更新文章分类ID
		}
		alertmessage("操作成功!",1,'news_group.php?pid='.$pid);		
	}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
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
          <TD><font color="#FFFFFF"><strong>添加分类</strong></font><a href="<?=$_SERVER['PHP_SELF']."?action=edit"?>"></a></TD>
		   </TR>
        <TR>
          <TD height="543" bgColor=#f8f9fc valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="100%" height="20" align="left">分类导航： 
                                    <?
$i=0;
if ($pid=='')
$pid=1;
$sql="select * from ".TABLEPRE."sort where id=".$pid."";
$myrs=mysql_query($sql,$conn);
$rec=mysql_fetch_array($myrs);
$parentid = $rec["id"];
$hight=$rec["hight"];
if ($rec["parentlist"] <> ""):
$text = $rec["parentlist"];
$text = str_replace("P_A", "news_group.php", $text);
$text = str_replace("P_S", "news_group.php", $text);
endif;
echo $text;
				?>
                                  </td>
                                </tr>
                                <tr> 
                                  <td height="20"></td>
                                </tr>
                                <tr> 
                                  <td> 
								  <form action="" method="post"> 
								  <table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                      <tr> 
                                        <td bgcolor="#FFFFFF">
										 <table width="100%" cellpadding="3" cellspacing="0" border="0">
											
                                            <tr class="hover">
											  <td height="23" align="left"  width="5px;"> 
											  <img src=../images/dian.gif align=absmiddle>						  
											  </td>
											  <td align="left" width="80px;"> 
											   	排序				  
											  </td>
											  <td align="left" width="170px;">											  
											       中文名称
											  </td>											 
											  <td align="left" width="170px;">											  
											  	学名	  
											  </td>
                                              <td align="left">		 
												操作
                                              </td></tr>
                                              <?
					$sql="select * from ".TABLEPRE."sort where parentid=".$pid." order by display,id ";
					//echo  $sql;
					$myrs=mysql_query($sql,$conn);
					while($rec=mysql_fetch_array($myrs))
					{
				  ?>
                                              <tr class="hover">
											  <td height="23" align="left"  width="5px;"> 
											  <img src=../images/dian.gif align=absmiddle>						  
											  </td>
											  <td align="left" width="80px;"> 
											   <?
											   if ($rec["hight"]>1){
													echo "<input type='checkbox' name='sorts[]' value='".$rec["id"]."' \>";
											   }
											   
											   ?>
											  <input type="text" style="width:50px;" name="order[<?=$rec['id']?>]" value="<?=$rec['display']?>">						  
											  </td>
											  <td align="left" width="170px;">											  
											  <input type="text"  style="width:150px;" name="name[<?=$rec['id']?>]" value="<?=$rec['name']?>">						  
											  </td>											 
											  <td align="left" width="170px;">											  
											  <input type="text"  style="width:150px;" name="tourl[<?=$rec['id']?>]" value="<?=$rec['tourl']?>">						  
											  </td>
                                                <td align="left">		 
                                                <a href="news_group.php?pid=<?=$rec["id"]?>">编辑子分类</a> 
                                                <a href="news_group.php?ac=del&pid=<?=$pid?>&id=<?=$rec["id"]?>"><img src="../images/del.png" alt="删除" width="11" height="13" border="0" align="absmiddle"></a>
												
                                              </td></tr>
                    <?
   					 $i+=1;
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
									 <?php if ($hight>0){?>
									<table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                      <tr> 
                                        <td align="left" bgcolor="#E9F8FE">
										<font color="#FF0000">新分类名称：</font>
										<input type="hidden" name="pid" value="<?echo $parentid;?>">
                                                                                <input type="hidden" value="<?echo $hight;?>" name="hight">
										<input type="text" name="new_sort_name" id="new_sort_name" size=20> 
										<input type="submit" name="hbsort" value="合并分类">
										</td>
                                      </tr>
									  </table>
									 <?php }?>  
									</form></td>
                                </tr>
                                <tr> 
                                  <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                  <td> <table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                      <tr> 
                                        <td align="left" bgcolor="#E9F8FE"><font color="#FF0000">添加分类：</font></td>
                                      </tr>
                                      <tr> 
                                        <form name="form1" method="post" action="news_group.php">
                                          <td bgcolor="#FFFFFF"> <div align="center"> 
                                              <table width="100%" border="0">
                                                <tr>
                                                  <td width="20%" align=right>
                                                    <input type="hidden" name="pid" value="<?echo $parentid;?>">
                                                    <input type="hidden" value="<?echo $hight;?>" name="hight">
</td>
                                                  <td  align=left>
                                                  	名称:<input type="text" name="dirname" size="20" onMouseOver=this.focus() onFocus=this.select()><br />
                                                     	学名:<input type="text" name="tourl" size="30"><br />
							<input type="hidden" name="action" value="add">
                                                        <input type="submit" name="addsort" value="添加类别">
                                                  </td>
                                                </tr>
                                                <tr align=center>
                                                  <td colspan="2">&nbsp;</td>
                                                </tr>
                                              </table>
                                          </div></td>
                                        </form>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></TD>
		  </tr>
          </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
