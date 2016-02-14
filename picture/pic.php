<? include("../include/include.php");
$sqlstr="select * from ".TABLEPRE."index_img where id<>'' order by id desc limit 0,5";
$myrs=mysql_query($sqlstr,$myconn);
?>
<style>
.f14b{width:200px;text-align:center;margin:0 auto;padding:0;}
</style>
<a target=_self href="javascript:goUrl()" align=center> 
			<span class="f14b">
			<script type="text/javascript">
			<? while($rec=mysql_fetch_array($myrs)) {
			   $i+=1;
			   /*
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
			   */
			   $title=$rec[title];
			   echo "imgUrl$i=\"../upload/images/$rec[imgpath]\";
			         imgtext$i=\"$title\";
			         imgLink$i=escape(\"$rec[linkpath]\");";
			    }
			?>		
			var focus_width=375
			var focus_height=226
			var text_height=55
			var swf_height = focus_height+text_height
			var pics=imgUrl1
			var links=imgLink1
			var texts=imgtext1
			<?php
			for($j=2;$j<=$i;$j++){
				?>
			pics=pics+"|"+imgUrl<?=$j?>;
			links=links+"|"+imgLink<?=$j?>;
			texts=texts+"|"+imgtext<?=$j?>;
				<?
			}
			?>
			
			document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase=http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6?0?0?0 width="'+ focus_width +'" height="'+ swf_height +'">');
			document.write('<param name="allowScriptAccess" value="sameDomain"><param name="movie" value="images/focus.swf"><param name="quality" value="high"> <param name="bgcolor" value="#F0F0F0">');
			document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
			document.write('<param name="FlashVars" value="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight=' +focus_height+'&textheight='+text_height+'">');
			document.write('<embed src="images/pixviewer.swf" align="middle" wmode="opaque" FlashVars="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight= '+focus_height+'&textheight='+text_height+'" menu="false" bgcolor="#F0F0F0" quality="high" width ="'+ focus_width +'" height="'+ focus_height +'" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />'); document.write('</object>');
			</script>
			</span></a><span id=focustext class="f14b"> </span>