<?
include ("../../include/include.php");
$ac = trim($_GET['ac']);
if ($_SESSION['bees_SiteId'])
		$where = " and siteid = ".$_SESSION['bees_SiteId'];
if ($ac == "del_no_allow"){	
	$mys=mysql_query("select count(*) from ".TABLEPRE."buysell where pass = 'n' ".$where,$myconn);
	$num = mysql_result($mys,0);
	$mys=mysql_query("delete from ".TABLEPRE."buysell where pass = 'n' ".$where,$myconn);
	if ($mys)
	{
	?>
	<script language=javascript>
	  alert("成功清除未审核供求信息(<?=$num?>)条！");
	  window.location.href="manage.php";
	</script>
	<?
	}
}else{
	$sql="select sellid,limitdate,startdate from ".TABLEPRE."buysell where limitdate <> '0|||长期有效' $where order by sellid";
	//echo $sql;
	$myrs=mysql_query($sql,$myconn);
	$i=0;
	while ($rec=mysql_fetch_array($myrs))
	{
	   if (strstr($rec[limitdate],"|||"))
	   {
	  $time = explode("|||",$rec[limitdate]);
	  } else
	  $time = explode("||",$rec[limitdate]);
	 // printf($time[0]);
	  //$date=$time[0]/86400;
	  $date=strtotime(date("Y-m-d"))-strtotime($rec[startdate]);
	  //echo "---".$date."---".date("Y-m-d")."---".$rec[startdate];
	  if ($date>$time[0])
	  {
		 $i+=1; 
		$sqlstr="delete from ".TABLEPRE."buysell where sellid =$rec[sellid]";
		$mys=mysql_query($sqlstr,$myconn);
		//mysql_free_result($mys);
	  }
	  //echo "<br>";
	}
	if ($myrs)
	{
	?>
	<script language=javascript>
	  alert("成功清除过期供求信息(<?=$i?>)条！");
	  window.opener.location="manage.php";
	  window.close();
	</script>
	<?
	}
}
?>