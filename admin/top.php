<?php 
	include("../include/include.php");
	checklogin();
	$userinfo = getrow("select ".TABLEPRE."usergroup.privacy from ".TABLEPRE."users,".TABLEPRE."usergroup where ".TABLEPRE."users.userid=".$_SESSION['bees_UserId']." and ".TABLEPRE."users.groupid=".TABLEPRE."usergroup.id and ".TABLEPRE."usergroup.status=1");	
	$privacy = unserialize($userinfo['privacy']);
	$arrMenu[] = array('href'=>'menu.php?action=0','privacy'=>'basic','title'=>'��������');
	$arrMenu[] = array('href'=>'menu.php?action=2','privacy'=>'news','title'=>'���ݹ���');
	$arrMenu[] = array('href'=>'menu.php?action=3','privacy'=>'picture','title'=>'ͼƬ����');
	$arrMenu[] = array('href'=>'menu.php?action=4','privacy'=>'yanzhengma','title'=>'��֤�����');
	$arrMenu[] = array('href'=>'menu.php?action=1','privacy'=>'user','title'=>'�û�����');
              
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?php echo TITLE;?>��̨����ϵͳ</title>
<link rel="stylesheet" href="css.css">
<base target="contents" />
</head>

<body>

<div class="top">
	<div class="toptext bai" style="text-align:center;"><?php echo TITLE;?><br />��̨����ϵͳ</div>
	<div class="topright cls">
		<ul>
			<?php 
			$ii = 1;
			foreach ($arrMenu as $k => $v){
				if ($privacy[$v['privacy']]) {					
			?>
				<li id="top<?=$ii?>" class="toptil1"><a href="<?=$v['href']?>" onclick="showbg(<?=$ii?>);" class="hui cu" target="<?=$v['target']?>"><?=$v['title']?></a></li>
			<?php 
				$ii++;
			}}?>			
		</ul>
	</div>
</div>
<script>
<!--
	function showbg(lay)
	{
		for(i=1;i<<?=$ii?>;i++)
		{
			eval("document.getElementById('top"+i+"').className=\"toptil1 hui cu\";");
			if(lay==i)
			{
				eval("document.getElementById('top"+i+"').className=\"toptil2 hui cu\";");
			}
		}
	}
//-->
</script>
</body>

</html>