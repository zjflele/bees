// JavaScript Document

	 
 /*头部导航*/
//导航脚本
$(document).ready(function(){
  
  $("li.mainlevel").mousemove(function(){
  $(this).find('ul').slideDown();
  });

  $("li.mainlevel").mouseleave(function(){
  $(this).find('ul').slideUp("fast");
  });
  
  $(".menusub").hover(function(){
  $(this).parent().children().first().addClass("menuover");
	},function(){
  $(".mainlevel a").removeClass("menuover");  
	});  
});

/*首页标签切换*/
$(document).ready(function(){
	$(".tab_nav").each(function(){
		$(this).parents(".tab_box").find(".tab_content").hide();												 
		$("li",this).each(function(index){
			$(this).parents(".tab_box").find(".tab_content").eq(index).css("display",$(this).is(".on")?"block":"none");
			
			$(this).bind("click",function(){
				$(this).addClass("on").siblings().removeClass("on");
				$(this).parents(".tab_box").find(".tab_content").hide().eq(index).show();
			});
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


function button_submit(){
	document.getElementById('formSearchTop').submit();
}

function CheckForm(theForm)
{
	if (theForm.username.value=="")
	{
		alert("用户名不能为空，请重新输入！");
		document.username.focus();
		return false;
	}
	if (theForm.password.value=="")
	{
        alert("密码不能为空，请重新输入！");
		theForm.password.focus();
		return false;
    }
	return true;
}

/**
 * 获取窗口的高度与宽度
 */
function getWindowSize() {
  var winWidth = 0, winHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    winWidth = window.innerWidth;
    winHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    winWidth = document.documentElement.clientWidth;
    winHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    winWidth = document.body.clientWidth;
    winHeight = document.body.clientHeight;
  }
  return {winWidth:winWidth,winHeight:winHeight}
}
