<?php
	include("../../include/include.php");
	checklogin();
	set_magic_quotes_runtime(0);
	if(@$_POST["title"])
	{
	//echo $templet;exit();
		$obj = new EasyDB(article);
		$obj->User["username"]		= $_SESSION["bees_UserName"];
		$obj->User["groupid"]		= $_SESSION["bees_UserGroup"];
		$obj->User["title"]		= $obj->Post["title"];
		$obj->User["author"]		= $obj->Post["author"];
		$obj->User["date"]	= $obj->Post["pubtime"];	
		$obj->User["fromweb"]	= $obj->Post["source"];		
    	$obj->User["text"]	= stripcslashes ($obj->Post["content"]);
		$obj->User["sort_id"]	= $obj->Post["sort_id"];	
		$obj->User["sort_f"]	= GetValueFromTable("idlist","sort","id=".$obj->Post["sort_id"]);
		$obj->User["news"]	= 0;
        $obj->User["url"]	= $url;		
		$obj->User["istop"]	= $obj->Post["istop"];	
		$obj->User["siteid"]	= $_SESSION['bees_SiteId'];	
		$obj->User["pass"]	= 1;	
		//print_r($_POST);exit;
		if(@$obj->Post["haveimage"]=="1")
		{		
			$imageArr = $obj->Post["imagelist"] ? explode("||", $obj->Post["imagelist"]) : array() ;
			foreach($imageArr as $key=>$value)
			{
				if(strpos($obj->User["text"],$value)!==false && CheckImageSize($value,100,100))
				{
					$obj->User["image"] = UrlEnCodeEx($value);
					break;
				}
			}
		}
		
		$obj->AcceptType="USER";
		if($obj->Insert())
		{
			$js = new Javascript();
			$js->Begin();
			$js->Alert("信息发布成功！");
			$js->GoToUrl($_SERVER["PHP_SELF"]);
			$js->End();
			
		}
		else
		{
			$js = new Javascript();
			$js->Begin();
			$js->Alert("信息发布失败！");
			$js->GoToUrl($_SERVER["PHP_SELF"]);
			$js->End();
		}
		exit();
	}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script language="JavaScript" type="text/JavaScript">
	var ifWhole=false;//是否为整体页面,当为true时包含<html><head></head><body></body></html>
    var pref=true; //是否为专业模式
	var dmtForm = document.form1;//提定所在的form
	function winopen(url)                    
     {                    
        window.open(url,"search","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=350,height=500,top=80,left=100");
}
function winopen2(url)                    
     {                    
        window.open(url,"search","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=520,height=320,top=80,left=100");
}
function winopen3(url,val)                    
{                    
    win = window.open(url,"search","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=620,height=500,top=80,left=100");
	win.document.all.quyu=document.all.quyu.value;
	win.DocOnLoad();
}
function CheckForm(theform)
{
	if(theform.title.value=="")
	{
		alert("请填写标题!");
		theform.title.focus();
		return false;
	}
	if(theform.sort_id.value=="")
	{
		alert("请填写分类!");
		theform.sort_id.focus();
		return false;
	}		
		
	editor.sync();
	if(theform.content.value=="")
	{
		alert("请填写内容!");		
		return false;
	}
	return true;
}
function CheckDate(DateString) 
{ 
  if (DateString==null) return false; 
  Dilimeter = '-'; 
  var tempy=''; 
  var tempm=''; 
  var tempd=''; 
  var tempArray; 
  if (DateString.length<8 && DateString.length>10) 
    return false;    
  tempArray = DateString.split(Dilimeter); 
  if (tempArray.length!=3) 
   return false; 
  if (tempArray[0].length==4) 
  { 
   tempy = tempArray[0]; 
   tempd = tempArray[2]; 
  } 
  else 
  { 
	return false;
  } 
  tempm = tempArray[1]; 
  var tDateString = tempy + '/'+tempm + '/'+tempd+' 8:0:0';//加八小时是因为我们处于东八区 
  var tempDate = new Date(tDateString); 
  if (isNaN(tempDate)) 
   return false; 
 if (((tempDate.getUTCFullYear()).toString()==tempy) && (tempDate.getMonth()==parseInt(tempm,10)-1) && (tempDate.getDate()==parseInt(tempd,10))) 
  { 
   return true; 
  } 
  else 
  { 
   return false; 
  } 
}	
	
function SetValue(name,value)
{
	theForm="document.forms[0]";
	if(arguments.length==3)
		theForm = arguments[2];
	theForm=eval(theForm);
	//alert(name.type);
	for(i=0;i<theForm.elements.length;i++)
	{

		if(theForm.elements[i].name==name)
		{
			//复选框
			if(theForm.elements[i].type=="checkbox")
			{				
				if(theForm.elements[i].value==value)
				{
					theForm.elements[i].checked=true;	
	
				}
			}

			//单选按钮
			if(theForm.elements[i].type=="radio")
			{				
				if(theForm.elements[i].value==value)
				{
					theForm.elements[i].checked=true;	
				}
			}

			//输入框
			if(theForm.elements[i].type=="text"||theForm.elements[i].type=="hidden")
			{
				theForm.elements[i].value=value;
			}

			//下拉列表
			if(theForm.elements[i].type=="select-one")
			{
				for(j=0;j<theForm.elements[i].length;j++)
				{
					if(theForm.elements[i][j].value==value)
					{
						theForm.elements[i][j].selected=true;
					}
				}
			}
			
			//--
		}
	}
	return;
}
</script>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="95%" align=center 
      border=0>
        <TBODY>
        <TR class=header align=left>
          <TD colspan="3">信息发布</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr> 
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" background="../image/bg007.jpg">
              <tr> 
                <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data"  name="form1" onSubmit="return CheckForm(document.form1)">
                  <td valign="top">
 
                    <table width="95%"  border="1" align="center" cellpadding="1" cellspacing="1" class="GreyBg2">
                      <tr class="GreyBg0"> 
                        <td class="px16B"><table width="97%"  border="0" cellpadding="0" cellspacing="1">
                            <tr> 
                              <td width="51">标题</td>
                              <td width="324"><input name="title" type="text" id="title" size="46"><font color="#FF0000"> * </font></td>
                              <td width="260"><input name="sort_id" type="text" id="sort_id" size="20" readonly="true">
                                <font color="#FF0000">* </font><a href="sort.php" target="_blank">选择栏目 </a></td>
                             <td> URL <input name="url" type="text" id="url" size="20"></td>  
                            </tr>
                          </table></td>
                      </tr>
                    
					   <tr class="GreyBg0">
					     <td align="center" class="px16B"><input type="submit" name="Button" value="确定" >
&nbsp;
<input type="reset" name="Reset" value="重置"></td>
					     </tr>
                      <tr> 
                        <td height="500">
                        <textarea id="content" name="content" style="width:100%;height:500px;"></textarea>
                        <script charset="utf-8" src="../../include/kindeditor/kindeditor.js"></script>
						<script charset="utf-8" src="../../include/kindeditor/lang/zh_CN.js"></script>
                        <script>
                                KindEditor.ready(function(K) {
                                        window.editor = K.create('#content',{uploadJson : '../../include/kindeditor/php/upload_json.php',
				fileManagerJson : '../../include/kindeditor/php/file_manager_json.php',allowFileManager : false});});
                        </script>
                        
						
						</td>
                      </tr>
                    </table></td>
                </form>
              </tr>
              <tr> 
                <td background="../image/bg008.jpg" height="17"><img src="../image/transparence.gif" width="1" height="1"></td>
              </tr>
            </table></td>
              </tr>
            </table>
				</td>
              </tr>
            </table>
		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
