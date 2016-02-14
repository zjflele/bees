var curSelectNav,selectNav;
function commonNavSelect(o){
	if(!$('#fpnav i').width()){
		curSelectNav = o;
		$('#fpnav i').css({'width':o.outerWidth(),'left':o.position().left});
	}else{
		$('#fpnav i').stop().animate({'width':o.outerWidth(),'left':o.position().left},200);
	}
}
$(function(){
	$('.fpnav a:first,.fpnewlist li:last,.Forum li:last,.xgts li:last,.newsL li:last').css('border','none');
	$('.InveCon li:last,.videoR dl:last').css('background','none');
	$('#fpnav > a').hover(function(){
		selectNav = selectNav || curSelectNav || 1;
		commonNavSelect($(this));
	},function(){
		commonNavSelect(curSelectNav);
	});
	$('#fpnav').mouseleave(function(){
		if(selectNav == 1) $('#fpnav i').stop().css({'width':0});
	});
});


function newtabs(se,ll,llnum,cur,prev,next,stopimg){
		var $obj=jQuery(se);//所用标签
		var len=$obj.length;//个数
		var divs="";
		var c=1;
		for(n=1;n<=len;n++){n==1?divs+=llnum+n:divs+=","+llnum+n;};
		function showDiv($num){
			$obj.removeClass(cur);
			$(ll).find(divs).hide();
			jQuery($obj.get($num-1)).addClass(cur);
			var _src = $(ll).find(llnum+$num).find('img').attr('load');
			_src && $(ll).find(llnum+$num).find('img').attr('src',_src).removeAttr('load');
			$(ll).find(llnum+$num).show();
		};
		$obj.each(function(i){
			jQuery(this).mouseover(function(){
				c=i+1;showDiv(c);
			});
		});
		var interval=setInterval(function() {
						c++;c>len?c=1:c;showDiv(c);
					}, 7000);
		if(stopimg){
				$(stopimg).mouseover(function(){
				 clearInterval(interval);
				}).mouseout(function(){
					  interval=setInterval(function() {
						c++;c>len?c=1:c;showDiv(c);
					}, 7000);
				});
			}
	}
$(".brandRfocus").each(function(){
		var _objthis=$(this);
		fnum(_objthis);	
		});
	function fnum(thobj){
		var thobj=thobj;
		$(thobj).find('img').each(function(){
			$(this).addClass("pimg");
		})
		var arr=$(thobj).find('a');
		var thelength=$(thobj).find('img').length;
		if(thelength==0){
			$(thobj).hide();
		}
		else if(thelength==1)
		{
			$(thobj).find('a').each(function(){$(this).css("display","block");});
		}
		else
		{
			$(thobj).append('<ul class="bq"></ul>');
			for(var i=0;i<thelength;i++)
			{	
				var thenum=i+1; 
				var theid="pimg"+thenum;
				$(arr[i]).attr("class",theid);
				if(i==0)
				{
					$(arr[i]).css("display","block");			
					$(thobj).find('.bq').append("<li class='pimg cur'></li>");
				}
				else
				{
					$(arr[i]).css("display","none");
					$(thobj).find(".bq").append("<li class='pimg'></li>");
				}
			}
			var these=$(thobj).find(".bq li");
			var thell=$(thobj);
			newtabs(these,thell,'.pimg',"cur","","",".pimg");
			$(thobj).find(".bq").show();	
		}
	}
	
	//图片滚动列表
var Speed = 15; //速度(毫秒)
var Space = 20; //每次移动(px)
var PageWidth = 178; //翻页宽度
var fill = 0; //整体移位
var MoveLock = false;
var MoveTimeObj;
var Comp = 0;
var AutoPlayObj = null;
if($('#List2').length>0 && $('#List1').length>0)
{
GetObj("List2").innerHTML = GetObj("List1").innerHTML;
}
if($('#ISL_Cont').length>0)
{
GetObj('ISL_Cont').scrollLeft = fill;
GetObj("ISL_Cont").onmouseover = function(){clearInterval(AutoPlayObj);}
GetObj("ISL_Cont").onmouseout = function(){AutoPlay();}
AutoPlay();
}
function GetObj(objName){if(document.getElementById){return eval('document.getElementById("'+objName+'")')}else{return eval('document.all.'+objName)}}
function AutoPlay(){ //自动滚动
clearInterval(AutoPlayObj);
AutoPlayObj = setInterval('ISL_GoDown();ISL_StopDown();',10000); //间隔时间
}
function ISL_GoUp(){ //上翻开始

if(MoveLock) return;
clearInterval(AutoPlayObj);
MoveLock = true;
MoveTimeObj = setInterval('ISL_ScrUp();',Speed);
}
function ISL_StopUp(){ //上翻停止
clearInterval(MoveTimeObj);
if(GetObj('ISL_Cont').scrollLeft % PageWidth - fill != 0){
Comp = fill - (GetObj('ISL_Cont').scrollLeft % PageWidth);
CompScr();
}else{
MoveLock = false;
}
AutoPlay();
}

function ISL_ScrUp(){ //上翻动作
if(GetObj('ISL_Cont').scrollLeft <= 0){GetObj('ISL_Cont').scrollLeft = GetObj('ISL_Cont').scrollLeft + GetObj('List1').offsetWidth}
GetObj('ISL_Cont').scrollLeft -= Space ;
}


function ISL_GoDown(){ //下翻
clearInterval(MoveTimeObj);
if(MoveLock) return;
clearInterval(AutoPlayObj);
MoveLock = true;
ISL_ScrDown();
MoveTimeObj = setInterval('ISL_ScrDown()',Speed);
}

function ISL_StopDown(){ //下翻停止
clearInterval(MoveTimeObj);
if(GetObj('ISL_Cont').scrollLeft % PageWidth - fill != 0 ){
Comp = PageWidth - GetObj('ISL_Cont').scrollLeft % PageWidth + fill;
CompScr();
}else{
MoveLock = false;
}
AutoPlay();
}

function ISL_ScrDown(){ //下翻动作
if(GetObj('ISL_Cont').scrollLeft >= GetObj('List1').scrollWidth){GetObj('ISL_Cont').scrollLeft = GetObj('ISL_Cont').scrollLeft - GetObj('List1').scrollWidth;}
GetObj('ISL_Cont').scrollLeft += Space ;
}

function CompScr(){
var num;
if(Comp == 0){MoveLock = false;return;}
if(Comp < 0){ //上翻
if(Comp < -Space){
   Comp += Space;
   num = Space;
}else{
   num = -Comp;
   Comp = 0;
}
GetObj('ISL_Cont').scrollLeft -= num;
setTimeout('CompScr()',Speed);
}else{ //下翻
if(Comp > Space){
   Comp -= Space;
   num = Space;
}else{
   num = Comp;
   Comp = 0;
}
GetObj('ISL_Cont').scrollLeft += num;
setTimeout('CompScr()',Speed);
}
};
//视频滚动列表
var Speed2 = 15; //速度(毫秒)
var Space2 = 20; //每次移动(px)
var PageWidth2 = 178; //翻页宽度
var fill2 = 0; //整体移位
var MoveLock2 = false;
var MoveTimeObj2;
var Comp2 = 0;
var AutoPlayObj2 = null;
if($('#List4').length>0 && $('#List3').length>0)
{
	GetObj("List4").innerHTML = GetObj("List3").innerHTML;
}
if($('#ISL_Cont2').length>0)
{
GetObj('ISL_Cont2').scrollLeft = fill2;
GetObj("ISL_Cont2").onmouseover = function(){clearInterval(AutoPlayObj2);}
GetObj("ISL_Cont2").onmouseout = function(){AutoPlay2();}
AutoPlay2();
}
function AutoPlay2(){ //自动滚动
clearInterval(AutoPlayObj);
AutoPlayObj2 = setInterval('ISL_GoDown2();ISL_StopDown2();',10000); //间隔时间
}
function ISL_GoUp2(){ //上翻开始

if(MoveLock2) return;
clearInterval(AutoPlayObj2);
MoveLock2 = true;
MoveTimeObj2 = setInterval('ISL_ScrUp2();',Speed2);
}
function ISL_StopUp2(){ //上翻停止
clearInterval(MoveTimeObj2);
if(GetObj('ISL_Cont2').scrollLeft % PageWidth2 - fill2 != 0){
Comp2 = fill2 - (GetObj('ISL_Cont2').scrollLeft % PageWidth2);
CompScr2();
}else{
MoveLock2 = false;
}
AutoPlay2();
}

function ISL_ScrUp2(){ //上翻动作
if(GetObj('ISL_Cont2').scrollLeft <= 0){GetObj('ISL_Cont2').scrollLeft = GetObj('ISL_Cont2').scrollLeft + GetObj('List3').offsetWidth}
GetObj('ISL_Cont2').scrollLeft -= Space2 ;
}


function ISL_GoDown2(){ //下翻
clearInterval(MoveTimeObj2);
if(MoveLock2) return;
clearInterval(AutoPlayObj2);
MoveLock2 = true;
ISL_ScrDown2();
MoveTimeObj2 = setInterval('ISL_ScrDown2()',Speed2);
}

function ISL_StopDown2(){ //下翻停止
clearInterval(MoveTimeObj2);
if(GetObj('ISL_Cont2').scrollLeft % PageWidth2 - fill2 != 0 ){
Comp2 = PageWidth2 - GetObj('ISL_Cont2').scrollLeft % PageWidth2 + fill2;
CompScr2();
}else{
MoveLock2 = false;
}
AutoPlay2();
}

function ISL_ScrDown2(){ //下翻动作
if(GetObj('ISL_Cont2').scrollLeft >= GetObj('List3').scrollWidth){GetObj('ISL_Cont2').scrollLeft = GetObj('ISL_Cont2').scrollLeft - GetObj('List3').scrollWidth;}
GetObj('ISL_Cont2').scrollLeft += Space2 ;
}

function CompScr2(){
var num;
if(Comp2 == 0){MoveLock2 = false;return;}
if(Comp2 < 0){ //上翻
if(Comp2 < -Space2){
   Comp2 += Space2;
   num = Space2;
}else{
   num = -Comp2;
   Comp2 = 0;
}
GetObj('ISL_Cont2').scrollLeft -= num;
setTimeout('CompScr2()',Speed2);
}else{ //下翻
if(Comp2 > Space2){
   Comp2 -= Space2;
   num = Space2;
}else{
   num = Comp2;
   Comp2 = 0;
}
GetObj('ISL_Cont2').scrollLeft += num;
setTimeout('CompScr2()',Speed2);
}
};

// 字体大小
function doZoom(size)
{
	$('.newsbody').css('fontSize',size);
}
//视频
$('.videoR dl').hover(function(){
	$(this).find('dd').addClass('Hauto');
},function(){
	$(this).find('dd').removeClass('Hauto');
});

//图片滚动列表
// JavaScript Document
function $i(id){return document.getElementById(id);}

// 横着滚动
function simpleSideScroll(c,ul,config,direction){
    this.config = config ? config : {start_delay:3000, speed: 23, delay:4000, scrollItemCount:1};
	//基本设置：开始延时：3000；速度23；移动后延时：4000；滚动数值：1
	this.c = $i(c);
	//获取外面的大div
	this.ul = $i(ul);
	//获取滚动li标签外的ul
	this.direction = direction ? direction : "left";
	//开始默认向左滚动不暂停
	this.pause = false;
	//开始默认跑动
	//新建一个buttonlist对象
	this.buttonlist= new Object();
	
	this.delayTimeId=null;
	
	var _this = this;
	this.c.onmouseover=function(){_this.pause = true;}
	//鼠标悬浮在div上就停止滚动
	this.c.onmouseout=function(){_this.pause = false;}
	//鼠标移开div就继续滚动
	this.init = function() {
		_this.scrollTimeId = null;
		setTimeout(_this.start,_this.config.start_delay);
	}
	
	this.start = function() {
		var d = _this.c;
		var width = d.getElementsByTagName('li')[0].offsetWidth;
		if(d.scrollWidth-d.offsetLeft>=width) _this.scrollTimeId = setInterval(_this.scroll,_this.config.speed)
	};
	
	this.scroll = function() {
		if(_this.pause)return;
		var ul= _this.ul;
		var d = _this.c;
		var width = d.getElementsByTagName('li')[0].offsetWidth;
		if(_this.direction == 'left'){
	        d.scrollLeft += 2;
	        if(d.scrollLeft%(width*_this.config.scrollItemCount)<=1){
		        if(_this.config.movecount != undefined)
			        for(var i=0;i<_this.config.movecount;i++){ul.appendChild(ul.getElementsByTagName('li')[0]);}
		        else for(var i=0;i<_this.config.scrollItemCount;i++){ul.appendChild(ul.getElementsByTagName('li')[0]);}
		        d.scrollLeft=0;
		        clearInterval(_this.scrollTimeId);
		        
		        _this.delayTimeId=setTimeout(_this.start,_this.config.delay);
	        }
		}
		else {
		    if(d.scrollLeft==0)
		    {
		        var lis=ul.getElementsByTagName('li');
		        for(var i=0;i<_this.config.scrollItemCount;i++){
		            ul.insertBefore(lis[lis.length-1],lis[0]);
		        }
		        d.scrollLeft = width;
		    }
		    d.scrollLeft -= 2;
		    if(d.scrollLeft%(width*_this.config.scrollItemCount)<=1){
		        d.scrollLeft=0;
		        clearInterval(_this.scrollTimeId);
		        _this.delayTimeId=setTimeout(_this.start,_this.config.delay);
		    }
		}
	}
	
	this.setButton=function(id,direction){
	    if($i(id)){
	        var c=$i(id);
	        var buttonlist =_this.buttonlist;
	        if(buttonlist[id] == undefined){
	            buttonlist[id] =new Object();
	            _this.buttonlist[id][0]=c;
	            _this.buttonlist[id][1]=direction;
	            
	            c.onclick=function(){
	                 clearInterval(_this.scrollTimeId);
	                 
	                var dir=_this.buttonlist[this.id][1];
	                var d = _this.c;
	                var ul= _this.ul;
	                d.scrollLeft=0;
	                if(dir =="left")
	                {
	                    for(var i=0;i<_this.config.scrollItemCount;i++){ul.appendChild(ul.getElementsByTagName('li')[0]);}
	                }
	                else{
	                    var lis=ul.getElementsByTagName('li');
		                for(var i=0;i<_this.config.scrollItemCount;i++){
		                    ul.insertBefore(lis[lis.length-1],lis[0]);
		                }
	                }
	                    
	                _this.direction= dir;
	                clearTimeout(_this.delayTimeId);
	                _this.delayTimeId=setTimeout(_this.start,_this.config.delay);
	                return false;
	            }
	        }
	    }
	}
}

var cooperater_run;/*banners,*/
var cooperater_run1;
function init_load(){
/*    if ($i('banners')) {
		banners = new tabswitch('banners', {});
		setInterval("banners.start(null, null, 1);", 6000);
	}*/
    if($i('cooperater_scroll')){
	    cooperater_run=new simpleSideScroll('cooperater_scroll','cooperater_scroll_ul',{start_delay:1000, speed: 30, delay:0, scrollItemCount:1},'left')
	    cooperater_run.setButton('cooperater_scroll_left','left');
	    cooperater_run.setButton('cooperater_scroll_right','right');
	    cooperater_run.init();
	}
	
	if($i('cooperater_scroll1')){
	    cooperater_run1=new simpleSideScroll('cooperater_scroll1','cooperater_scroll_ul1',{start_delay:1000, speed: 30, delay:0, scrollItemCount:1},'left')
	    cooperater_run1.setButton('cooperater_scroll_left1','left');
	    cooperater_run1.setButton('cooperater_scroll_right1','right');
	    cooperater_run1.init();
	}
}
if(window.attachEvent){
    window.attachEvent("onload",init_load);
}else if(window.addEventListener){
    window.addEventListener("load",init_load,false);
}