<?        
	include("include/include.php");
        
	$headerMenu = 'index';
	$arr = getlist("select * from ".TABLEPRE."index_set where fid<5 order by fid asc");	
	
	foreach ($arr as $v){
		$arrResult[$v['fid']] = $v;
		if ($v['sid'] && $v['ftype']==1){//���°��
			$arrResult[$v['fid']]['flink'] = "list_news.php?sortid=".$v['sid'];				
			$arrResult[$v['fid']]['news'] = getlist("select id,title,concat('show_article.php?id=',id) as alink,date from ".TABLEPRE."article where pass=1 and sort_f like '%|".$v['sid']."|%' order by date desc,id desc  limit 0,".$v['rownum']);
		}elseif ($v['ftype']==3){//������Ϣ
			$arrResult[$v['fid']]['flink'] = "list_news.php";
			$arrResult[$v['fid']]['news'] = getlist("select id,title,concat('show_article.php?id=',id) as alink,date from ".TABLEPRE."article where pass=1  order by date desc,id desc  limit 0,".$v['rownum']);
		}elseif ($v['ftype']==4){ //ͼ�İ��(��������)
			$arrResult[$v['fid']]['news'] = getlist("select id,title,concat('show_article.php?id=',id) as alink,date from ".TABLEPRE."article where pass=1 and sort_f like '%|".$v['sid']."|%' order by date desc,id desc  limit 0,".$v['rownum']);
		}elseif ($v['ftype']==5){ //ͼ�İ��(ͼƬ����)
			$arrResult[$v['fid']]['news'] = getlist("select id,title,concat('list_pic.php?action=show&id=',id) as alink from ".TABLEPRE."picture where ptype=".$v['sid']." order by showtime desc,id desc  limit 0,".$v['rownum']);
		}elseif ($v['ftype']==6){ //ͼ�İ��(���ֹ��༭����)
			$arrResult[$v['fid']]['fcontent'] = unserialize($arrResult[$v['fid']]['fcontent']);
		}
	}
?>
<? 
	include("head.php");	
?>
 	<ul class="ybImgLs">
    	<li class="item0"><a href="<?=$arrResult[1]['fcontent']['img_left_plink']?>"><img src="upload/images/<?=$arrResult[1]['img_left']?>" width="100%" height="120"><b><?=$arrResult[1]['fcontent']['img_left_text']?></b></a></li>
        <li class="item1"><a href="<?=$arrResult[2]['fcontent']['img_left_plink']?>"><img src="upload/images/<?=$arrResult[2]['img_left']?>" width="100%" height="120"><b><?=$arrResult[2]['fcontent']['img_left_text']?></b></a></li>
        <li class="item2"><a href="<?=$arrResult[3]['fcontent']['img_left_plink']?>"><img src="upload/images/<?=$arrResult[3]['img_left']?>" width="100%" height="120"><b><?=$arrResult[3]['fcontent']['img_left_text']?></b></a></li>
        <li class="item3"><a href="<?=$arrResult[4]['fcontent']['img_left_plink']?>"><img src="upload/images/<?=$arrResult[4]['img_left']?>" width="100%" height="120"><b><?=$arrResult[4]['fcontent']['img_left_text']?></b></a></li>
    </ul>  
<? 
	include("foot.php");	
?>

</div>

</body>
</html>



