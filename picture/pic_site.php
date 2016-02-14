<? include("../include/include.php");
$siteid =  intval($_GET['siteid']);
$username = $db->getOne("select username from brick_users where userid=".$siteid);
$piclist = getlist("select * from site_news  where siteid=$siteid and is_pic=1 order by addtime desc limit 0,5");
if (count($piclist)<5) die("此处最少要设置五条焦点图新闻");
?>
<style>
.f14b{width:200px;text-align:center;margin:0 auto;padding:0;}
</style>
<a target=_self href="javascript:goUrl()" align=center> 
			<span class="f14b">
			<script type="text/javascript">
			<? foreach($piclist as $k => $rec) {
			   $i+=1;
			   $nbsp="";
			   $isn = 0;
			   $nl = 0;
			   if (strlen($rec[title])>30)
			   {			   
			   $title=mysubstr($rec[title],0,30,$isn)."<br />";
			   if ($isn%2==1) $nl=1;		   
			   $num=(mb_strlen($rec[title],'gb2312')-(15+$nl*3))*2;
			   $num=(30-$num)/2;			  
			   for ($n=1;$n<=$num;$n++)
			   {$nbsp.="&nbsp;&nbsp;";}			   
			   $title.=$nbsp.mysubstr($rec[title],30+$nl,30).$nbsp;
			   }
			   else
			   {
			   		$title=$rec[title];
			   }
			   echo "imgUrl$i=\"../upload/site/$rec[pic_address]\";
			         imgtext$i=\"$title\";
			         imgLink$i=escape(\"/$username/?ac=show_new&id=$rec[nid]\");";
			    }
			?>	
				
			var focus_width=200
			var focus_height=129
			var text_height=35
			var swf_height = focus_height+text_height
			
			var pics=imgUrl1+"|"+imgUrl2+"|"+imgUrl3+"|"+imgUrl4+"|"+imgUrl5
			var links=imgLink1+"|"+imgLink2+"|"+imgLink3+"|"+imgLink4+"|"+imgLink5
			var texts=imgtext1+"|"+imgtext2+"|"+imgtext3+"|"+imgtext4+"|"+imgtext5
			document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase=http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6?0?0?0 width="'+ focus_width +'" height="'+ swf_height +'">');
			document.write('<param name="allowScriptAccess" value="sameDomain"><param name="movie" value="images/focus.swf"><param name="quality" value="high"> <param name="bgcolor" value="#F0F0F0">');
			document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
			document.write('<param name="FlashVars" value="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight=' +focus_height+'&textheight='+text_height+'">');
			document.write('<embed src="images/pixviewer.swf" align="middle" wmode="opaque" FlashVars="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight= '+focus_height+'&textheight='+text_height+'" menu="false" bgcolor="#F0F0F0" quality="high" width ="'+ focus_width +'" height="'+ focus_height +'" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />'); document.write('</object>');
			</script>
			</span></a><span id=focustext class="f14b"> </span>