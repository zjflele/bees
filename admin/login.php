<?
//��½ҳ��
include("../include/include.php");

$checkNum = 3;
$maxTime = 600;
$Hbly_User_Login_Log = @array_filter(explode(';', $_SESSION["Hbly_Wutaishan_User_Login_Log"]));
//print_r($Hbly_User_Login_Log);

if (count($Hbly_User_Login_Log) >= $checkNum) {
    if (($Hbly_User_Login_Log[count($Hbly_User_Login_Log) - 1] - $Hbly_User_Login_Log[1]) < $maxTime) {

        $js = new javascript();
        $js->begin();
        $js->alert("�����������������ƣ����Ե����ԣ�");
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
            $js->alert("�Բ��𣬸��û��Ѿ���ͣ��!");
            $js->GoBack();
            $js->end();
        }
        
        $obj = new EasyDB("USERS");
        
        
        $obj->AddSession("bees_UserId", $rec["userid"]);  //�û�id   
       
        $obj->AddSession("bees_UserName", $rec["username"]);  //�û���
        $obj->AddSession("bees_Md5Key", md5(MD5_KEY . $rec["username"]));  //���ܴ�
        $obj->AddSession("bees_UserGroup", $rec["groupid"]);  //�û���ID
        $obj->AddSession("bees_UserRealName", $rec["zname"]);  //��ʵ����
        $obj->AddSession("bees_MySortId", $rec["my_sort"]);  //����ID
        $obj->AddSession("bees_CityId", $rec["cityid"]);  //����ID
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
        $js->alert("�û����������!");
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
		alert("�û�������Ϊ�գ����������룡");
		document.username.focus();
		return false;
	}
	if (theForm.password.value=="")
	{
        alert("���벻��Ϊ�գ����������룡");
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
<td class="line1"><span style="color:#ffff66;font-size:14px;font-weight: bold;">��̨����</span></td>
<td class="line1">&nbsp;</td>
<td class="line1">&nbsp;</td>
<td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td>&nbsp;</td></tr>
<form method="post" name="login" action="login.php" onSubmit="return CheckForm(this);"><tr><td>&nbsp;</td><td align="right">�û���:</td><td><input name="username" type="text" id="username" size="25" style="width:170px;height:19px;" /></td>
<td></td>
<td>&nbsp;</td></tr><tr><td>&nbsp;</td><td align="right">��&nbsp;&nbsp;&nbsp;&nbsp;��:</td><td><input name="password" type="password" id="password" size="25" style="width:170px;height:19px;"></td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td class="line1">&nbsp;</td><td class="line1" align="center"><input type="submit" class="button" value="�� ��" /></td><td class="line1">&nbsp;</td><td>&nbsp;</td></tr></form><tr><td>&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td>&nbsp;</td></tr>
<tr>
  <td colspan="5" align="center">Powered by <b>Bees</b>
&nbsp;&copy; 2015-2015</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table>
 
</CENTER></BO
