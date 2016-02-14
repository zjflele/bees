<?php 
	include("../include/include.php");
	$arr_picture = getlist("SELECT id,imgpath,title FROM  ".TABLEPRE."picture WHERE ptype=3 ORDER BY istop desc ,updtime desc LIMIT 0,10");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
<link href="../css/common.css" rel="stylesheet" type="text/css">
<link href="../css/main.css" rel="stylesheet" type="text/css">
<link href="../css/lrtk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.4.2.js"></script>
<SCRIPT language="JavaScript" src="../js/common.js"></SCRIPT>
<script type="text/javascript" src="../js/koala.min.1.5.js"></script>
</head>

<body style=" background:none">
<div id="demo" >
<div id="indemo"   >
<div id="demo1"  >
 <ul class="pic_list">
<?php foreach ($arr_picture as $k => $picture){?>
                    	<li>			
						<a href="../list_pic.php?action=show&id=<?=$picture['id']?>" target="_blank"><img src="../upload/a_photo/s_<?=$picture['imgpath']?>" width="223" height="150" alt=""></a>
                        </li>
<?php } ?>
 </ul>
</div>
<div id="demo2"></div>
</div>
   </div>
   <script type="text/javascript">
				<!--
                    var speed2 = 50;
                    var tab = document.getElementById("demo");
                    var tab1 = document.getElementById("demo1");
                    var tab2 = document.getElementById("demo2");
                    tab2.innerHTML = tab1.innerHTML;
                    function Marquee() {
                        if (tab2.offsetWidth - tab.scrollLeft <= 0)
                            tab.scrollLeft -= tab1.offsetWidth
                        else {
                            tab.scrollLeft++;
                        }
                    }
                    var MyMar = setInterval(Marquee, speed2);
                    tab.onmouseover = function () { clearInterval(MyMar) };
                    tab.onmouseout = function () { MyMar = setInterval(Marquee, speed2) };
				-->
				</script>
</body>
</html>
