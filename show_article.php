<?php
	include("include/include.php");
	$id = intval($_GET['id']);	
	
	$sqlstr="SELECT * FROM ".TABLEPRE."article WHERE id=$id";
	$arrArticle = getrow($sqlstr);
		
	if (!$arrArticle){
		header("location:error.php");
		exit;
	}
	
	//累计计数;
	if ($arrArticle){
		$db->query("UPDATE ".TABLEPRE."article SET counts=counts+1 WHERE id=$arrArticle[id]"); 
	}
	
	
	if ($arrArticle["url"]<>'')
	{
		header("location:$arrArticle[url]");
		exit;
	}
	if ($id==3864){
		$headerMenu = 'sjsm';	
	}
	//print_r($arrArticle);	
?>
<? 	include("head.php");?>
<div class="ybTipBox">
        <strong class="ybTip"><?=$arrArticle['title']?></strong>
        <a href="javascript:void(0);" class="btnReturn" onClick="history.go(-1)">返回</a>
    </div>
    <article class="ybInfo" id="article_content">
        <?=$arrArticle['text']?>
    </article>
    
<? include("foot.php");?>

</div>
<script language="javascript">
//缩小图片并添加链接
function resizeImg(id,size) {
	var theImages = document.getElementById(id).getElementsByTagName('img');
	for (i=0; i<theImages.length; i++) {
		theImages[i].onload = function() {
			if (this.width > size) {
				this.style.width = size + 'px';
				if (this.parentNode.tagName.toLowerCase() != 'a') {
					var zoomDiv = document.createElement('div');
					this.parentNode.insertBefore(zoomDiv,this);
					zoomDiv.appendChild(this);
					zoomDiv.style.position = 'relative';
					zoomDiv.style.cursor = 'pointer';
					
					this.title = '点击图片，在新窗口显示原始尺寸';
					/*
					var zoom = document.createElement('img');
					zoom.src = '/images/zoom.gif';
					zoom.style.position = 'absolute';
					zoom.style.marginLeft = size -28 + 'px';
					zoom.style.marginTop = '5px';
					zoom.style.display = 'none';
					this.parentNode.insertBefore(zoom,this);
					*/
					
					zoomDiv.onmouseover = function() {
						//zoom.src = '/images/zoom_h.gif';
					}
					zoomDiv.onmouseout = function() {
						//zoom.src = '/images/zoom.gif';
					}
					zoomDiv.onclick = function() {
						window.open(this.childNodes[0].src);
					}
				}
			}
		}
	}
}
var clientWidth = document.documentElement.clientWidth -50;
resizeImg('article_content',clientWidth);
</script>
</body>
</html>