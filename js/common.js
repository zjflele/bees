// JavaScript Document

	 
 /*ͷ������*/
//�����ű�
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

/*��ҳ��ǩ�л�*/
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


//�����ղ�

function AddFavorite(sURL, sTitle) {

	sURL = encodeURI(sURL);
	try{  

		window.external.addFavorite(sURL, sTitle);  

	}catch(e) {  

		try{  

			window.sidebar.addPanel(sTitle, sURL, "");  

		}catch (e) {  

			alert("�����ղ�ʧ�ܣ���ʹ��Ctrl+D�������,���ֶ�����������������.");

		}  

	}

}

//��Ϊ��ҳ

function SetHome(url){

	if (document.all) {

		document.body.style.behavior='url(#default#homepage)';

		   document.body.setHomePage(url);

	}else{

		alert("����,�����������֧���Զ�����ҳ��Ϊ��ҳ����,�����ֶ�������������ø�ҳ��Ϊ��ҳ!");

	}


}


function button_submit(){
	document.getElementById('formSearchTop').submit();
}

function CheckForm(theForm)
{
	if (theForm.username.value=="")
	{
		alert("�û�������Ϊ�գ����������룡");
		document.username.focus();
		return false;
	}
	if (theForm.password.value=="")
	{
        alert("���벻��Ϊ�գ����������룡");
		theForm.password.focus();
		return false;
    }
	return true;
}

/**
 * ��ȡ���ڵĸ߶�����
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
