<?php
	include("../../include/include.php");
	checklogin();
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
		$arr['ftype'] = intval($_POST['ftype']);
		$arr['ftitle'] = trim($_POST['ftitle']);
		$arr['sid'] = ($arr['ftype']==1)?intval($_POST['groupid']):intval($_POST['vtype']);
		$arr['rownum'] = intval($_POST['rownum']);
		$arr['tlength'] = intval($_POST['tlength']);
		//print_r($arr);exit;
		updatetable('index_set',$arr,"fid=$id and siteid=".intval($_SESSION['bees_SiteId']));
		$index_set = ($_SESSION['bees_SiteId'])?'../../site/index_set.php':'../../index_set.php';
		?>
		<script>
			window.parent.location.href="<?=$index_set?>"; 
		</script>
		<?
	}
	if ($id){		
		$tinfo = $db->GetRow("select * from ".TABLEPRE."index_set where siteid=".$_SESSION['bees_SiteId']." and fid=".$id);
	}
		
?>
<style type="text/css">
<!--
.tb {	
		font-size:12px;
	}

-->
</style>

			<table width="600" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF" class="tb">
                    <form name="form1" method="post">					
					 <tr bgcolor="#FFFFFF">
                        <td width="80">选择类型：</td>
                        <td width="501">
                        
                        <input name="ftype" type="radio" value="1" onClick="javascript:document.getElementById('tr_groupid').style.display='block';document.getElementById('tr_vtype').style.display='none'" <? if ($tinfo['ftype']==1) echo "checked";?>/>新闻信息
                        
                        <input name="ftype" type="radio" value="3"  onClick="javascript:document.getElementById('tr_groupid').style.display='none';document.getElementById('tr_vtype').style.display='none'"  <? if ($tinfo['ftype']==3) echo "checked";?>/>最新更新
                        
                        <input name="ftype" type="radio" value="2"  onClick="javascript:document.getElementById('tr_groupid').style.display='none';document.getElementById('tr_vtype').style.display='block'"  <? if ($tinfo['ftype']==2) echo "checked";?>/>视频信息   
                        
                        <input name="ftype" type="radio" value="7"  onClick="javascript:document.getElementById('tr_groupid').style.display='none';document.getElementById('tr_vtype').style.display='none'"  <? if ($tinfo['ftype']==7) echo "checked";?>/>供求信息
                        
                        </td>
					 </tr>					
					  <tr bgcolor="#FFFFFF">
                        <td width="80">显示标题：</td>
                        <td width="501"><input name="ftitle" type="text" id="ftitle" size="50" value="<?=$tinfo['ftitle']?>"></td>
                      </tr>
					  <tr bgcolor="#FFFFFF" id="tr_groupid" style="display:<? echo ($tinfo['ftype']==1)?"block":"none";?>">
                        <td >显示分类：</td>
                        <td ><select name="groupid" id="groupid">
						  <? ShowType_news();?>                        
                            </select>
							<script language=javascript>document.form1.groupid.value="<?=$tinfo['sid']?>"</script>　						  </td>
                      </tr>		
                      <tr bgcolor="#FFFFFF" id="tr_vtype" style="display:<? echo ($tinfo['ftype']==2)?"block":"none";?>">
                        <td >显示分类：</td>
                        <td ><select name="vtype" id="vtyp">
                                	<?php
                                    	foreach ($videoType as $k => $v){
											echo '<option value="'.$k.'">'.$v.'</option>';
										}	
									?>
                                	
                                </select>
							<script language=javascript>document.form1.vtype.value="<?=$tinfo['sid']?>"</script>　						  </td>
                      </tr>				 
					  <tr bgcolor="#FFFFFF">
                        <td>显示条数：</td>
                        <td><input name="rownum" type="text" id="rownum" size="50" value="<?=$tinfo['rownum']?>"></td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td>标题长度：</td>
                        <td><input name="tlength" type="text" id="tlength" size="50" value="<?=$tinfo['tlength']?>"></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="hidden" value="1" name="iid">
						<input type="submit" value="提交" name="b1" >
                            <input type="reset" name="Submit22" value="重写">                        </td>
                      </tr>
                    </form>
                  </table>
