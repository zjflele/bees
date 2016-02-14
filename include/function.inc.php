<?php

	/// <基本信息>
	///	<描述>
	///	独立函数库
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2004.5.14
	///	</最后修改日期>
	///	<版本>
	///	 1.0
	///	</版本>
	///	</基本信息>

	///	<描述>
	///	字符串截取
	///	</描述>
	function SubString($str,$start,$len=0xFFFFFFFF)
	{
		if($start<0)
		{
			$start = strlen($str) + $start;
		}
		if($len<0)
		{
			$len = strlen($str) - $start + $len;
		}
		$tmp="";
		$result="";
		$strlen=strlen($str);
		$begin=0;
		$subLen=0;
		for($i=0; $i<$start+$len && $i<$strlen; $i++)
		{
			if($i<$start)
			{
				if(ord($str[$i])>=161 && ord($str[$i])<=247 && ord($str[$i+1])>=161 && ord($str[$i+1])<=254)
					$i++;
			}
			else
			{
				$begin=$i;
				for(; $i<$start+$len && $i<$strlen; $i++)
				{
					if(ord($str[$i])>=161 && ord($str[$i])<=247 && ord($str[$i+1])>=161 && ord($str[$i+1])<=254)
						$i++;
				}
				return substr($str,$begin,$i-$begin);
			}
		}
	}
	
	///	<描述>
	///	字符串截取，汉字同字母同等对待。
	///	</描述>
	function Mid($str,$start,$len=0xFFFFFFFF)
	{
		$retVal = "";
		$tmpArr = array();
		$strlen = strlen($str);
		
		for($i = 0; $i < $strlen; $i++)
		{
			if(ord($str[$i]) < 128)
				$tmpArr[] = ord($str[$i]);
			else
				$tmpArr[] = ord($str[$i]) * 256 + ord($str[++$i]);
		}
		$tmpArrLen = count($tmpArr);

		if($start < 0)
			$start =$tmpArrLen + $start;
		if($len < 0)
			$len = $tmpArrLen - $start + $len;
		
		$end = $len + $start;
		$end = $tmpArrLen < $end ? $tmpArrLen : $end;

		for($i = $start; $i < $end; $i++)
		{
			if($tmpArr[$i]<128)
				$retVal .= chr($tmpArr[$i]);
			else
				$retVal .= chr($tmpArr[$i] / 256) .  chr($tmpArr[$i] % 256);
		}
		return $retVal;
	}


	///	<描述>
	///	某字符串 $needle 第一次出现处。找不到则返回-1
	///	</描述>
	function InString($haystack, $needle, $offset=0)
	{
		if($needle=="")
			return 0;
		$pos = strpos($haystack, $needle, $offset);
		if ($pos === false)
		{
			return -1;
		}
		else
		{
			return $pos;
		}
	}

	///	<描述>
	///	字符串替换函数，默认为替换<tag>外部字符
	///	</描述>
	function HTMLStrReplace($search,$replace,$subject,$type=true)
	{
		$len_search		= strlen($search);
		$len_replace	= strlen($replace);
		$len_subject	= strlen($subject);
		$returnStr		= $subject;
		$flag=false;
		for($i=0; $i<=$len_subject-$len_search; $i++)
		{
			if($returnStr[$i] == "<")
			{
				$flag=true;
				continue;
			}
			elseif($returnStr[$i] == ">")
			{
				$flag=false;
				continue;
			}
			if($flag==$type)
			{
				continue;
			}
			for($j=0; $j<$len_search; $j++)
			{
				if($returnStr[$i+$j]!=$search[$j])
					break;
			}
			if($j==$len_search)
			{
				$returnStr = substr($returnStr,0,$i) . $replace . substr($returnStr,$i+$len_search);
				$len_subject=strlen($returnStr);
				$i += $len_replace-$len_search;
			}
		}
		return $returnStr;
	}
	
	///	<描述>
	///	字符串分割函数，返回个数为$num 的数组
	///	</描述>
	function SplitEx($pattern, $string, $num=0, $defaultValue="")
	{
		if(!$num)
		{
			return split($pattern, $string);
		}
		$tempArr=split($pattern, $string, $num);
		for($i=count($tempArr);$i<$num; $i++)
			$tempArr[$i]=$defaultValue;
		return $tempArr;
	}
	///	<描述>
	///	检查某字符串是否在数组中
	///	</描述>
	function InArray($value,$arr)
	{
		$counts=count($arr);
		for($i=0; $i<$counts; $i++)
		{
			if($arr[$i]==$value)
				return $i;
		}
		return -1;
	}
	
	function Counts($table,$where)
	{
		$sql = "select count(*) counts from " . $table . " where " . $where;
		$obj = new EasyDB();
		$obj->SetSql($sql);
		$obj->Execute();
		$obj->FetchLine();
		return $obj->GetField('counts');
	}
	
	function GetImageZoomSize($imagePath, $width, $height)
	{
		if($imagePath{0}=="/")
			$imagePath = $_SERVER["DOCUMENT_ROOT"] . $imagePath;
		$info = getimagesize($imagePath);
		$arr = array();
		if($info[0]/$info[1] > $width/$height)
		{
			$arr[0] = $width;
			$arr[1] = intval($info[1] * $arr[0] / $info[0]);
		}
		else
		{
			$arr[1] = $height;
			$arr[0] = intval($info[0] * $arr[1] /$info[1]);
		}
		$arr[2] = "width=\"" . $arr[0] . "\" height=\"" . $arr[1] . "\"";
		return $arr;
	}

    function CreateShtml()
    {
        ob_start(array("callback_CreateShtml","callback_GoToShtml"));
    }

	function callback_CteateShtml($buffer)
	{
		$page = intval(@$_REQUEST["page"]);
		$shtml = new Shtml();
		$shtml->SetFileName($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF'],".php") . ($page==0 ? "" : "_" . strval($page)) . ".htm");
		$shtml->Templet = $buffer;
		$shtml->Create();
		return $buffer;
	}

	/*
	// 直接用文件操作版本
    function callback_CreateShtml($buffer)
    {
        $page = intval(@$_REQUEST["page"]);
        $fileName = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/" . basename($_SERVER['PHP_SELF'],".php") . ($page==0 ? "" : "_" . strval($page)) . ".htm";
        $fp = fopen($fileName,"wb");
        fwrite($fp,$buffer);
        fclose($fp);
        return $buffer;
    }
	*/

    function callback_GoToShtml($buffer)
    {
        $page = intval(@$_REQUEST["page"]);
        $fileName = basename($_SERVER['PHP_SELF'],".php") . ($page==0 ? "" : "_" . strval($page)) . ".htm";
        header("location:" . $fileName);
        return $buffer;
    }

    function GoToShtml()
    {
        $page = intval(@$_REQUEST["page"]);
        $fileName = basename($_SERVER['PHP_SELF'],".php") . ($page==0 ? "" : "_" . strval($page)) . ".htm";
        if(file_exists($fileName))
            header("location:" . $fileName);
    }
    
    function DeleteShtml($fileName=NULL)
    {
        if(is_null($fileName))
            $fileName = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF'];
            
        if($fileName[0]=="/")
            $fileName = $_SERVER['DOCUMENT_ROOT'] . $fileName;

        $path = dirname($fileName);
        $dir = dir($path);
        $patten = "/^" . basename($fileName, ".php") . "(_[0-9]+)?.htm/";
        while(($entry = $dir->read())!==false)
        {
            if(is_file($path . "/" .$entry) && preg_match($patten,$entry))
                unlink ($path . "/" . $entry);
        }
    }
	
?>