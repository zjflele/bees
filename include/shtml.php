<?
	/// <������Ϣ>
	///	<����>
	///	���ɾ�̬�ļ� 
	///	</����>
	///	<����>
	///	�����
	///	</����>
	///	<����޸�����>
	///	2004.7.14
	///	</����޸�����>
	///	<�汾>
	///	 1.0
	///	</�汾>
	///	</������Ϣ>
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
		
		///	<����>
		///	������Դ������Ϊһ���顣
		///	</����>
		function BindData($arr)
		{
			$this->DataSource = $arr;
		}
		
		///	<����>
		///	�����ļ����·����
		///	</����>
		function SetDir($dir)
		{
			$this->Dir = $dir;
		}

		///	<����>
		///	���ɾ�̬�ļ���
		///	</����>
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