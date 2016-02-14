<? include("../include/include.php");
$sqlstr="select * from ".TABLEPRE."index_img where id<>'' order by id desc limit 0,5";
$myrs=mysql_query($sqlstr,$myconn);
?>
<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
    <title>焦点图</title>
      
    <link rel="stylesheet" href="bjqs.css">

    <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="js/bjqs-1.3.min.js"></script>
      
  </head>
  
  <body>
  
    <div id="container">
        
      <div id="banner-slide">

        <ul class="bjqs">
        <?php while($rec=mysql_fetch_array($myrs)) {?>	
          <li>
			<a href="<?=$rec['linkpath']?>" target="_blank">
				<img src="../upload/images/<?=$rec['imgpath']?>" title="<?=iconv('gbk','utf-8',$rec['title'])?>" width="375" height="205" border="0"></a></li>
        <?php } ?> 
          
        </ul>

      </div>
      
      <script>
        jQuery(document).ready(function($) {
          
          $('#banner-slide').bjqs({
            animtype      : 'slide',
            height        : 205,
            width         : 375,
            responsive    : true,
            randomstart   : true
          });
          
        });
      </script>

    </div>

    <script src="js/libs/jquery.secret-source.min.js"></script>

    <script>
    jQuery(function($) {

        $('.secret-source').secretSource({
            includeTag: false
        });

    });
    </script>

  </body>
</html>
