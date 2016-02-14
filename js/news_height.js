	var lh = document.getElementById("left_news_div").offsetHeight;
	var h = document.getElementById("news_content_div").offsetHeight;
	var th = lh;	
	if (h<th)
		document.getElementById("news_content_div").style.height=th+"px";