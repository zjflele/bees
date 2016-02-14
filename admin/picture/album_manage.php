<?php
	include("../../include/include.php");
        $ptype = intval($_REQUEST['ptype']);
        $atype = intval($_REQUEST['atype']);
        $aid = intval($_REQUEST['aid']);
	if(@$_GET["action"]=="del" && @$_GET["aid"])
	{
		$obj = new EasyDB(album);
		$obj->IDVars="aid";
		$obj->SetLimit(1);
		if($obj->Delete())
		{
			$js=new Javascript();
			$js->Begin();
			$js->Alert("删除信息成功!");
			$js->GoToUrl($_SERVER["HTTP_REFERER"]);
			$js->End();
		}
		else
		{
			Error("删除信息失败。", $_SERVER["HTTP_REFERER"]);
		}
		exit();
	}
	if(@$_GET["action"]=="edit")
	{	
		if ($_POST['title']){	
			$title = htmlspecialchars($_POST['title']);
			$category = intval($_POST['category_7']); 
			$sql="UPDATE ".TABLEPRE."album SET `title` = '".$title."',`category` = '".$category."' WHERE aid=".$aid;	
			$myrs=mysql_query($sql,$myconn);
		}else{
			$albumInfo = getrow("select * from ".TABLEPRE."album where aid=$aid");
			//print_r($albumInfo);
		}
	}
	if(@$_GET["action"]=="add")
	{
		$updtime=date("Y-m-d H:i:s");	
		$title = htmlspecialchars($_POST['title']);        					 		$category = intval($_POST['category_7']);        
		$sql="insert into ".TABLEPRE."album ( `title` ,`category` ,`atype` , `updtime`)VALUES ( '$title','$category', '$atype','$updtime')";
		$myrs=mysql_query($sql,$myconn);
		if ($myrs)
		{
		?>
		<script language=javascript>    
			 alert("添加成功！");
			 window.location="album_manage.php?ptype=<?=$ptype?>&atype=<?=$atype?>";
		</script>
		<?
		}		
	}
	
	$sqlstr_tt="select *,(select imgpath from ".TABLEPRE."picture p where p.aid=a.aid order by showtime desc limit 1) as imgpath  from ".TABLEPRE."album a where atype=".$atype;	
	$sqlstr_tt.=" order by updtime desc";
	//echo $sqlstr_tt;
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
        //------------分页设置------------------
        $pagesize=20;
        if (empty($currentpage)) $currentpage=1;
        $filename=$PHP_SELF."?1=1";
        $totalpage=ceil($i/$pagesize);
        if ($totalpage<$currentpage)
        $currentpage = $totalpage;
        $offset=($currentpage-1)*$pagesize;
        $offend=$offset+20;
        //-----------分页设置----------
        $sqlstr=$sqlstr_tt." limit $offset,$pagesize";	
            //echo $sqlstr;
        $myrs_tt=mysql_query($sqlstr);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<style type="text/css">
.inline-block:after {
    content: ".";
    display: inline-block;
    height: 100%;
    vertical-align: middle;
    visibility: hidden;	
}
.inline-block:after {
    content: ".";
    display: inline-block;
    height: 100%;
    vertical-align: middle;
    visibility: hidden;
}
.inline-block:after {
    content: ".";
    display: inline-block;
    height: 100%;
    vertical-align: middle;
    visibility: hidden;
}
.p1 {
    background: url("../../images/grkj-xcbackground2.jpg") no-repeat scroll 0 0 transparent;
    height: 206px;
    text-align: center;
    width: 206px;
	padding-top:15px;
}
</style>
<script type="text/javascript">
	function checkForm(myform){
		if (myform.title.value==''){
			alert('请填写相册标题');
			return false;	
		}
		
		if (!myform.category_7.value){
			alert('请选择分类');
			return false;	
		}
		
		return true;
		
	}
</script>

</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY>
        <?php if ($albumInfo){?>
        <form enctype="multipart/form-data" name="form" method="post" action="album_manage.php?action=edit&atype=<?=intval($_GET['atype'])?>"  onsubmit="return checkForm(this);">
        <TR class=header align=left>
          <TD colspan="2">相册管理</TD>
		  <TD width="91%" >                      
            相册标题：<input type="text" name="title" id="title" size="20" value="<?=$albumInfo['title']?>">
            分类：
			<?=CreateSelect('category_1','',0,80,"onChange='changeCategory(this.value,\"2\")'");?>
            <?=CreateSelect('category_2','',0,80,"onChange='changeCategory(this.value,\"3\")'");?>
            <?=CreateSelect('category_3','',0,80,"onChange='changeCategory(this.value,\"4\")'");?>
            <?=CreateSelect('category_4','',0,80,"onChange='changeCategory(this.value,\"5\")'");?>
            <?=CreateSelect('category_5','',0,80,"onChange='changeCategory(this.value,\"6\")'");?>
            <?=CreateSelect('category_6','',0,80,"onChange='changeCategory(this.value,\"7\")'");?>
            <?=CreateSelect('category_7','',0,80);?>
            <input type="hidden" name="aid" value="<?=$aid?>">
            <input type="hidden" name="atype" value="<?=$atype?>">
            <input type="hidden" name="ptype" value="<?=$ptype?>">
		    <input type="submit" name="Submit" value="编辑">		   　
		   	  </TD>
          </TR> </form>
        <?php } else {?>
        <form enctype="multipart/form-data" name="form" method="post" action="album_manage.php?action=add&atype=<?=intval($_GET['atype'])?>"  onsubmit="return checkForm(this);">
        <TR class=header align=left>
          <TD colspan="2">相册管理</TD>
		  <TD width="91%" >                      
            相册标题：<input type="text" name="title" id="title" size="20">
            分类：
			<?=CreateSelect('category_1','',0,80,"onChange='changeCategory(this.value,\"2\")'");?>
            <?=CreateSelect('category_2','',0,80,"onChange='changeCategory(this.value,\"3\")'");?>
            <?=CreateSelect('category_3','',0,80,"onChange='changeCategory(this.value,\"4\")'");?>
            <?=CreateSelect('category_4','',0,80,"onChange='changeCategory(this.value,\"5\")'");?>
            <?=CreateSelect('category_5','',0,80,"onChange='changeCategory(this.value,\"6\")'");?>
            <?=CreateSelect('category_6','',0,80,"onChange='changeCategory(this.value,\"7\")'");?>
            <?=CreateSelect('category_7','',0,80);?>
		    <input type="submit" name="Submit" value="添加">		   　
		   	  </TD>
          </TR> </form>
          <?php }?>
        <TR>
          <TD height="543" colspan="3" valign="top" bgColor=#f8f9fc>
<?
   if ($i != 0)  //--------------if01--------------------
{
   $myrs_qq=mysql_query($sqlstr,$myconn);
   //echo $sqlstr2;
   $ii=$offset+1;
   $n=1;
?>
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr> 
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><table cellspacing="0" cellpadding="0" border="0" width="95%" align="center" style="word-break:break-all;" class="tableout">
<tr><td bgcolor="#DDE3EC">
<table width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#FFFFFF" border="1">
                                              <tr bgcolor="#ffffff"> 
                                                <?
   
   while ($rec=@mysql_fetch_array($myrs_qq))
   {
	   
	$image_path=($rec["imgpath"])?"../../upload/a_photo/s_".$rec["imgpath"]:"../../images/nopic.jpg";
   echo "<td width=17% valign=top>";
   echo "<form name=\"formedit\" method=\"post\" action=\"album_manage.php?action=edit&atype=".$atype."\"><input type='hidden' name='aid' id='aid' value='".$rec['aid']."'><div align=center class='p1 inline-block'><a href='/show_album_pic.php?ptype=".$ptype."&aid=".$rec["aid"]."' target=_blank><img src=$image_path alt=$image_path border=0 width=160 height=145></a>";
   echo "<br>"; 
   echo $rec['title'];
   echo "<br>";
   echo "<a title=管理 href='album_pic_manage.php?ptype=".$ptype."&aid=$rec[aid]'>管理</a>|<a title=编辑 href='album_manage.php?action=edit&ptype=".$ptype."&atype=".$atype."&aid=$rec[aid]'>编辑</a>|<a title=删除 href='album_manage.php?action=del&ptype=".$ptype."&atype=".$atype."&aid=$rec[aid]'>删除</a><br>"; 
   echo "</div></form></td>";
  if ($n%4==0)
  echo "</tr><tr bgcolor=#ffffff>";
  $n=$n+1;
  }
  @mysql_free_result($myrs_qq);
?>
                                              </tr>
                                            </table>

</td></tr></table>  </td>
              </tr>
            </table>
				</td>
              </tr>
            </table>
			<? } else { echo "没有信息";}?>
<?
//开始构建分页显示------------------------------------------------------ 
$start=$currentpage*$pagesize; 
$n=$totalpage;
 echo "<table width=95% border=0 cellspacing=0 cellpadding=0>";
 echo "<form method=Post action=$filename ><tr><td align=right height=25>";
 echo "查询结果：<b><font color=#ff0000>$i</font></b>个 ";
  if ($currentpage<2 )
    echo "首页 上一页 ";
  else
    echo "<a href=".$filename."&&currentpage=1>首页</a> <a href=".$filename."&&currentpage=".($currentpage-1).">上一页</a>  ";
  if ($n-$currentpage<1)
    echo " 下一页 尾页 ";
  else
    echo " <a href=".$filename."&&currentpage=".($currentpage+1).">下一页</a> <a href=".$filename."&&currentpage=$n>尾页</a> ";

   echo  "<strong><font color=#ff0000>$currentpage</font>/$n</strong>页  ";
   echo  "<b><font color=#ff0000>$pagesize</font></b>个/页 ";
   echo  " 转到：<input type='text' name='currentpage' size=2 maxlength=10 class=smallInput value='$currentpage'>";
   echo  "&nbsp;<input class=buttonface type='submit'  value='Go'  name='cndok'></td></tr></form></table>";
?>			
		  </TD>
		  </tr>
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
<script type="text/javascript" src="/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/js/picture_category.js"></script>

</body>
</html>
