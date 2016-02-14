<?php

	include("../../include/include.php");
	include("../../include/market_type.php");
	if(@$_GET["action"]=="del" && @$_GET["id"])
	{
		$obj = new EasyDB(TABLEPRE."market");
		$obj->IDVars="id";
		$obj->SetLimit(1);
		$ninfo = getrow("select pname from ".TABLEPRE."market where id=".$_GET['id']);
		if($obj->Delete()){
			//add_log(2,'market/manage.php','删除市场行情->'.$ninfo["pname"]);
			alertmessage("删除信息成功",3);
		}else{
			alertmessage("删除信息失败",2);
		}
	}
	
	$s_date = trim($_GET['s_date']);
	$e_date = trim($_GET['e_date']);
	$username = trim($_GET['username']);
	$mid = intval($_GET['mid']);
	$pname = trim($_GET['pname']);
	$typeid = trim($_GET['typeid']);
	$btime = trim($_GET['btime']);
	$dtime = trim($_GET['dtime']);
	$pfrom = trim($_GET['pfrom']);
	$sqlstr_tt="select * from ".TABLEPRE."market where 1";
	if ($_SESSION["bees_SiteId"])
		$sqlstr_tt.=" and siteid = '$_SESSION[bees_SiteId]'";
	if ($username<>"")
		$sqlstr_tt.=" and username = '$username'";
	if ($suserid<>"")
		$sqlstr_tt.=" and uid = '$suserid'";
	if ($s_date<>"")
		$sqlstr_tt.=" and LEFT(addtime,10)>='$s_date'";
	if ($e_date<>"")
		$sqlstr_tt.=" and LEFT(addtime,10)<='$e_date'";
		
	if ($mid!="" && $mid!='ID')
		$sqlstr_tt.=" and id= {$mid}";
	else
		$mid = "ID";
		
	if ($pname!="" && $pname!='商品名称')
		$sqlstr_tt.=" and pname like '%$pname%'";
	else
		$pname = "商品名称";
	if ($typeid)
		$sqlstr_tt.=" and typeid =".$typeid;
	if ($btime!="" && $btime!='报价时间')
		$sqlstr_tt.=" and btime >= '$btime'";
	else
		$btime = '报价时间';
	if ($dtime!="" && $dtime!='有效时间')
		$sqlstr_tt.=" and dtime <= '$dtime'";
	else
		$dtime = '有效时间';
	if ($pfrom!="" && $pfrom!='信息来源')
		$sqlstr_tt.=" and pfrom like '%$pfrom%'";
	else
		$pfrom = '信息来源';
	$sqlstr_tt.=" order by addtime desc";
	//echo $sqlstr_tt;
	$total_num = get_total_num($sqlstr_tt);
//------------分页设置------------------     
    $filename=$PHP_SELF."?username=$username&s_date=$s_date&e_date=$e_date&pname=$pname&typeid=$typeid&btime=$btime&dtime=$dtime&pfrom=$pfrom"; 	
	$page = (!empty($_GET['page']))?intval($_GET['page']):1;
    $offset=($page-1)*$pagesize;
    $offend=$offset+$pagesize;	
	$pageinfo = pageft($total_num,$pagesize,$filename);

    $sqlstr_tt=$sqlstr_tt." limit $offset,$pagesize";
    $arrMarket = getlist($sqlstr_tt);

	
//-----------用户信息列表----------
	$arrUserList = getUserList();	
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script type="text/javascript" src="../../include/prototype.js"></script>
<script type="text/javascript" src="../../js/sdate.js"></script>
<script language="javascript">
 
 var bm_id;
 function allow(id)
 {
	bm_id = id;
 	if(id=='')
	{
		alert("参数错误");
	}
	else
	{
		var url = "market_allow.php";
		var para = "status=1&id="+bm_id;
		var mystatus = new Ajax.Request(
			url,
			{
				method:'get',
				parameters:para,
				onComplete:ChangeToRefuse
			}	
		);
	}
 }
 
 function refuse(id)
 {
	bm_id = id;
 	if(id=='')
	{
		alert("参数错误");
	}
	else
	{
		var url = "market_allow.php";
		var para = "status=0&id="+bm_id;		
		var mystatus = new Ajax.Request(
			url,
			{
				method:'get',
				parameters:para,
				onComplete:ChangeToAllow
			}	
		);
	}
 }
 
 function ChangeToAllow() 
 {
    alert("取消审核成功");
	$('status'+bm_id).innerHTML = "<img src='../images/refuse.gif' onclick='allow("+bm_id+")' style='border:0'>";
 }
 
 function ChangeToRefuse()
 {
 	alert("审核成功");
	$('status'+bm_id).innerHTML = "<img src='../images/allow.gif' onclick='refuse("+bm_id+")' style='border:0'>";
 }
 function checkall(o)
 {
	for (var i=1;i<=20;i++)
	{
	  var name="mid["+i+"]";
	  //alert (name);
	  document.getElementById(name).checked=o.checked;
	}
 }
function showForm(isshow){
	if (isshow){
		document.getElementById('edit_params').style.display = 'block';
	}else{
		document.getElementById('edit_params').style.display = 'none';	
	}		 
}
</script>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD>
      <table class=tableout cellspacing=1 cellpadding=6 width="100%" align=center 
      border=0>
        <tbody>
        <form name="form1" method="get">
          <tr class=header align=left>
            <td  width="13%"colspan="2">市场行情管理</td>
            <td width="87%" >
            <input type="text" name="mid" value="<?=$mid?>"  onblur="if(this.value=='') this.value='ID';" onClick="if(this.value=='ID') this.value=''; " \>
            
			<INPUT 
                  onblur="if(this.value=='') this.value='商品名称';" 
                  title="请输入您要搜索的商品名称关键字，如：黄杨" 
                   
                  onclick="if(this.value=='商品名称') this.value=''; " value=<?=$pname?>  
                  name=pname>
			<SELECT id=typeid title=商品类别 style="WIDTH: 100px" name=typeid>
						<OPTION value="" selected select="select">请选择</OPTION> 
						<?php
							foreach ($market_type as $k => $v){
								echo "<OPTION value=$k>$v</OPTION>";
							}
						?>
			</SELECT>
			<INPUT title=选择报价时间的起始点 
                  onClick="SelectDate(this,'yyyy-MM-dd')" readonly="true" style="width:100px;"
                  value=<?=$btime?> name=btime>
			<INPUT title=选择报价时间的终点 
                  onClick="SelectDate(this,'yyyy-MM-dd')" readonly="true" style="width:100px;"
                  value=<?=$dtime?> name=dtime>
			<br />
			<INPUT 
                  onblur="if(this.value=='') this.value='信息来源';" 
                  title=请输入您要搜索的信息来源关键字,如：中国花木城 
                  style="BORDER-RIGHT: #cccccc 1px solid; BORDER-TOP: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; WIDTH: 120px; BORDER-BOTTOM: #cccccc 1px solid; HEIGHT: 18px" 
                  onclick="if(this.value=='信息来源') this.value=''; " value=<?=$pfrom?> 
                  name=pfrom> 
           <?php if (!$_SESSION['bees_SiteId']){ ?>       
			发布用户：
           <select name="suserid" id="suserid">
		   <option value='' selected>请选择用户</option>
		   <? 
		   foreach ($arrUserList as $k => $v){
			   	$selected = ($suserid == $v['userid'])?'selected':'';
		   		echo "<option value='".$v['userid']."' $selected>".$v['zname']."</option>";			
		   }?>
		   </select>
            <?php }?>
			<input type="submit" name="Submit" value="检索">	  			
&nbsp;&nbsp;<a href="add.php" style="color:#FFFFFF; font-weight:bold">市场行情发布</a></td>
          </tr>
       </form> 
	   <script>
	   	$("#typeid").val(<?=$typeid?>);
	   </script>		
        <tr>
          <td height="543" colspan="3" valign="top" bgcolor=#f8f9fc><?
   if ($total_num != 0)  //--------------if01--------------------
{
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center"><table cellspacing="0" cellpadding="0" border="0" width="98%" align="center" style="word-break:break-all;" class="tableout">
                            <tr>
                              <td bgcolor="#DDE3EC" align="left">
                              <form name="form1" method="post" action="manage_action.php" target="_blank">
                              <div align="left"> <input type=checkbox value="Check All" onClick="checkall(this)">
全选
                                  <input type="radio" name="caozuo" value="edit_all" onClick="showForm(1);">
                                  		
                                        批量编辑 
                                  <input type="radio" name="caozuo" value="tj" onClick="showForm(0);">
                                  		
                                        开通信息 
                                        <input type="radio" name="caozuo" value="del"  onClick="showForm(0);">
                                        删除信息 　
										<input type="submit" name="Submit" value="提交">　
  <div id="edit_params" style="BORDER-TOP: #36C 1px solid; display:none;">
  商品类型<SELECT id=typeid title=商品类别 style="WIDTH: 100px" name=typeid>
						<OPTION value="" selected select="select">请选择</OPTION> 
						<?php
							foreach ($market_type as $k => $v){
								echo "<OPTION value=$k>$v</OPTION>";
							}
						?>
						</SELECT>
  信息来源<input name="pfrom" type="text" id="pfrom" size="15" value="">                      
  产品产地<input name="paddress" type="text" id="paddress" size="15" value="">
  联系人<input name="uname" type="text" id="uname" size="15" value="">   
  联系电话<input name="phone" type="text" id="phone" size="15" value="">
                     
  </div>                                   
                                        
  </div>
                              <table border="0" cellspacing="1" cellpadding="4" width="100%" align="left">
                                  <tr class="header">
                                  	<td width="40">ID</td>
                                    <td>商品名称</td>
									<td width="117" >发布用户</td> 
									<td width="60" >类别</td>  
									<td width="117" >商品报价</td> 
									<td width="80" >报价时间</td> 
									<td width="80" >有效时间</td>                                   
                                    <td width="82" align="center">操作</td>
									<td width="41" >审核</td>
                                  </tr>
								  <?php 
								  foreach ($arrMarket as $m){
									  $nn+=1;
								  	?>
									<tr  bgcolor="#FFFFFF">
                                    <td ><input type="checkbox" name="mid[<?=$nn?>]" id="mid[<?=$nn?>]" value="<?=$m['id']?>"><?=$m['id']?></td>
                                    <td ><a href="/show_market.php?id=<?=$m['id']?>" target="_blank"><?=$m['pname']?></a></td>
									<td><?=$arrUserList[$m['uid']]['zname']?></td> 
									<td><?=$market_type[$m['typeid']]?></td>  
									<td><?=$m['price']?></td> 
									<td ><?=$m['btime']?></td> 
									<td ><?=$m['dtime']?></td>                                   
                                    <td align="center"><a href="edit.php?id=<?=$m['id']?>">编辑</a> | <a href="<?=$filename."&action=del&id=".$m['id']?>">删除</a></td>
									<td width="41" >
<? 
echo "<div id=\"status$m[id]\">";
//echo ($m['status']=='0')?"<input type=\"image\" src=\"../images/refuse.gif\" onclick=\"allow($m[id])\" style=\"border:0\" />":"<input type=\"image\" src=\"../images/allow.gif\" onclick=\"refuse($m[id])\" style=\"border:0\" />";


echo ($m['status']=='0')?"<img src=\"../images/refuse.gif\" onclick=\"allow($m[id])\" style=\"border:0\" />":"<img src=\"../images/allow.gif\" onclick=\"refuse($m[id])\" style=\"border:0\" />";
echo "</div>";
?>

</td>
                                  </tr>
									<?
								  }
								  ?>
                              </table>
							</form>
							  </td>
                            </tr>
                        </table>
						<? echo $pageinfo; ?>
						</td>
                      </tr>
                  </table></td>
                </tr>
              </table>
            <? } else { echo "没有信息";}?>          </td>
        </tr>
  <td width="13%">
      </table>
  <TR bgColor=#ffffff>
    <TD align=middle></TD></TR></TBODY></TABLE>
	
</body>
</html>
