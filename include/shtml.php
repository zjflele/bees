<?
	/// <基本信息>
	///	<描述>
	///	生成静态文件 
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2004.7.14
	///	</最后修改日期>
	///	<版本>
	///	 1.0
	///	</版本>
	///	</基本信息>
	class Shtml extends File
	{
		var $Templet;
		var $DataSource;
		var $Dir;
		
		function Shtml($fileName="")
		{
			File::File($fileName, "wb");
			$this->Templet		= "";
			$this->DataSource	= array();
			$this->Dir			= "";
		}
		
		///	<描述>
		///	绑定数据源，参数为一数组。
		///	</描述>
		function BindData($arr)
		{
			$this->DataSource = $arr;
		}
		
		///	<描述>
		///	设置文件存放路径。
		///	</描述>
		function SetDir($dir)
		{
			$this->Dir = $dir;
		}

		///	<描述>
		///	生成静态文件。
		///	</描述>
		function Create()
		{
			$tmp = $this->Templet;
			foreach($this->DataSource as $key=>$value)
			{
				$tmp = str_replace("<FIELD_" . $key . ">", $value, $tmp);
			}
			$this->MkDir(dirname($this->fileName));
			$this->Open();
			$this->Write($tmp);
			$this->Close();
			//exit();
			
		}
	}
?>