	//ͼƬ�����б�
var Speed = 15; //�ٶ�(����)
var Space = 20; //ÿ���ƶ�(px)
var PageWidth = 178; //��ҳ���
var fill = 0; //������λ
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
function AutoPlay(){ //�Զ�����
clearInterval(AutoPlayObj);
AutoPlayObj = setInterval('ISL_GoDown();ISL_StopDown();',10000); //���ʱ��
}
function ISL_GoUp(){ //�Ϸ���ʼ

if(MoveLock) return;
clearInterval(AutoPlayObj);
MoveLock = true;
MoveTimeObj = setInterval('ISL_ScrUp();',Speed);
}
function ISL_StopUp(){ //�Ϸ�ֹͣ
clearInterval(MoveTimeObj);
if(GetObj('ISL_Cont').scrollLeft % PageWidth - fill != 0){
Comp = fill - (GetObj('ISL_Cont').scrollLeft % PageWidth);
CompScr();
}else{
MoveLock = false;
}
AutoPlay();
}

function ISL_ScrUp(){ //�Ϸ�����
if(GetObj('ISL_Cont').scrollLeft <= 0){GetObj('ISL_Cont').scrollLeft = GetObj('ISL_Cont').scrollLeft + GetObj('List1').offsetWidth}
GetObj('ISL_Cont').scrollLeft -= Space ;
}


function ISL_GoDown(){ //�·�
clearInterval(MoveTimeObj);
if(MoveLock) return;
clearInterval(AutoPlayObj);
MoveLock = true;
ISL_ScrDown();
MoveTimeObj = setInterval('ISL_ScrDown()',Speed);
}

function ISL_StopDown(){ //�·�ֹͣ
clearInterval(MoveTimeObj);
if(GetObj('ISL_Cont').scrollLeft % PageWidth - fill != 0 ){
Comp = PageWidth - GetObj('ISL_Cont').scrollLeft % PageWidth + fill;
CompScr();
}else{
MoveLock = false;
}
AutoPlay();
}

function ISL_ScrDown(){ //�·�����
if(GetObj('ISL_Cont').scrollLeft >= GetObj('List1').scrollWidth){GetObj('ISL_Cont').scrollLeft = GetObj('ISL_Cont').scrollLeft - GetObj('List1').scrollWidth;}
GetObj('ISL_Cont').scrollLeft += Space ;
}

function CompScr(){
var num;
if(Comp == 0){MoveLock = false;return;}
if(Comp < 0){ //�Ϸ�
if(Comp < -Space){
   Comp += Space;
   num = Space;
}else{
   num = -Comp;
   Comp = 0;
}
GetObj('ISL_Cont').scrollLeft -= num;
setTimeout('CompScr()',Speed);
}else{ //�·�
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
//��Ƶ�����б�
var Speed2 = 15; //�ٶ�(����)
var Space2 = 20; //ÿ���ƶ�(px)
var PageWidth2 = 178; //��ҳ���
var fill2 = 0; //������λ
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
function AutoPlay2(){ //�Զ�����
clearInterval(AutoPlayObj);
AutoPlayObj2 = setInterval('ISL_GoDown2();ISL_StopDown2();',10000); //���ʱ��
}
function ISL_GoUp2(){ //�Ϸ���ʼ

if(MoveLock2) return;
clearInterval(AutoPlayObj2);
MoveLock2 = true;
MoveTimeObj2 = setInterval('ISL_ScrUp2();',Speed2);
}
function ISL_StopUp2(){ //�Ϸ�ֹͣ
clearInterval(MoveTimeObj2);
if(GetObj('ISL_Cont2').scrollLeft % PageWidth2 - fill2 != 0){
Comp2 = fill2 - (GetObj('ISL_Cont2').scrollLeft % PageWidth2);
CompScr2();
}else{
MoveLock2 = false;
}
AutoPlay2();
}

function ISL_ScrUp2(){ //�Ϸ�����
if(GetObj('ISL_Cont2').scrollLeft <= 0){GetObj('ISL_Cont2').scrollLeft = GetObj('ISL_Cont2').scrollLeft + GetObj('List3').offsetWidth}
GetObj('ISL_Cont2').scrollLeft -= Space2 ;
}


function ISL_GoDown2(){ //�·�
clearInterval(MoveTimeObj2);
if(MoveLock2) return;
clearInterval(AutoPlayObj2);
MoveLock2 = true;
ISL_ScrDown2();
MoveTimeObj2 = setInterval('ISL_ScrDown2()',Speed2);
}

function ISL_StopDown2(){ //�·�ֹͣ
clearInterval(MoveTimeObj2);
if(GetObj('ISL_Cont2').scrollLeft % PageWidth2 - fill2 != 0 ){
Comp2 = PageWidth2 - GetObj('ISL_Cont2').scrollLeft % PageWidth2 + fill2;
CompScr2();
}else{
MoveLock2 = false;
}
AutoPlay2();
}

function ISL_ScrDown2(){ //�·�����
if(GetObj('ISL_Cont2').scrollLeft >= GetObj('List3').scrollWidth){GetObj('ISL_Cont2').scrollLeft = GetObj('ISL_Cont2').scrollLeft - GetObj('List3').scrollWidth;}
GetObj('ISL_Cont2').scrollLeft += Space2 ;
}

function CompScr2(){
var num;
if(Comp2 == 0){MoveLock2 = false;return;}
if(Comp2 < 0){ //�Ϸ�
if(Comp2 < -Space2){
   Comp2 += Space2;
   num = Space2;
}else{
   num = -Comp2;
   Comp2 = 0;
}
GetObj('ISL_Cont2').scrollLeft -= num;
setTimeout('CompScr2()',Speed2);
}else{ //�·�
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

// �����С
function doZoom(size)
{
	$('.newsbody').css('fontSize',size);
}
//��Ƶ
$('.videoR dl').hover(function(){
	$(this).find('dd').addClass('Hauto');
},function(){
	$(this).find('dd').removeClass('Hauto');
});

//ͼƬ�����б�
// JavaScript Document
function $i(id){return document.getElementById(id);}

// ���Ź���
function simpleSideScroll(c,ul,config,direction){
    this.config = config ? config : {start_delay:3000, speed: 23, delay:4000, scrollItemCount:1};
	//�������ã���ʼ��ʱ��3000���ٶ�23���ƶ�����ʱ��4000��������ֵ��1
	this.c = $i(c);
	//��ȡ����Ĵ�div
	this.ul = $i(ul);
	//��ȡ����li��ǩ���ul
	this.direction = direction ? direction : "left";
	//��ʼĬ�������������ͣ
	this.pause = false;
	//��ʼĬ���ܶ�
	//�½�һ��buttonlist����
	this.buttonlist= new Object();
	
	this.delayTimeId=null;
	
	var _this = this;
	this.c.onmouseover=function(){_this.pause = true;}
	//���������div�Ͼ�ֹͣ����
	this.c.onmouseout=function(){_this.pause = false;}
	//����ƿ�div�ͼ�������
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