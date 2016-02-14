
$(document).ready(function(){
	
	$(".menu ul li").hover(function(){
		$(this).find("a:eq(0)").addClass("active");
		$(this).find("ul").show();
	},function(){
		$(this).find("a:eq(0)").removeClass("active");
		$(this).find("ul").hide();
	});
	
	
	
	
	$(".video_list ul li").each(function(i){
		$(this).click(function(){
			$(this).addClass("active").siblings("li").removeClass("active");
			$(".video_left .video_play").eq(i).show().siblings(".video_play").hide();
		});
	});
	
	
});

//加入收藏

function AddFavorite(sURL, sTitle) {

	sURL = encodeURI(sURL);
	try{  

		window.external.addFavorite(sURL, sTitle);  

	}catch(e) {  

		try{  

			window.sidebar.addPanel(sTitle, sURL, "");  

		}catch (e) {  

			alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.");

		}  

	}

}

//设为首页

function SetHome(url){

	if (document.all) {

		document.body.style.behavior='url(#default#homepage)';

		   document.body.setHomePage(url);

	}else{

		alert("您好,您的浏览器不支持自动设置页面为首页功能,请您手动在浏览器里设置该页面为首页!");

	}


}
 