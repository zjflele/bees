<? include("../../include/include.php");
if ($_GET["action"]=="action")
{
$sqlstr = "update wts_picture_category set book='$menu' where id=$id";
$myrs=mysql_query($sqlstr,$myconn);
if ($myrs)
{
?>
<script language=javascript>
    alert('指定成功！');
	window.close();
</script>
<?
}
}

?>
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<table width="60%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF" align="center">
                                      <tr> 
                                        <td align="left" bgcolor="#E9F8FE"><font color="#FF0000">指定电子书：</font></td>
                                      </tr>
                                      <tr> 
                                        <form name="form1" method="post" action="menu_href.php?action=action">
                                          <td bgcolor="#FFFFFF"> <div align="center"> 
                                              <table width="100%" border="0">
                                                <tr>
                                                  <td width="33%" align=right>
													<input type="hidden" name="id" value="<? echo $id;?>">                                                  
指定电子书：</td>
                                                  <td width="67%" align=left><select name="menu">
												  <? $sql="select * from book where hight=1 order by id desc";
												     $myrs=mysql_query($sql,$myconn);
													 while($rec=mysql_fetch_array($myrs))
													 {
													 echo "<option value=$rec[id]>$rec[name]</option>";
													 }
												  ?>
												  </select>
                                                       　　
                                                       <input type="submit" name="Submit" value="指定类别"></td>
                                                </tr>
                                                <tr align=center>
                                                  <td colspan="2">&nbsp;</td>
                                                </tr>
                                              </table>
                                          </div></td>
                                        </form>
                                      </tr>
                                    </table>