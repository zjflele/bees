<?php
	include("../../include/include.php");
	checklogin();
	set_magic_quotes_runtime(0);
	
	if(@$_POST["action"]=='add')
	{
	//echo $templet;exit();
		$obj = new EasyDB(TABLEPRE.'zhuanti_sort');
		if ($obj->Post["sid"]){
		$obj->User["sid"] = $obj->Post["sid"];
		$obj->User["zid"]		= intval($obj->Post["zid"]);
		$obj->User["sname"]		= trim($obj->Post["sname"]);	
		$obj->User["stype"]		= intval($obj->Post["stype"]);	
		$obj->User["is_menu"]		= intval($obj->Post["is_menu"]);
		$obj->User["is_main"]		= intval($obj->Post["is_main"]);	
		$obj->User["display"]	= intval($obj->Post["display"]);		
		$obj->IDVars			= "sid";
		$obj->SetLimit(1);	
		$obj->AcceptType="USER";
		if(!$obj->Update())		
		{
			$js = new Javascript();
			$js->Begin();
			$js->Alert("编辑失败！");
			$js->End();
		}	
		$sid = 0;
		}else{
		$obj->User["zid"]		= intval($obj->Post["zid"]);
		$obj->User["sname"]		= trim($obj->Post["sname"]);
		$obj->User["stype"]		= intval($obj->Post["stype"]);
		$obj->User["is_menu"]		= intval($obj->Post["is_menu"]);
		$obj->User["is_main"]		= intval($obj->Post["is_main"]);
		$obj->User["display"]	= intval($obj->Post["display"]);		  	
		
		$obj->AcceptType="USER";
		if(!$obj->Insert())		
		{
			$js = new Javascript();
			$js->Begin();
			$js->Alert("信息发布失败！");
			$js->End();
		}
		}		
	}
	
	if (@$_GET["sid"] && @$_GET["act"]=='edit'){
		$c_sql = "select * from ".TABLEPRE."zhuanti_sort where sid=".intval($_GET["sid"]);
		$c_myrs = mysql_query($c_sql,$myconn);
		$c_info = mysql_fetch_array($c_myrs);
		$sid = intval($_GET["sid"]);
	}else if (@$_GET["sid"] && @$_GET["act"]=='del'){
		$del_sql = "delete from ".TABLEPRE."zhuanti_sort where sid=".intval($_GET["sid"]);
		$del_myrs = mysql_query($del_sql,$myconn);
		
		if(!$del_myrs)		
		{
			Error("删除信息失败。", $_SERVER["PHP_SELF"]);
		}
		$sid = 0;
	}
	
	if(@$_GET["id"])
	{
		$zhuanti_sql = "select * from ".TABLEPRE."zhuanti where id=".intval($_GET["id"]);
		$zhuanti_myrs = mysql_query($zhuanti_sql,$myconn);
		$zhuanti_info = mysql_fetch_array($zhuanti_myrs);
		
		$sort_sql = "select * from ".TABLEPRE."zhuanti_sort where zid=".intval($_GET["id"])." order by display desc";
		$sort_myrs=mysql_query($sort_sql);		
		//print_r($zhuanti_info);
	}
	
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<LINK href="../../css/common.css" type=text/css rel=stylesheet>
<script language="javascript" src="../../js/calendar.js"></script>
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
        <TBODY>
        <TR class=header align=left>
          <TD colspan="3"><?=$zhuanti_info['title']?>--专题--分类管理 [<a href="manage.php">返回列表</a>]</TD>
          </TR>
        <TR>
		<TD width="57%" height="70%" valign="top" bgColor=#f8f9fc>
		<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
              <tbody id="hiddenTime" style="display:none">
              </tbody>
              <tr bgcolor="#336699">
                <td  width="50%">分类名称</td>
				<td  width="10%">类型</td>
				<!--td  width="10%">是否导航</td>
				<td  width="10%">是否主栏</td-->
				<td  width="20%">管理</td>
              </tr>
			  <?PHP while ($row = mysql_fetch_array($sort_myrs)) {  ?>
			  <tr bgcolor="#FFFFFF">
               <td><?php echo $row[sname];?></td>
			   <td><?php echo ($row[stype])?'图片':'新闻';?></td>
			   <!--td><?php echo ($row[is_menu])?'是':'否';?></td>
			   <td><?php echo ($row[is_main])?'是':'否';?></td-->
				<td>[<a href="?act=edit&id=<?php echo $_GET["id"]?>&sid=<?php echo $row["sid"]?>">编辑</a>][<a href="?act=del&id=<?php echo $_GET["id"]?>&sid=<?php echo $row["sid"]?>">删除</a>]</td>
              </tr>
			  <?php }?>
	  </table>
	  
		
	  
	  
		
</td>
          <TD width="43%" height="30%" colspan="2" valign="top" bgColor=#f8f9fc>
		  <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
            <form action="zhuanti_sort.php?id=<?php echo intval($_GET['id'])?>" enctype="multipart/form-data" method="post" name="form">
              <tbody id="hiddenTime" style="display:none">
              </tbody>
              <tr bgcolor="#336699">
                <td colspan="2"><?php if($_GET['sid']){echo "修改分类";}else{echo "添加分类";}?>:</td>
              </tr>
			   <tr bgcolor="#FFFFFF">
                <td width="32%">分类名称：</td>
                <td width="68%"><input name="sname" type="text" id="sname" size="30" value="<? echo $c_info['sname'];?>"></td>
              </tr> 
			  <tr bgcolor="#FFFFFF">
                <td width="32%">类型：</td>
                <td width="68%"> 
                <input name="stype" id="stype" type="radio" value="1"  <? if($c_info['stype']==1) echo "checked";?>>
                  焦点新闻
                <input name="stype" id="stype" type="radio" value="2"  <? if($c_info['stype']==2) echo "checked";?>>
                  图文模版1
                 <input name="stype" id="stype" type="radio" value="3"  <? if($c_info['stype']==3) echo "checked";?>>
                  图文模版2
                <input name="stype" id="stype" type="radio" value="4" <? if($c_info['stype']==4) echo "checked";?>>
                图片</td>
              </tr>
			   <!--tr bgcolor="#FFFFFF">
                <td width="32%">是否显示在导航栏：</td>
                <td width="68%"> <input name="is_menu" id="is_menu" type="radio" value="0"  <? if(!$c_info['is_menu']) echo "checked";?>>
                  否
                    <input name="is_menu" id="is_menu" type="radio" value="1" <? if($c_info['is_menu']==1) echo "checked";?>>
                是</td>
              </tr>
			   <tr bgcolor="#FFFFFF">
                <td width="32%">是否显示在主栏：</td>
                <td width="68%"> <input name="is_main" id="is_main" type="radio" value="0"  <? if(!$c_info['is_main']) echo "checked";?>>
                  否
                    <input name="is_main" id="is_main" type="radio" value="1" <? if($c_info['is_main']==1) echo "checked";?>>
                是</td>
              </tr-->
			  
			  <tr bgcolor="#FFFFFF" id="img_display">
                <td width="32%">排序号：</td>
                <td width="68%"><input type="text" name="display" value="<? echo $c_info['display'];?>"></td>
              </tr>
			            
              <tr bgcolor="#FFFFFF">
                <td colspan="2" align="center">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="zid" value="<?php echo intval($_GET['id'])?>">
				<input type="hidden" name="sid" value="<?php echo $sid;?>">
                    <input type="submit" value="提交" name="b1">
                    <input type="reset" name="Submit22" value="重写">                </td>
              </tr>
            </form>
          </table></TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
