<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<title><? if ($arrArticle['title']) {echo $arrArticle['title'].'-';}?><?=TITLE?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body>
<div class="ybWrap">
	<header class="ybTop">
    	<img src="images/bgtop.png" width="100%">
        <ul class="ybNav">
        	<li <?=($headerMenu == 'index')?'class="on"':'';?>><a href="index.php">��ҳ</a></li>
            <li <?=($headerMenu == 'sjsm')?'class="on"':'';?>><a href="show_article.php?id=3864">���˵��</a></li>
            <li <?=($headerMenu == 'ljfx')?'class="on"':'';?>><a href="ljfx.php">·������</a></li>
            <li <?=($headerMenu == 'jdfx')?'class="on"':'';?>><a href="jdfx.php">�������</a></li>
            <li <?=($headerMenu == 'nkt')?'class="on"':'';?>><a href="nkt.php">���ͼ</a></li>
            <li <?=($headerMenu == 'weizhi')?'class="on"':'';?>><a href="weizhi.php">λ��ͼ</a></li>
        </ul>
    </header>
