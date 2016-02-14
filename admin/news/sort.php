<?
	include("../../include/include.php");
	checklogin();
	if ($pid<>'')
	$p_id=$pid;
	else 
	$p_id=1;
					
	
	$dh_sql="select id,name,hight,parentlist from ".TABLEPRE."sort where id=".$p_id." order by display asc,id asc";
	$dh_myrs=mysql_query($dh_sql,$myconn);
	$dh_rec=mysql_fetch_array($dh_myrs);
	$parentid = $dh_rec["id"];
	$hight=$dh_rec["hight"];
	$l_name=$dh_rec["name"];
	if ($dh_rec["parentlist"] <> "") 
	{
	  $text = $dh_rec["parentlist"];
	  $text = str_replace("P_S", "sort.php", $text);
	  $text = str_replace("产品分类", "信息分类", $text);
	}
?>
<html>
<head>
<title><?php echo $html_title; ?></title>
<script language="JavaScript" type="text/JavaScript">
function win_ok()
	{
		var tmp='';
		var n_id='';
		var cp_sort='';		
		theForm = document.form1;
		for(i=0;i<theForm.elements.length;i++)
		{
			if(theForm.elements[i].type=="radio")
			{
				if(theForm.elements[i].checked)
				{
					tmp = theForm.elements[i].value;
				}
			}
		}
		array = tmp.split(",");
		cp_sort=array[0];		
		if(window.opener.document.all.sort_id){
		window.opener.document.all.sort_id.value=cp_sort;
		}			
		window.close();
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="../admin_css.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="650" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
        <form name="form1" method="post" action="">
          <tr> 
            <td bgcolor="#FFFFFF"> <div align="center"><strong><font color="#FF0000">信息栏目</font></strong></div></td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF">
            &nbsp;<b><font color="#FF0000">当前位置：</font></b> 
            <? echo $text;	?>
            <table width="100%" cellpadding="3" cellspacing="0" border="0">
                <tr> 
                  <?
                  	
					$group=GetValueFromTable("my_sort","users","userid = ".$_SESSION["bees_UserId"]);
				  	if ($p_id==1){							
						$sql="select * from ".TABLEPRE."sort where parentid=".$p_id." and id in ($group) and hight=1 order by top ";
					}else{
						$sql="select * from ".TABLEPRE."sort where parentid=".$p_id." and id in ($group) and hight=2 order by top ";
					}	
					$myrs=mysql_query($sql,$conn);
					$rec=@mysql_fetch_assoc($myrs);
					do
					{
					//echo $rec[name];
				  ?>
                  <td height="23" align="left"> 
                    <?
						$id_list ='';
						$idlist = explode("|",$rec[idlist]);
						for($n =0;$n <count($idlist);$n++)
						{
							$id_list.=$idlist[$n];
						}
						$time = date("md");
						
						$id_list = $rec[id].",".$time.$id_list;
						
						
					  if ($rec["hight"]==1 && !$rec["yn_mo"])
					  {
					  echo "<img src=../images/dian.gif align=absmiddle><a href=sort.php?pid=".$rec["id"].">".$rec["name"]."</a>";					
					  }
					  else
					  {
					  echo "<input type=radio name=cp_sort value=\"$id_list\" id=cp_sort > ".$rec["name"]."";
					  }
					  
					
					  ?>
                  </td>
                  <?
        			if (($i%5)==4) echo "</tr>\n";
   					 $i+=1;
  					}while($rec=@mysql_fetch_assoc($myrs));
				  ?>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"><div align="center"> 
                <input type="button" name="Submit3" value=" 确定 " onClick="win_ok()">
              </div></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>
</html>
