<?php
	include("../../include/include.php");
	checklogin();
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
		$max=rand(100000,999999);
		$up_name=date("Ymd").$max.date("His");
		if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=='image/jpg'  or $_FILES['upfile']['type']=="image/gif")
		{
			if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=='image/jpg' )
				{$l_name=".jpg";}
			if ($_FILES['upfile']['type']=="image/gif")
				{$l_name=".gif";}
				$new_name=$up_name.$l_name;
				// �����ļ���		
				$filename="../../upload/images/".$new_name;
				if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename))
				{		
					$xiaoxi="�ϴ�ͼƬ�ɹ���";		
					chmod($filename,0777);
					$arr['img_left'] = $new_name;	
				}							
		}
		$arr['ftype'] = intval($_POST['ftype']);
		$arr['ftitle'] = trim($_POST['ftitle']);
		$arr['sid'] = trim($_POST['groupid']);
		$arr['rownum'] = intval($_POST['rownum']);
		$arr['tlength'] = intval($_POST['tlength']);
		//print_r($arr);exit;
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
.tb {	
		font-size:12px;
	}

-->
</style>

			<table width="600" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF" class="tb">
                    <form name="form1" method="post" enctype="multipart/form-data">					
					 <tr bgcolor="#FFFFFF">
                        <td width="80">ѡ�����ͣ�</td>
                        <td width="501">
						<input name="ftype" type="radio" value="1" onClick="javascript:document.getElementById('tr_groupid').style.display='block'"  <? if ($tinfo['ftype']==1) echo "checked";?>/>������Ϣ
						<input name="ftype" type="radio" value="2" onClick="javascript:document.getElementById('tr_groupid').style.display='none'"  <? if ($tinfo['ftype']==2) echo "checked";?>/>���¸���</td>
					 </tr>					
					  <tr bgcolor="#FFFFFF">
                        <td width="80">��ʾ���⣺</td>
                        <td width="501"><input name="ftitle" type="text" id="ftitle" size="50" value="<?=$tinfo['ftitle']?>"></td>
                      </tr>
					  <tr bgcolor="#FFFFFF" id="tr_groupid"  style="display:<? echo ($tinfo['ftype']==1)?"block":"none";?>">
                        <td >��ʾ���ࣺ</td>
                        <td ><select name="groupid" id="groupid">
						  <? ShowType_news();?>                        
                            </select>
							<script language=javascript>document.form1.groupid.value="<?=$tinfo['sid']?>"</script>��						  </td>
                      </tr>					 
					  <tr bgcolor="#FFFFFF">
                        <td>��ʾ������</td>
                        <td><input name="rownum" type="text" id="rownum" size="50" value="<?=$tinfo['rownum']?>"></td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td>���ⳤ�ȣ�</td>
                        <td><input name="tlength" type="text" id="tlength" size="50" value="<?=$tinfo['tlength']?>"></td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td>���ͼƬ��</td>
                        <td><input name="upfile" size="20" type="file" />(ע�����ϴ�Ϊ���޸�ͼƬ��)</td>
					  </tr>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="hidden" value="1" name="iid">
						<input type="submit" value="�ύ" name="b1" >
                            <input type="reset" name="Submit22" value="��д">                        </td>
                      </tr>
                    </form>
                  </table>
