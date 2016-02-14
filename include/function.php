<?
 function checklogin()
 {
   if (!($_SESSION["Login"]==true && $_SESSION["bees_UserName"]!='' && $_SESSION["bees_Md5Key"]==md5(MD5_KEY.$_SESSION["bees_UserName"])))
   {
	   header("Location:../admin/login.php");   
   }
 }
 
 function CreateFileName()
{
		list($usec, $sec) = explode(" ", microtime());
		return date("YmdHis", $sec) . sprintf("%06d", ($usec * 1000000));
}
function CreateSelectOption($arr,$nk)
{
	if ($arr){
		foreach ($arr as $k => $v){
			if ($nk==$k){
				$opts.="<option value='$k' selected='selected'>$v</option>";
			}else{
				$opts.="<option value='$k'>$v</option>";
				
			}
		}
	}
	echo $opts;
}
//从表中取得某字段
	function GetValueFromTable($fieldName, $tableName, $where)
	{
		global $db;
                if (strpos($tableName, TABLEPRE)===FALSE) $tableName = TABLEPRE.$tableName;
		$sql = "select " . $fieldName . " from " . $tableName . " where " . $where;
		return $db->getOne($sql);		
	}
	function ShowTemplate()
	{
		$obj = new Page(TEMPLET);
		$obj->Fields = "id,name";
		$obj->ShowTitle=false;
		$obj->RowTemplet = "<option value=\"<FIELD_id>\"><FIELD_name></option>\n";
		$obj->Open();
		//$obj->Select();
		$obj->ShowContent();
	}
	function getSqlList($sql){
		$result=mysql_query($sql);
		while($myrow=mysql_fetch_assoc($result))
		{
			$arrList[] = $myrow;
		}
		return $arrList;
	}
//------------------------------------------截取字符串-------------
function getsubtext($str,$count)    
{
 $skip=0;
 $j=0;
 for($i=0;$i<strlen($str);$i++)
 {
  $t=substr($str,$i,1);
  if($skip==0){
   if(ord($t)>127){
    $skip=1;
    $a[]=substr($str,$i,2);
   }
   else
   {
    $a[]=$t;
   }
  }
  else{
   $skip=0;
  }
  if(count($a)>=$count){   
   break;
  }
 }
 while(list($k,$v)=each($a))
 {
  $s.=$v;
 }
 return $s;
}	

function mysubstr($str, $start, $len,&$isn=0) {
    $tmpstr = "";
    $strlen = $start + $len;
    for($i = $start; $i < $strlen; $i++) {
        if(ord(substr($str, $i, 1)) > 0xa0) {
            $tmpstr .= substr($str, $i, 2);
            $i++;
        } else {
            $tmpstr .= substr($str, $i, 1);
			$isn +=1;
		}
    }
    return $tmpstr;
}

//---------容量统计------	
	function sizecount($filesize) {
	if($filesize>=1024000000){
		$filesize=round($filesize/1024000000*100)/100 ."G";
	}elseif($filesize>=1024000){
		$filesize=round($filesize/1024000*100)/100 .'M';
	}elseif($filesize>=1024){
		$filesize=round($filesize/1024*100)/100 .'K';
	}else{
		$filesize=$filesize.'bytes';
	}
	return $filesize;
}	

function get_extend($file_name)
{
	$extend =explode("." , $file_name);
	$va=count($extend)-1;
	return $extend[$va];
}

function MakeDirectory($dir, $mode = 0777)
{
	  if (is_dir($dir) || @mkdir($dir,$mode)) return TRUE;
	  if (!MakeDirectory(dirname($dir),$mode)) return FALSE;
	  return @mkdir($dir,$mode);
}

function formatUser($users){
	$arrUser = explode(",",$users);
		if ($arrUser){
			foreach ($arrUser as $key => $u){
				if (!$key)
					$username="'".$u."'";
				else
					$username.=",'".$u."'";
			}
		}
	return $username;
}

//判断提交是否正确
function submitcheck($var) {
	if(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
		if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST']))) {
			return true;
		} else {
			echo "提交错误";
			return false;
		}
	} else {
		return false;
	}
}

//添加数据
function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
	global $db;
        if (strpos($tablename, TABLEPRE)===FALSE) $tablename = TABLEPRE.$tablename;
	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$db->query($method.' INTO '.$tablename.' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent?'SILENT':'');
	if($returnid && !$replace) {
		return $db->insert_id();
	}
}

//更新数据
function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) {
	global $db;
        
        if (strpos($tablename, TABLEPRE)===FALSE) $tablename = TABLEPRE.$tablename;
	$setsql = $comma = '';
	foreach ($setsqlarr as $set_key => $set_value) {
		$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)) {
		$where = '1';
	} elseif(is_array($wheresqlarr)) {
		foreach ($wheresqlarr as $key => $value) {
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	} else {
		$where = $wheresqlarr;
	}
	$db->query('UPDATE '.$tablename.' SET '.$setsql.' WHERE '.$where, $silent?'SILENT':'');
}

//得到数据集
function getlist($sql){
	global $db;
	$rs = $db->Execute($sql);
	while ($arr = $rs->fetchRow())
	{
		$arrList[] = $arr;
	}
	
	return $arrList;
}

//得到单条数据集
function getrow($sql){
	global $db;
	return $db->GetRow($sql);	
}

//得到总条数
function get_total_num($sql){
	global $db;
	$rs = $db->query($sql);
	$totalnum = $rs->NumRows();
	return $totalnum;
}

//得到会员列表
function getUserList(){
	global $db;
	$rs = $db->Execute("SELECT * FROM ".TABLEPRE."users ");
	while ($arr = $rs->fetchRow())
	{
		$arrList[$arr['userid']] = $arr;
	}
	
	return $arrList;
}

function alertmessage($message,$t=1,$url='',$top='0'){
	echo "<script>";
	if ($message){
		echo "alert('".$message."');";
	}
	$parent = ($top)?'.parent':'';
	if ($t==1) 
		echo "window".$parent.".location.href=\"".$url."\";";
	if ($t==2)
		echo "history.back();";
	//else
		//echo "window".$parent.".location.reload();";
	echo "</script>";
}
if (!function_exists('pageft')){
	function pageft($totle,$displaypg=20,$url=''){
		//定义几个全局变量： 
		//$page：当前页码；
		//$firstcount：（数据库）查询的起始项；
		//$pagenav：页面导航条代码，函数内部并没有将它输出；
		//$_SERVER：读取本页URL“$_SERVER["REQUEST_URI"]”所必须。
		global $page,$firstcount,$pagenav,$_SERVER;

		if(!$page) $page=1;

		//如果$url使用默认，即空值，则赋值为本页URL：
		if(!$url){ $url=$_SERVER["REQUEST_URI"];}

		//URL分析：
		$parse_url=parse_url($url);
		$url_query=$parse_url["query"]; //单独取出URL的查询字串
		if($url_query){
		//因为URL中可能包含了页码信息，我们要把它去掉，以便加入新的页码信息。	
		$url_query=ereg_replace("(^|&)page=$page","",$url_query);

		//将处理后的URL的查询字串替换原来的URL的查询字串：
		$url=str_replace($parse_url["query"],$url_query,$url);

		//在URL后加page查询信息，但待赋值： 
		if($url_query) $url.="&page"; else $url.="page";
		}else {
		$url.="?page";
		}
		
		$lastpg=ceil($totle/$displaypg); //最后页，也是总页数
		$page=min($lastpg,$page);
		$prepg=$page-1; //上一页
		$nextpg=($page==$lastpg ? 0 : $page+1); //下一页
		$firstcount=($page-1)*$displaypg;

		//开始分页导航条代码：
		$pagenav="显示第 <B>".($totle?($firstcount+1):0)."</B>-<B>".min($firstcount+$displaypg,$totle)."</B> 条记录，共 $totle 条记录 ";
		//如果只有一页则跳出函数：
		if($lastpg<=1) return false;

		$pagenav.=" [<a href='$url=1'>首页</a>] ";
		if($prepg) $pagenav.=" [<a href='$url=$prepg'>上一页</a>] "; else $pagenav.=" [上一页] ";
		if($nextpg) $pagenav.=" [<a href='$url=$nextpg'>下一页</a>] "; else $pagenav.=" [下一页] ";
		$pagenav.=" [<a href='$url=$lastpg'>尾页</a>] ";

		//下拉跳转列表，循环列出所有页码：
		$pagenav.="　到第 <select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n";
		for($i=1;$i<=$lastpg;$i++){
		if($i==$page) $pagenav.="<option value='$i' selected>$i</option>\n";
		else $pagenav.="<option value='$i'>$i</option>\n";
		}
		$pagenav.="</select> 页，共 $lastpg 页";

		return $pagenav;
	}
}

function array_remove_empty(& $arr, $trim = true)   {   
	foreach ($arr as $key => $value) {   
		if (is_array($value)) {   
			array_remove_empty($arr[$key]);   
		} else {   
			$value = trim($value);   
			if ($value == '') {   unset($arr[$key]);   } elseif ($trim) {   $arr[$key] = $value;   }   
		}  
	}   
} 

//----------------------------------信息分类-----------
	function ShowType_news($pid=1)
	{
		$sql="select * from  ".TABLEPRE."sort  where parentid='$pid' and id in (".$_SESSION['bees_MySortId'].") ";
		$sql.=" order by top, id";

		$result=mysql_query($sql);
		while($myrow=mysql_fetch_array($result))
		{
			if(!$myrow["yn_mo"])
			{
				echo "<option value=\"".$myrow["id"]."\">" . str_pad("", 2*($myrow["hight"]-1) , "　") . "**" . $myrow["name"] . "</option>\n";
				ShowType_news($myrow["id"]); //如果有子分类 
			}
			else	//如果没有子分类
			{
				echo "<option value=\"".$myrow["id"]."\">" . str_pad("", 2*($myrow["hight"]-1) , "　") . $myrow["name"] . "</option>\n";
				ShowType_news($myrow["id"]);
			}
		}
	}

//----------------------------------是否为整数及是否大于2-----------		
	function isints($num) { 
		if(eregi("^[0-9]{1,2}$",$num) && $num>=2){ 
			return $num; 
		} 
	}
	
//----------------------------------列表页-----------	
function get_sort_list_by_sortid($id){
	global $db;		
	$sql = "select * from ".TABLEPRE."sort where id=" . $id;
	$arrSort = $db->getRow($sql);
	if ($arrSort['hight']==1){ //一级目录
		$class = ($arrSort['id']==$id)?'active':'';
		$text = "<a href='list_news.php?sortid=".$arrSort['id']."' class='$class'>".$arrSort['name']."</a> ";
		$sql = "select id,name from ".TABLEPRE."sort where parentid=" . $arrSort['id'];
		$rs = $db->Execute($sql);
		while ($rec = $rs->fetchRow())
		{
			$class = ($rec['id']==$id)?'active':'';
			$text.= " <a href='list_news.php?sortid=".$rec['id']."' class='$class'>[".$rec['name']."]</a>";
		}
	}elseif ($arrSort['hight']==2){ //二级目录
		$arr1 = $db->getRow("select id,name from ".TABLEPRE."sort where id=".$arrSort['parentid']);
		$class = ($arr1['id']==$id)?'active':'';
		$text = "<a href='list_news.php?sortid=".$arr1['id']."' class='$class'><strong>".$arr1['name']."</strong></a> ";
		$sql = "select id,name from ".TABLEPRE."sort where parentid=" . $arr1['id'];
		$rs = $db->Execute($sql);
		while ($rec = $rs->fetchRow())
		{
			$class = ($rec['id']==$id)?'active_sub':'';
			$text.= " <a href='list_news.php?sortid=".$rec['id']."' class='$class'>[".$rec['name']."]</a>";
		}			
	}

	return $text;
	//print_r($arrSort);	
}


function getLunarCalendar($year, $month, $day) {
	// 农历每月的天数
	$everymonth = array(0 => array(8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 29, 30, 7, 1),
	1 => array(0, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 0, 8, 2),
	2 => array(0, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 0, 9, 3),
	3 => array(5, 29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 10, 4),
	4 => array(0, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 0, 1, 5),
	5 => array(0, 30, 30, 29, 30, 30, 29, 29, 30, 29, 30, 29, 30, 0, 2, 6),
	6 => array(4, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 30, 3, 7),
	7 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 4, 8),
	8 => array(0, 30, 29, 29, 30, 30, 29, 30, 29, 30, 30, 29, 30, 0, 5, 9),
	9 => array(2, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 30, 6, 10),
	10 => array(0, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 0, 7, 11),
	11 => array(6, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 8, 12),
	12 => array(0, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 0, 9, 1),
	13 => array(0, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 0, 10, 2),
	14 => array(5, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 29, 30, 1, 3),
	15 => array(0, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 0, 2, 4),
	16 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 3, 5),
	17 => array(2, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 4, 6),
	18 => array(0, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 0, 5, 7),
	19 => array(7, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 30, 6, 8),
	20 => array(0, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 0, 7, 9),
	21 => array(0, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 0, 8, 10),
	22 => array(5, 30, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 9, 11),
	23 => array(0, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 0, 10, 12),
	24 => array(0, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 29, 0, 1, 1),
	25 => array(4, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 2, 2),
	26 => array(0, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 3, 3),
	27 => array(0, 30, 29, 29, 30, 29, 30, 29, 30, 29, 30, 30, 30, 0, 4, 4),
	28 => array(2, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 30, 5, 5),
	29 => array(0, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 0, 6, 6),
	30 => array(6, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 7, 7),
	31 => array(0, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 0, 8, 8),
	32 => array(0, 30, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 0, 9, 9),
	33 => array(5, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 10, 10),
	34 => array(0, 29, 30, 29, 30, 30, 29, 30, 29, 30, 30, 29, 30, 0, 1, 11),
	35 => array(0, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 2, 12),
	36 => array(3, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 30, 29, 3, 1),
	37 => array(0, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 0, 4, 2),
	38 => array(7, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 5, 3),
	39 => array(0, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 29, 30, 0, 6, 4),
	40 => array(0, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 0, 7, 5),
	41 => array(6, 30, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 8, 6),
	42 => array(0, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 0, 9, 7),
	43 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 10, 8),
	44 => array(4, 30, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 1, 9),
	45 => array(0, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 30, 0, 2, 10),
	46 => array(0, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 0, 3, 11),
	47 => array(2, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 4, 12),
	48 => array(0, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 0, 5, 1),
	49 => array(7, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 6, 2),
	50 => array(0, 29, 30, 30, 29, 30, 30, 29, 29, 30, 29, 30, 29, 0, 7, 3),
	51 => array(0, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 0, 8, 4),
	52 => array(5, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 9, 5),
	53 => array(0, 29, 30, 29, 29, 30, 30, 29, 30, 30, 29, 30, 29, 0, 10, 6),
	54 => array(0, 30, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 0, 1, 7),
	55 => array(3, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 2, 8),
	56 => array(0, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 0, 3, 9),
	57 => array(8, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 29, 4, 10),
	58 => array(0, 30, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 0, 5, 11),
	59 => array(0, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 0, 6, 12),
	60 => array(6, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 7, 1),
	61 => array(0, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 0, 8, 2),
	62 => array(0, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 9, 3),
	63 => array(4, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 10, 4),
	64 => array(0, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 0, 1, 5),
	65 => array(0, 29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 0, 2, 6),
	66 => array(3, 30, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 3, 7),
	67 => array(0, 30, 30, 29, 30, 30, 29, 29, 30, 29, 30, 29, 30, 0, 4, 8),
	68 => array(7, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 5, 9),
	69 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 6, 10),
	70 => array(0, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 0, 7, 11),
	71 => array(5, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29, 30, 8, 12),
	72 => array(0, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 0, 9, 1),
	73 => array(0, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 0, 10, 2),
	74 => array(4, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 1, 3),
	75 => array(0, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 0, 2, 4),
	76 => array(8, 30, 30, 29, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 3, 5),
	77 => array(0, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 29, 0, 4, 6),
	78 => array(0, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 5, 7),
	79 => array(6, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 6, 8),
	80 => array(0, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 0, 7, 9),
	81 => array(0, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 0, 8, 10),
	82 => array(4, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 9, 11),
	83 => array(0, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 0, 10, 12),
	84 => array(10, 30, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 1, 1),
	85 => array(0, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 0, 2, 2),
	86 => array(0, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 29, 0, 3, 3),
	87 => array(6, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 29, 4, 4),
	88 => array(0, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 5, 5),
	89 => array(0, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 30, 0, 6, 6),
	90 => array(5, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 30, 7, 7),
	91 => array(0, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 0, 8, 8),
	92 => array(0, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 0, 9, 9),
	93 => array(3, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 10, 10),
	94 => array(0, 30, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 0, 1, 11),
	95 => array(8, 29, 30, 30, 29, 30, 29, 30, 30, 29, 29, 30, 29, 30, 2, 12),
	96 => array(0, 29, 30, 29, 30, 30, 29, 30, 29, 30, 30, 29, 29, 0, 3, 1),
	97 => array(0, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 0, 4, 2),
	98 => array(5, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30, 29, 30, 5, 3),
	99 => array(0, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 0, 6, 4),
	100 => array(0, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 0, 7, 5),
	101 => array(4, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 8, 6),
	102 => array(0, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 0, 9, 7),
	103 => array(0, 30, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 0, 10, 8),
	104 => array(2, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 1, 9),
	105 => array(0, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 0, 2, 10),
	106 => array(7, 30, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 3, 11),
	107 => array(0, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 30, 0, 4, 12),
	108 => array(0, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 0, 5, 1),
	109 => array(5, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 6, 2),
	110 => array(0, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 0, 7, 3),
	111 => array(0, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 0, 8, 4),
	112 => array(4, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 9, 5),
	113 => array(0, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 0, 10, 6),
	114 => array(9, 29, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 1, 7),
	115 => array(0, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 30, 29, 0, 2, 8),
	116 => array(0, 30, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 0, 3, 9),
	117 => array(6, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30, 4, 10),
	118 => array(0, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 0, 5, 11),
	119 => array(0, 30, 29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 0, 6, 12),
	120 => array(4, 29, 30, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 7, 1)
	);

	// 农历天干
	$mten = array("null", "甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸");
	// 农历地支
	$mtwelve = array("null", "子", "丑", "寅", "卯", "辰",
	"巳", "午", "未", "申", "酉", "戌", "亥");
	// 农历月份
	$mmonth = array("闰", "正", "二", "三", "四", "五", "六",
	"七", "八", "九", "十", "十一", "十二", "月");
	// 农历日
	$mday = array("null", "初一", "初二", "初三", "初四", "初五", "初六", "初七", "初八", "初九", "初十",
	"十一", "十二", "十三", "十四", "十五", "十六", "十七", "十八", "十九", "二十",
	"廿一", "廿二", "廿三", "廿四", "廿五", "廿六", "廿七", "廿八", "廿九", "三十");

	// 星期
	$weekday = array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
	// 阳历总天数 至1900年12月21日
	$total = 11;

	// 阴历总天数
	$mtotal = 0;
	$year = intval($year);
	$month = intval($month);
	$day = intval($day);

	if ($year < 1901 || $year > 2020 || $month < 1 || $month > 12 || $day < 1 || $day > 31) {
	exit("年份或者格式出错，年份只支持1901到2020!");
	}

	// 获得日期时间戳
	$postDate = mktime(0, 0, 0, $month, $day, $year);

	$thisDay = getdate($postDate);

	//print_R($thisDay);exit;

	$cur_wday = $thisDay["wday"];

	for($y = 1901; $y < $thisDay["year"]; $y++) {
	// 计算到所求日期阳历的总天数-自1900年12月21日始,先算年的和
	$total += 365;
	if ($y % 4 == 0){
	$total++;
	}
	} 

	switch ($thisDay["mon"]) { // 再加当年的几个月
	case 12:
	$total += 30;
	case 11:
	$total += 31;
	case 10:
	$total += 30;
	case 9:
	$total += 31;
	case 8:
	$total += 31;
	case 7:
	$total += 30;
	case 6:
	$total += 31;
	case 5:
	$total += 30;
	case 4:
	$total += 31;
	case 3:
	$total += 28;
	case 2:
	$total += 31;
	} 

	if ($thisDay["year"] % 4 == 0 && $thisDay["mon"] > 2) {
	$total++; //如果当年是闰年还要加一天
	}

	$total = $total + $thisDay["mday"]-1; //加当月的天数

	$flag = 0; //判断跳出循环的条件
	$j = 0;
	while ($j <= 120) { // 用农历的天数累加来判断是否超过阳历的天数
	$i = 1;
	while ($i <= 13) {
	$mtotal += $everymonth[$j][$i];
	if ($mtotal >= $total) {
	$flag = 1;
	break;
	}
	$i++;
	}
	if ($flag == 1) break;
	$j++;
	}

	if ($everymonth[$j][0] <> 0 && $everymonth[$j][0] < $i) {
	//对闰月修补
	$mm = $i-1;
	} else {
	$mm = $i;
	} 

	if ($i == $everymonth[$j][0] + 1 && $everymonth[$j][0] <> 0) {
	$nlmon = $mmonth[0] . $mmonth[$mm]; #闰月
	$numMonth = $mm;//输出农历数字格式月份
	} else {
	$nlmon = $mmonth[$mm] . $mmonth[13];
	$numMonth = $mm;
	}
	// 计算所求月份1号的农历日期
	$md = $everymonth[$j][$i] - ($mtotal - $total);
	if ($md > $everymonth[$j][$i]) {
	$md -= $everymonth[$j][$i];
	}
	$nlday = $mday[$md];
	$numDay = $md;//输出农历数字格式日期

	$nowday = date("Y年n月j日 ", $postDate) . $weekday[$cur_wday]."
	".$mten[$everymonth[$j][14]].$mtwelve[$everymonth[$j][15]]."年".$nlmon.$nlday;
	$lunarCalendar = array("year"=>$year,
	"yearname"=>$mten[$everymonth[$j][14]] . $mtwelve[$everymonth[$j][15]],
	"displaymonth"=>$nlmon,
	"displayday"=>$nlday,
	"displayweek"=>$weekday[$cur_wday],
	"month"=>$numMonth,
	"day"=>$numDay);
	return $lunarCalendar;
}

function cutstr($string, $length, $dot = ' ...') {
	if(strlen($string) <= $length) {
		return $string;
	}

	$pre = chr(1);
	$end = chr(1);
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

	$strcut = '';
	if(strtolower(CHARSET) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	$pos = strrpos($s, chr(1));
	if($pos !== false) {
		$strcut = substr($s,0,$pos);
	}
	return $strcut.$dot;
}

function CreateSelect($name,$arr,$value,$width=90,$onEvent='')
{
	$selects = "<select name='$name' id='$name' style='width:".$width."px;' {$onEvent}>";	
	if ($arr){
		foreach ($arr as $k => $v){
			$selected = ($k==$value)?'selected':'';
			$selects.="<option value='$k' $selected>$v</option>";
		}
	}
	$selects .= "</select>";
	return $selects;
}

//跨站脚本过滤
function RemoveXSS($val) { 
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed 
   // this prevents some character re-spacing such as <java\0script> 
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs 
   $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val); 
    
   // straight replacements, the user should never need these since they're normal characters 
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29> 
   $search = 'abcdefghijklmnopqrstuvwxyz'; 
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   $search .= '1234567890!@#$%^&*()'; 
   $search .= '~`";:?+/={}[]-_|\'\\'; 
   for ($i = 0; $i < strlen($search); $i++) { 
      // ;? matches the ;, which is optional 
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 
    
      // &#x0040 @ search for the hex values 
      $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ; 
      // &#00064 @ 0{0,7} matches '0' zero to seven times 
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ; 
   } 
    
   // now the only remaining whitespace attacks are \t, \n, and \r 
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'); 
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
   $ra = array_merge($ra1, $ra2); 
    
   $found = true; // keep replacing as long as the previous round replaced something 
   while ($found == true) { 
      $val_before = $val; 
      for ($i = 0; $i < sizeof($ra); $i++) { 
         $pattern = '/'; 
         for ($j = 0; $j < strlen($ra[$i]); $j++) { 
            if ($j > 0) { 
               $pattern .= '('; 
               $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?'; 
               $pattern .= '|(&#0{0,8}([9][10][13]);?)?'; 
               $pattern .= ')?'; 
            } 
            $pattern .= $ra[$i][$j]; 
         } 
         $pattern .= '/i'; 
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag 
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags 
         if ($val_before == $val) { 
            // no replacements were made, so exit the loop 
            $found = false; 
         } 
      } 
   }
   return addslashes($val);
} 
?>