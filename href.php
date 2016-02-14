<?  
   $selectsearch = trim($_POST['selectsearch']);
   $keywords = addslashes(trim($_POST['keywords']));
   switch($selectsearch)
    {
       case "article":
			header("location:list_news.php?keyword=$keywords");    
			break;     
       case "video":
			header("location:list_video.php?keyword=$keywords");    
			break;
	   case "buysell":
			header("location:list_buysell.php?keyword=$keywords");    
			break;		
    }
?>