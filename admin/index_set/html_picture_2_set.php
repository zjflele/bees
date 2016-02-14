<?php
	include("../../include/include.php");
	checklogin();
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
		//左侧图片
		$max=rand(100000,999999);
		$up_name=date("Ymd").$max.date("His");
		if ($_FILES['img_left']['type']=="image/pjpeg" or $_FILES['img_left']['type']=="image/jpeg"  or $_FILES['img_left']['type']=='image/jpg'  or $_FILES['img_left']['type']=="image/gif")
		{
			if ($_FILES['img_left']['type']=="image/pjpeg" or $_FILES['img_left']['type']=="image/jpeg"  or $_FILES['img_left']['type']=='image/jpg' )
			{$l_name=".jpg";}
			if ($_FILES['img_left']['type']=="image/gif")
			{$l_name=".gif";}
			$new_name=$up_name.$l_name;
				// 构造文件名		
				$filename="../../upload/images/".$new_name;
				if (move_uploaded_file($_FILES['img_left']['tmp_name'],$filename))
				{		$xiaoxi="上传图片成功！";		
				chmod($filename,0777);}
				else{	$xiaoxi="上传图片不成功！";}
			$arr['img_left'] = trim($new_name);
		}
		
		//右侧图片
		$max=rand(100000,999999);
		$up_name=date("Ymd").$max.date("His");
		if ($_FILES['img_right']['type']=="image/pjpeg" or $_FILES['img_right']['type']=="image/jpeg"  or $_FILES['img_right']['type']=='image/jpg'  or $_FILES['img_right']['type']=="image/gif")
		{
			if ($_FILES['img_right']['type']=="image/pjpeg" or $_FILES['img_right']['type']=="image/jpeg"  or $_FILES['img_right']['type']=='image/jpg' )
			{$l_name=".jpg";}
			if ($_FILES['img_right']['type']=="image/gif")
			{$l_name=".gif";}
			$new_name=$up_name.$l_name;
				// 构造文件名		
				$filename="../../upload/images/".$new_name;
				if (move_uploaded_file($_FILES['img_right']['tmp_name'],$filename))
				{		$xiaoxi="上传图片成功！";		
				chmod($filename,0777);}
				else{	$xiaoxi="上传图片不成功！";}
			$arr['img_right'] = trim($new_name);
		}
		$arr['ftitle'] = trim($_POST['ftitle']);
		$arr['flink'] = trim($_POST['flink']);	
			
		$arr['fcontent'] = serialize(array(
							'img_left_text' => trim($_POST['img_left_text']),
							'img_left_plink' => trim($_POST['img_left_plink']),
							'img_right_text' => trim($_POST['img_right_text']),
							'img_right_plink' => trim($_POST['img_right_plink']),
							));
		
		$arr['ftype'] = 6;
		  
		updatetable('index_set',$arr,"fid=$id");
		?>
		<script>
			window.parent.location.href="../../index_set.php"; 
		</script>
		<?
	}
	if ($id){		
		$tinfo = $db->GetRow("select * from ".TABLEPRE."index_set where fid=".$id);
		$tinfo['fcontent'] = unserialize($tinfo['fcontent']);
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
						<!--tr bgcolor="#FFFFFF">
                        <td width="90"><span class="STYLE1">显示标题：</span></td>
                        <td width="579"><input name="ftitle" type="text" id="ftitle" size="50" value="<?=$tinfo['ftitle']?>"></td>
                      </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">标题链接：</span></td>
                        <td><input name="flink" type="text" id="flink" size="50" value="<?=$tinfo['flink']?>"></td>
                      </tr-->	
                      <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">图片：</span></td>
                        <td><input name="img_left" type="file" id="img_left" size="30"></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">文字：</span></td>
                        <td><input name="img_left_text" type="text" id="img_left_text" size="50" value="<?=$tinfo['fcontent']['img_left_text']?>"></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">图文链接：</span></td>
                        <td><input name="img_left_plink" type="text" id="img_left_plink" size="50" value="<?=$tinfo['fcontent']['img_left_plink']?>"></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center">
						<input type="submit" value="提交" name="b1" >
                        <input type="reset" name="Submit22" value="重写">                        </td>
                      </tr>
                    </form>
            </table>
