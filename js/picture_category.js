function changeCategory(pid,selectId,currPid){
	$.get("/ajax.php?pid="+pid+"&currPid="+currPid, function(data){
	   for(var i=parseInt(selectId);i<=7;i++){

		   $("#category_"+i).empty();
		   
		}
	   
	   $("#category_"+selectId).append(data);
	}); 	
}
window.onload = function(){
	changeCategory(1,'1');	
}