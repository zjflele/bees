<?php
	/// <基本信息>
	///	<描述>
	///	所有类的基类
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2004.6.17
	///	</最后修改日期>
	///	<版本>
	///	 1.1
	///	</版本>
	///	</基本信息>
	class Obj
	{
		var $Debug;
		var $error;
		
		function Obj()
		{
			$this->Debug = false;
			$this->error = "";
		}
		function OnException()
		{
			if($this->Debug)
			{
				print "<pre>\n";
				print "程序执行过程中捕获到异常：\n\n";
				print "\t提示信息：" . $error . "\n";
				print "</pre>\n";
			}
			else
			{
				ob_clean();
				print "程序运行过程中出现错误。<br>\n";
				exit();
			}
		}
		///	<描述>
		///	将成员变量转换为数组。
		///	</描述>
		function ToArray($field, $spacer, $num=0)
		{
			if(!is_array($this->$field))
				$this->$field = SplitEx($spacer, $this->$field, $num);
		}
		
		///	<描述>
		///	将成员变量转换为整数。
		///	</描述>
		function ToInt($key)
		{
			$this->$key = intval($this->$key);
		}

		function GetError()
		{
			return $this->error;
		}
		function SetError($err)
		{
			$this->error = $err;
		}
		function ClearError()
		{
			$this->error = "";
		}
	}
?>