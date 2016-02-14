<?php
include("../../include/include.php");

$sdate = ($_POST['sdate'])?trim($_POST['sdate']):date('Y-m-d',strtotime('-1 Month'));
$edate = ($_POST['edate'])?trim($_POST['edate']):date('Y-m-d');

$sqlstr="select SUM(vnum) from ".TABLEPRE."visit_count where 1";
$myrs = mysql_query($sqlstr,$myconn);
$visit_num = mysql_result($myrs,0);

$sqlstr="select SUM(counts) from ".TABLEPRE."article where date<'2009-10-20'";
$myrs = mysql_query($sqlstr,$myconn);
$art_num = mysql_result($myrs,0);


$sqlstr="select SUM(vnum) as totalnum from ".TABLEPRE."visit_count where vtime>='$sdate' and vtime<='$edate'";
$myrs = mysql_query($sqlstr,$myconn);
$currentnum = mysql_result($myrs,0);

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY><form name="form1" method="post" action="<?=$_SERVER["PHP_SELF"]?>">
        <TR class=header align=left>
          <TD colspan="2">网站流量统计报表</TD>
		  <TD width="91%" > 检索：开始时间:  
		        <input type="text" name="sdate" value="<?=$sdate?>">
		        结束时间 
		         <input type="text" name="edate" value="<?=$edate?>">
		         <input type="submit" name="Submit" value="显示">(格式：2007-01-01)</TD>
          </TR> </form>
        <TR>
          <TD height="543" colspan="3" valign="top" align="center" bgColor="#f8f9fc">
		   <table width="95%" border="0" height="30" >
		   <tr>
		     <td width="200" align="right">网站总流量为：</td>
			 <td align="left"><?php echo $totalnum;?></td>
		   </tr>
		   <tr>
		     <td width="200" align="right">当前时间段总流量为：</td>
			 <td align="left"><?php echo $currentnum;?></td>
		   </tr>
		   </table>
		  <table width="95%" border="0" height="100%" >
  
  <tr>
    <td>
	<script type="text/javascript" src="swfobject.js"></script>
	<div id="flashcontent">
		<strong>You need to upgrade your Flash Player</strong>
	</div>

	<script type="text/javascript">
		// <![CDATA[		
		var so = new SWFObject("amline.swf", "amline", "100%", "480", "8", "#FFFFFF");
		so.addVariable("path", "./");
		so.addVariable("settings_file", encodeURIComponent("amline_settings.xml"));
		so.addVariable("data_file", encodeURIComponent("date.php?s=<?=$sdate?>&e=<?=$edate?>"));
		so.write("flashcontent");
		// ]]>
	</script>
	</td>
  </tr>
  
</table>

		  
	
	
	     </TD>
	    </tr>
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
