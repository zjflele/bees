<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
<title>图片滚动</title>
<style type="text/css">
body{ margin:0 ; padding:0;}
.pcont_box {overflow:hidden;zoom:1;font-size:9pt; border:1px solid  #dcdff0; width:978px; height:200px ;}
.pcont_box .pcont {width:910px;float:left;overflow:hidden; padding-top:15px;}
.pcont_box .ScrCont {width:32766px;zoom:1;margin-left:-5px;}
.pcont_box #List1_1, .pcont_box #List2_1 {float:left;}
.pcont_box .LeftBotton, .pcont_box .RightBotton { width:30px;height:160px;float:left;background:url(images/ax.gif) no-repeat; margin-top:20px;}
.pcont_box .LeftBotton {background-position: 0 0; margin-left:5px;}
.pcont_box .RightBotton {background-position: 0 -160px; }
.pcont_box .LeftBotton:hover {background-position: -30px 0;}
.pcont_box .RightBotton:hover {background-position: -30px -160px;}
.pcont_box .pl img {display:block;cursor:pointer;border:none;}
.pcont_box .pl {width:220px; margin-top:10px; margin-right:10px;float:left;text-align:center;}
.pcont_box a{ color:#999; text-decoration:none;}
.pcont_box a.pl:hover { background:#f3f3f3;color:#5dacec; background:#fff;}
</style>
<script type="text/javascript">

var Speed_1 = 10; //速度(毫秒)
var Space_1 = 10; //每次移动(px)
var PageWidth_1 = 230 * 1; //翻页宽度
var interval_1 = 5000; //翻页间隔时间
var fill_1 = 0; //整体移位
var MoveLock_1 = false;
var MoveTimeObj_1;
var MoveWay_1="right";
var Comp_1 = 0;
var AutoPlayObj_1=null;
function GetObj(objName){if(document.getElementById){return eval('document.getElementById("'+objName+'")')}else{return eval('document.all.'+objName)}}
function AutoPlay_1(){clearInterval(AutoPlayObj_1);AutoPlayObj_1=setInterval('ISL_GoDown_1();ISL_StopDown_1();',interval_1)}
function ISL_GoUp_1(){if(MoveLock_1)return;clearInterval(AutoPlayObj_1);MoveLock_1=true;MoveWay_1="left";MoveTimeObj_1=setInterval('ISL_ScrUp_1();',Speed_1);}
function ISL_StopUp_1(){if(MoveWay_1 == "right"){return};clearInterval(MoveTimeObj_1);if((GetObj('ISL_Cont_1').scrollLeft-fill_1)%PageWidth_1!=0){Comp_1=fill_1-(GetObj('ISL_Cont_1').scrollLeft%PageWidth_1);CompScr_1()}else{MoveLock_1=false}
AutoPlay_1()}
function ISL_ScrUp_1(){if(GetObj('ISL_Cont_1').scrollLeft<=0){GetObj('ISL_Cont_1').scrollLeft=GetObj('ISL_Cont_1').scrollLeft+GetObj('List1_1').offsetWidth}
GetObj('ISL_Cont_1').scrollLeft-=Space_1}
function ISL_GoDown_1(){clearInterval(MoveTimeObj_1);if(MoveLock_1)return;clearInterval(AutoPlayObj_1);MoveLock_1=true;MoveWay_1="right";ISL_ScrDown_1();MoveTimeObj_1=setInterval('ISL_ScrDown_1()',Speed_1)}
function ISL_StopDown_1(){if(MoveWay_1 == "left"){return};clearInterval(MoveTimeObj_1);if(GetObj('ISL_Cont_1').scrollLeft%PageWidth_1-(fill_1>=0?fill_1:fill_1+1)!=0){Comp_1=PageWidth_1-GetObj('ISL_Cont_1').scrollLeft%PageWidth_1+fill_1;CompScr_1()}else{MoveLock_1=false}
AutoPlay_1()}
function ISL_ScrDown_1(){if(GetObj('ISL_Cont_1').scrollLeft>=GetObj('List1_1').scrollWidth){GetObj('ISL_Cont_1').scrollLeft=GetObj('ISL_Cont_1').scrollLeft-GetObj('List1_1').scrollWidth}
GetObj('ISL_Cont_1').scrollLeft+=Space_1}
function CompScr_1(){if(Comp_1==0){MoveLock_1=false;return}
var num,TempSpeed=Speed_1,TempSpace=Space_1;if(Math.abs(Comp_1)<PageWidth_1/2){TempSpace=Math.round(Math.abs(Comp_1/Space_1));if(TempSpace<1){TempSpace=1}}
if(Comp_1<0){if(Comp_1<-TempSpace){Comp_1+=TempSpace;num=TempSpace}else{num=-Comp_1;Comp_1=0}
GetObj('ISL_Cont_1').scrollLeft-=num;setTimeout('CompScr_1()',TempSpeed)}else{if(Comp_1>TempSpace){Comp_1-=TempSpace;num=TempSpace}else{num=Comp_1;Comp_1=0}
GetObj('ISL_Cont_1').scrollLeft+=num;setTimeout('CompScr_1()',TempSpeed)}}
function picrun_ini(){
GetObj("List2_1").innerHTML=GetObj("List1_1").innerHTML;
GetObj('ISL_Cont_1').scrollLeft=fill_1>=0?fill_1:GetObj('List1_1').scrollWidth-Math.abs(fill_1);
GetObj("ISL_Cont_1").onmouseover=function(){clearInterval(AutoPlayObj_1)}
GetObj("ISL_Cont_1").onmouseout=function(){AutoPlay_1()}
AutoPlay_1();
}
</script>
</head>
<body>
<!-- picrotate_left start  -->
<div class="pcont_box"> <a class="LeftBotton" onmousedown="ISL_GoUp_1()" onmouseup="ISL_StopUp_1()" onmouseout="ISL_StopUp_1()" href="javascript:void(0);" target="_self"></a>
  <div class="pcont" id="ISL_Cont_1">
    <div class="ScrCont">
      <div id="List1_1">
        <!-- piclist begin -->
        <a class="pl" href="#" ><img src="../images/picture.jpg" alt="" width="220" height="150"/></a>
        <a class="pl" href="#" ><img src="../images/picture01.jpg" alt="" width="220" height="150"/></a>
        <a class="pl" href="#" ><img src="../images/picture.jpg" alt="" width="220" height="150"/></a>
        <a class="pl" href="#" ><img src="../images/picture01.jpg" alt="" width="220" height="150"/></a>
        <a class="pl" href="#" ><img src="../images/picture.jpg" alt="" width="220" height="150"/></a>
        <a class="pl" href="#" ><img src="../images/picture01.jpg" alt="" width="220" height="150"/></a>
         <a class="pl" href="#" ><img src="../images/picture.jpg" alt="" width="220" height="150"/></a>
        <a class="pl" href="#" ><img src="../images/picture01.jpg" alt="" width="220" height="150"/></a>
        <!-- piclist end -->
      </div>
      <div id="List2_1"></div>
    </div>
  </div>
  <a class="RightBotton" onmousedown="ISL_GoDown_1()" onmouseup="ISL_StopDown_1()" onmouseout="ISL_StopDown_1()" href="javascript:void(0);" target="_self"></a> </div>
<div class="c"></div>
<script type="text/javascript">
        <!--
        picrun_ini()
        //-->
</script>
<!-- picrotate_left end -->


</body>
</html>