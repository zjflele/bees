<? 
	include("include/include.php");
	$headerMenu = 'jdfx';
	$sqlstr_tt="select * from ".TABLEPRE."article where pass=1 ";
	$sqlstr_tt=$sqlstr_tt." and sort_f like '%|102|%'";
	$arrList = getlist($sqlstr_tt);
	//print_r($arrList);
	$arrPosId = array(3866=>1,3865=>2,3867=>3,3870=>4,3869=>5,3868=>6,3871=>7,3872=>8,3873=>9,3874=>10);
?>
<? 
	include("head.php");	
?>
 	<div class="ybTipBox">
        <strong class="ybTip">景点分析</strong>
    </div>
    <div class="ybMap3">
    	<div class="pos1"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">棠园春晓</span></div>
    	<div class="pos2"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">芦湖秋色</span></div>
        <div class="pos3"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">林荫曲径</span></div>
        <div class="pos4"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">山海雄关</span></div>
        <div class="pos5"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">榆关翠石</span></div>
        <div class="pos6"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">迎关松境</span></div>
        <div class="pos7"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">临楼问景</span></div>
        <div class="pos8"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">玉镜曲桥</span></div>
        <div class="pos9"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">莆田从樾</span></div>
		<div class="pos10"><span class="icoArrow"></span><span class="icoShadow"></span><span class="txt">菱荷夏月</span></div>
    </div>
    <div class="spaceBox"></div>
    
<? 
	include("foot.php");	
?>

</div>
<?php 
	foreach ($arrList as $article){
?>
<script type="text/tpml" id="js_tmp_pos<?=$arrPosId[$article['id']]?>">
<div class="ybPop">
    <strong class="ybPopTit"><?=$article['title']?></strong>
    <div class="ybPopCon" id="ybPopCon">
        <?=str_replace('color:#262626;','',$article['text'])?>
    </div>
	<b class="ybPopClose">X</b>
</div>
</script>
<?php } ?>

<script>
var pos = '';
(function(){
	// 640x452
	var ybMap3 = document.querySelector('.ybMap3'),
		spaceBox = document.querySelector('.spaceBox');
	
	function Fnresize(){
		var clientWidth = document.documentElement.clientWidth;
		ybMap3.style.WebkitTransform = 'scale('+clientWidth/320+','+clientWidth/320+')';
		
		spaceBox.style.height = Math.ceil((Math.ceil(452*clientWidth/320) - 452)/2) + 24 + 'px';
	}
	Fnresize();
	
	window.addEventListener('resize',function(ev){	
		Fnresize();
	},false);
	
	var clientWidth = document.documentElement.clientWidth -60;
	
	ybMap3.addEventListener('click',function(ev){
		var re = /pos\d+/g;
		var obj = null;
		if(re.test(ev.target.className)){
			obj = (ev.target.className.match(re))
			pos = ev.target.className;
		} else if(re.test(ev.target.parentNode.className)){
			obj = (ev.target.parentNode.className.match(re));
			pos = ev.target.parentNode.className;
		}
		if(obj)
		{
			var tmp = document.createElement('div');
			
			tmp.id = 'js_temp';
			tmp.innerHTML = document.getElementById('js_tmp_'+pos).text;
				
			if(document.getElementById('js_temp')){	
				document.body.removeChild(document.getElementById('js_temp'));	
			}
			
			if(!document.getElementById('js_temp')){
				document.body.appendChild(tmp);
				
				setTimeout(function(){
					document.querySelector('.ybPop').classList.add('animateBig');
					document.body.style.height = document.querySelector('.ybPop').offsetHeight + document.body.offsetHeight*0.34 + 'px';
				},100);
			}
			
			
		}
		resizeImg('js_temp',clientWidth);
	},false);
	
	document.body.addEventListener('touchend', function(ev){
		
		if(ev.target.className == 'ybPopClose')
		{
			
			document.body.removeChild(document.getElementById('js_temp'));
			document.body.style.height = '';
		}
	},false);
	
})();

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


</script>
</body>
</html>



