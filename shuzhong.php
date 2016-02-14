<? 
	include("include/include.php");
	$headerMenu = 'weizhi';
	$sqlstr_tt="select * from ".TABLEPRE."article where pass=1 ";
	$sqlstr_tt=$sqlstr_tt." and sort_f like '%|101|%'";
	$arrList = getlist($sqlstr_tt);
?>
<? 
	include("head.php");	
?>
  <div class="ybTipBox">
    	<strong class="ybTip"> ˜÷÷ΩÈ…‹</strong>
    </div>
    <ul class="ybImgLs2">
    <?php 
		foreach ($arrList as $article){
	?>
    	<li><a href="show_article.php?id=<?=$article['id']?>"><img src="upload/images/<?=$article['imagearticle']?>" width="100%"><b><?=$article['title']?></b></a></li>
    <?php } ?>
       
    </ul>
    
    <a href="javascript:void(0);" class="returnTop" onClick="window.scrollTo(0,0);">&nbsp;</a>
<? 
	include("foot.php");	
?>

</div>

</body>
</html>



