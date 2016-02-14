<? 
	include("include/include.php");
	checklogin();
	$headerMenu = 'index';
	$arr = getlist("select * from ".TABLEPRE."index_set where fid<5 order by fid asc");	
	
	foreach ($arr as $v){
		$arrResult[$v['fid']] = $v;
		if ($v['sid'] && $v['ftype']==1){//文章版块
			$arrResult[$v['fid']]['flink'] = "list_news.php?sortid=".$v['sid'];				
			$arrResult[$v['fid']]['news'] = getlist("select id,title,concat('show_article.php?id=',id) as alink,date from ".TABLEPRE."article where pass=1 and sort_f like '%|".$v['sid']."|%' order by date desc,id desc  limit 0,".$v['rownum']);
		}elseif ($v['ftype']==3){//最新消息
			$arrResult[$v['fid']]['flink'] = "list_news.php";
			$arrResult[$v['fid']]['news'] = getlist("select id,title,concat('show_article.php?id=',id) as alink,date from ".TABLEPRE."article where pass=1  order by date desc,id desc  limit 0,".$v['rownum']);
		}elseif ($v['ftype']==4){ //图文版块(新闻类型)
			$arrResult[$v['fid']]['news'] = getlist("select id,title,concat('show_article.php?id=',id) as alink,date from ".TABLEPRE."article where pass=1 and sort_f like '%|".$v['sid']."|%' order by date desc,id desc  limit 0,".$v['rownum']);
		}elseif ($v['ftype']==5){ //图文版块(图片类型)
			$arrResult[$v['fid']]['news'] = getlist("select id,title,concat('list_pic.php?action=show&id=',id) as alink from ".TABLEPRE."picture where ptype=".$v['sid']." order by showtime desc,id desc  limit 0,".$v['rownum']);
		}elseif ($v['ftype']==6){ //图文版块(纯手工编辑类型)
			$arrResult[$v['fid']]['fcontent'] = unserialize($arrResult[$v['fid']]['fcontent']);
		}
	}
	//print_r($arrResult);
?>
<? 
	include("head.php");	
?>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/nyroModal/jquery.nyroModal.pack.js"></script>
<link href="/js/nyroModal/nyroModal.css" rel="stylesheet" type="text/css" />

 <ul class="ybImgLs">
    	<li class="item0"><a href="<?=$arrResult[1]['fcontent']['img_left_plink']?>"><img src="upload/images/<?=$arrResult[1]['img_left']?>" width="100%" height="120"><b><?=$arrResult[1]['fcontent']['img_left_text']?></b></a><a href="./admin/index_set/html_picture_2_set.php?id=1" target="_blank" class="nyroModal STYLE1">[设置]</a></li>
        <li class="item1"><a href="<?=$arrResult[2]['fcontent']['img_left_plink']?>"><img src="upload/images/<?=$arrResult[2]['img_left']?>" width="100%" height="120"><b><?=$arrResult[2]['fcontent']['img_left_text']?></b></a><a href="./admin/index_set/html_picture_2_set.php?id=2" target="_blank" class="nyroModal STYLE1">[设置]</a></li>
        <li class="item2"><a href="<?=$arrResult[3]['fcontent']['img_left_plink']?>"><img src="upload/images/<?=$arrResult[3]['img_left']?>" width="100%" height="120"><b><?=$arrResult[3]['fcontent']['img_left_text']?></b></a><a href="./admin/index_set/html_picture_2_set.php?id=3" target="_blank" class="nyroModal STYLE1">[设置]</a></li>
        <li class="item3"><a href="<?=$arrResult[4]['fcontent']['img_left_plink']?>"><img src="upload/images/<?=$arrResult[4]['img_left']?>" width="100%" height="120"><b><?=$arrResult[4]['fcontent']['img_left_text']?></b></a><a href="./admin/index_set/html_picture_2_set.php?id=4" target="_blank" class="nyroModal STYLE1">[设置]</a></li>
    </ul>
    
    
<? 
	include("foot.php");	
?>

</div>

</body>
</html>



