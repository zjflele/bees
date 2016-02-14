<?php
include("include.php");
$arrLeftList = getlist("SELECT id,title,date FROM brick_article WHERE  pass=1 ORDER BY counts DESC LIMIT 0,11");
if ($isSameNew){
	$arrSameNew = getlist("SELECT id,title,date FROM brick_article WHERE  pass=1 AND id!=$arrArticle[id] AND sort_id=$arrArticle[sort_id] ORDER BY date DESC LIMIT 0,10");
}
?>
<div id="top_right3">
          <h1>文章搜索</h1>
        </div>
        <div id="box_5">
          <div id="box_cur1" style="height:60px;padding:0 10px;">
		  <form name="formsearch" action="../href.php" method="post" target="_blank">
           <input type="text" id="keywords" name="keywords" style="width:150px;"/>
           <select id="selectsearch" name="selectsearch">
              <option value="article" selected>站内文章搜索</option>                      
			  <option value="s_fg">政策法规搜索</option>
			  <option value="buysell">供求信息搜索</option>
			  <option value="video">视频点播搜索</option>
			  <option value="report">林业统计数据</option>
			  <option value="book">林业报刊</option>
            </select>
            <input type="image"  class="mml" src="images/search.jpg" />
		</form>
          </div>
        </div>
        
        <div id="top_right2">
          <h1>热点新闻</h1>
        </div>
        <div id="box_left">
          <div id="box_cur1">
		  <?php foreach ($arrLeftList as $k => $v) {?>
            <p><a href="showarticle.php?id=<?=$v['id']?>" title="<?=$v['title']?>" target="_blank"><?=getsubtext($v['title'],11)?></a></p>
		  <?php }?>           
          </div>
        </div>
		<?php if ($isSameNew){?>
		<div id="top_right2">
          <h1>相关链接</h1>
        </div>
        <div id="box_left">
          <div id="box_cur1">
		  <?php foreach ($arrSameNew as $k => $v) {?>
            <p><a href="showarticle.php?id=<?=$v['id']?>" title="<?=$v['title']?>" target="_blank"><?=getsubtext($v['title'],11)?></a></p>
		  <?php }?>           
          </div>
        </div>
		<?php }?>  