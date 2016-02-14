<?
//登陆页面
include("../include/include.php");

$checkNum = 3;
$maxTime = 600;
$Hbly_User_Login_Log = @array_filter(explode(';', $_SESSION["Hbly_Wutaishan_User_Login_Log"]));
//print_r($Hbly_User_Login_Log);

if (count($Hbly_User_Login_Log) >= $checkNum) {
    if (($Hbly_User_Login_Log[count($Hbly_User_Login_Log) - 1] - $Hbly_User_Login_Log[1]) < $maxTime) {

        $js = new javascript();
        $js->begin();
        $js->alert("输入错误次数超过限制，请稍等再试！");
//$js->GoBack();
        $js->end();
        $notAllowPost = 1;
    } else {
        unset($_SESSION["Hbly_Wutaishan_User_Login_Log"]);
    }
}

if ($_POST["username"] && !$notAllowPost) {
//MYSQL_QUERY("SET NAMES gb2312");
    $username = addslashes(trim($_POST["username"]));
    $sqlstr = "select * from " . TABLEPRE . "users where username = '$username'";
//echo $sqlstr;	 
    $myrs = mysql_query($sqlstr, $myconn);
    $nums = mysql_num_rows($myrs);
//echo $nums; 
    $rec = mysql_fetch_array($myrs);

    if ($nums > 0 and $rec[PASSWORD] == md5($_POST["password"])) {
        
        $status = GetValueFromTable("status", "usergroup", "id=" . $rec[groupid]);
        if ($status == 0 && $rec[groupid] > 0) {
            $js = new javascript();
            $js->begin();
            $js->alert("对不起，该用户已经被停用!");
            $js->GoBack();
            $js->end();
        }
        
        $obj = new EasyDB("USERS");
        
        
        $obj->AddSession("bees_UserId", $rec["userid"]);  //用户id   
       
        $obj->AddSession("bees_UserName", $rec["username"]);  //用户名
        $obj->AddSession("bees_Md5Key", md5(MD5_KEY . $rec["username"]));  //加密串
        $obj->AddSession("bees_UserGroup", $rec["groupid"]);  //用户组ID
        $obj->AddSession("bees_UserRealName", $rec["zname"]);  //真实姓名
        $obj->AddSession("bees_MySortId", $rec["my_sort"]);  //城市ID
        $obj->AddSession("bees_CityId", $rec["cityid"]);  //城市ID
        $obj->AddSession("bees_SiteId", ($rec["cityid"]) ? $rec["userid"] : 0);
        $obj->AddSession("Login", true);
       
        
        $js = new javascript();
        $js->begin();
        $js->GoToUrl("index.php");
        $js->end();
    } ELSE {
        $obj = new EasyDB(TABLEPRE . "USERS");
        $obj->AddSession("Hbly_Wutaishan_User_Login_Log", $_SESSION["Hbly_Wutaishan_User_Login_Log"] . ';' . time());
        $js = new javascript();
        $js->begin();
        $js->alert("用户名密码错误!");
        $js->end();
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>
<?=TITLE?>
</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<STYLE>

.input_login {
	BORDER-RIGHT: #ffffff 0px solid; BORDER-TOP: #ffffff 0px solid; FONT-SIZE: 9pt; BORDER-LEFT: #ffffff 0px solid; BORDER-BOTTOM: #ffffff 0px solid; HEIGHT: 16px
}
</STYLE>
<link href="login.css" rel="stylesheet" type="text/css" />

</HEAD>
<BODY>
<SCRIPT language=javascript>

function CheckForm(theForm)
{
	if (theForm.username.value=="")
	{
		alert("用户名不能为空，请重新输入！");
		document.username.focus();
		return false;
	}
	if (theForm.password.value=="")
	{
        alert("密码不能为空，请重新输入！");
		theForm.password.focus();
		return false;
    }
	return true;
}

</SCRIPT>
<CENTER>
<table width="600" border="0" cellpadding="8" cellspacing="0" class="logintable">
<tr class="loginheader"><td width="80"></td><td width="100"></td><td></td><td width="120"></td><td width="80"></td></tr>
<tr style="height:40px"><td>&nbsp;</td>
<td class="line1"><span style="color:#ffff66;font-size:14px;font-weight: bold;">后台管理</span></td>
<td class="line1">&nbsp;</td>
<td class="line1">&nbsp;</td>
<td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td>&nbsp;</td></tr>
<form method="post" name="login" action="login.php" onSubmit="return CheckForm(this);"><tr><td>&nbsp;</td><td align="right">用户名:</td><td><input name="username" type="text" id="username" size="25" style="width:170px;height:19px;" /></td>
<td></td>
<td>&nbsp;</td></tr><tr><td>&nbsp;</td><td align="right">密&nbsp;&nbsp;&nbsp;&nbsp;码:</td><td><input name="password" type="password" id="password" size="25" style="width:170px;height:19px;"></td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td class="line1">&nbsp;</td><td class="line1" align="center"><input type="submit" class="button" value="提 交" /></td><td class="line1">&nbsp;</td><td>&nbsp;</td></tr></form><tr><td>&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td>&nbsp;</td></tr>
<tr>
  <td colspan="5" align="center">Powered by <b>Bees</b>
&nbsp;&copy; 2015-2015</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table>
 
</CENTER></BO
