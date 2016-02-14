<?php

	/// <基本信息>
	///	<描述>
	///	字符串处理类
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2004.5.17
	///	</最后修改日期>
	///	<版本>
	///	 1.0
	///	</版本>
	///	</基本信息>

	class String extends Obj
	{
		var $value;
		
		function String($value="")
		{
			Obj::Obj();
			$this->value=strval($value);
		}
		
		function ToString()
		{
			return $this->value;
		}
		function GetValue()
		{
			return $this->value;
		}
		function SetValue($value)
		{
			return $this->value=strval($value);
		}
		function SubString($start, $len=0xFFFFFFFF)
		{
			return SubString($this->$value, $start, $len);
		}
		function Mid($start, $len=0xFFFFFFFF)
		{
			return SubString($this->$value, $start, $len);
		}
		function InString($needle, $offset=0)
		{
			return InString($this->$value, $needle, $offset);
		}
		function HTMLStrReplace($search, $replace, $type=true)
		{
			return HTMLStrReplace($search, $replace, $this->value, $type);
		}
		function SplitEx($pattern, $num=0, $expString="")
		{
			return SplitEx($pattern, $this->value, $num=0, $expString="");
		}
		
	}
	
?>