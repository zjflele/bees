<?php
	include("../../include/include.php");
	checklogin();
	$id = intval($_GET['id']);
	if (submitcheck('b1'))
	{
		$arr['ftitle'] = trim($_POST['ftitle']);
		$arr['flink'] = trim($_POST['flink']);
		$arr['fcontent'] = trim($_POST['fcontent']);
		updatetable('index_set',$arr,"fid=$id");
		?>
		<script>
			window.parent.location.href="/index_set.php"; 
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

			<table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form1" method="post">
						<tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">���⣺</span></td>
                        <td><input name="ftitle" type="text" id="ftitle" size="50" value="<?=$tinfo['ftitle']?>"></td>
                      </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td><span class="STYLE1">���ӣ�</span></td>
                        <td><input name="flink" type="text" id="flink" size="50" value="<?=$tinfo['flink']?>"></td>
                      </tr>				 
					  <tr bgcolor="#FFFFFF">
                        <td width="8%" valign="top" class="STYLE1">������</td>
                        <td width="92%"><textarea name="fcontent" rows="15" cols="100"><?=$tinfo['fcontent']?></textarea></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="hidden" value="1" name="iid">
						<input type="submit" value="�ύ" name="b1" >
                            <input type="reset" name="Submit22" value="��д">                        </td>
                      </tr>
                    </form>
                  </table>
