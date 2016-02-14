<?php
	include("../../include/include.php");
	checklogin();
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
		$max=rand(100000,999999);
		$up_name=date("Ymd").$max.date("His");
		if ($_FILES['picture']['type']=="image/pjpeg" or $_FILES['picture']['type']=="image/jpeg"  or $_FILES['picture']['type']=='image/jpg'  or $_FILES['picture']['type']=="image/gif")
		{
			if ($_FILES['picture']['type']=="image/pjpeg" or $_FILES['picture']['type']=="image/jpeg"  or $_FILES['picture']['type']=='image/jpg' )
			{$l_name=".jpg";}
			if ($_FILES['picture']['type']=="image/gif")
			{$l_name=".gif";}
				$new_name=$up_name.$l_name;
				// 构造文件名		
				$filename="../../upload/images/".$new_name;
				if (move_uploaded_file($_FILES['picture']['tmp_name'],$filename))
				{		$xiaoxi="上传图片成功！";		
				chmod($filename,0777);}
				else{	$xiaoxi="上传图片不成功！";}
			$arr['img_left'] = trim($new_name);
		}
		$arr['ftitle'] = trim($_POST['ftitle']);
		$arr['flink'] = trim($_POST['flink']);		
		$arr['fcontent'] = trim($_POST['fcontent']);
		$arr['plink'] = trim($_POST['plink']);		
		$arr['rownum'] = intval($_POST['rownum']);
		$arr['tlength'] = intval($_POST['tlength']);
		$arr['ftype'] = intval($_POST['ftype']);
		$arr['sid'] = ($arr['ftype']==4)?intval($_POST['groupid']):intval($_POST['ptype']);
		updatetable('index_set',$arr,"fid=$id");
		?>
		<script>
			window.parent.location.href="../../index_set.php"; 
		</script>
		<?
	}
	if ($id){		
		$tinfo = $db->GetRow("select * from ".TABLEPRE."index_set where fid=".$id);
	}
		
?>
<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
.STYLE2 {font-size: 12}
-->
</style>

			<table width="665" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form1" method="post" enctype="multipart/form-data">
						<tr bgcolor="#FFFFFF">
                        <td width="67"><span class="STYLE1">显示标题：</span></td>
                        <td width="579"><input name="ftitle" type="text" id="ftitle" size="50" value="<?=$tinfo['ftitle']?>"></td>
                      </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">标题链接：</span></td>
                        <td><input name="flink" type="text" id="flink" size="50" value="<?=$tinfo['flink']?>"></td>
                      </tr>	
                      <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">显示图片：</span></td>
                        <td><input name="picture" type="file" id="picture" size="30"></td>
                      </tr>	
                      			 
					  <tr bgcolor="#FFFFFF">
                        <td  valign="top" class="STYLE1">HTML内容：</td>
                        <td ><textarea name="fcontent" rows="15" cols="60"><?=$tinfo['fcontent']?></textarea></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">图文链接：</span></td>
                        <td><input name="plink" type="text" id="plink" size="50" value="<?=$tinfo['plink']?>"></td>
                      </tr>	
                       <tr bgcolor="#FFFFFF" >
                        <td ><span class="STYLE1">模块类型：</span></td>
                        <td >
                        <input name="ftype" type="radio" value="4"  <? if ($tinfo['ftype']==4) echo "checked";?> onClick="javascript:document.getElementById('tr_groupid').style.display='block';document.getElementById('tr_ptype').style.display='none'"/>新闻信息
                        <input name="ftype" type="radio" value="5"  <? if ($tinfo['ftype']==5) echo "checked";?> onClick="javascript:document.getElementById('tr_groupid').style.display='none';document.getElementById('tr_ptype').style.display='block'"/>
                        图片信息						  </td>
                      </tr>
                      <tr bgcolor="#FFFFFF" id="tr_groupid"  style="display:<? echo ($tinfo['ftype']==4)?"block":"none";?>" >
                        <td ><span class="STYLE1">显示分类：</span></td>
                        <td >
                        <select name="groupid" id="groupid">
						  <? ShowType_news();?>                        
                            </select>
							<script language=javascript>document.form1.groupid.value="<?=$tinfo['sid']?>"</script>　						  </td>
                      </tr>
                      <tr bgcolor="#FFFFFF" id="tr_ptype"  style="display:<? echo ($tinfo['ftype']==5)?"block":"none";?>">
                        <td ><span class="STYLE1">显示分类：</span></td>
                        <td >
                        <select name="ptype" id="ptype">
                                	<?php
                                    	foreach ($pictureType as $k => $v){
											echo '<option value="'.$k.'">'.$v.'</option>';
										}	
									?>
                                	
                                </select>
							<script language=javascript>document.form1.ptype.value="<?=$tinfo['sid']?>"</script>　						  </td>
                      </tr>	
                      <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">显示条数：</span></td>
                        <td><input name="rownum" type="text" id="rownum" size="50" value="<?=$tinfo['rownum']?>"></td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">标题长度：</span></td>
                        <td><input name="tlength" type="text" id="tlength" size="50" value="<?=$tinfo['tlength']?>"></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="hidden" value="1" name="iid">
						<input type="submit" value="提交" name="b1" >
                            <input type="reset" name="Submit22" value="重写">                        </td>
                      </tr>
                    </form>
            </table>
