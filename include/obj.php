<?php
	/// <������Ϣ>
	///	<����>
	///	������Ļ���
	///	</����>
	///	<����>
	///	�����
	///	</����>
	///	<����޸�����>
	///	2004.6.17
	///	</����޸�����>
	///	<�汾>
	///	 1.1
	///	</�汾>
	///	</������Ϣ>
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
				print "����ִ�й����в����쳣��\n\n";
				print "\t��ʾ��Ϣ��" . $error . "\n";
				print "</pre>\n";
			}
			else
			{
				ob_clean();
				print "�������й����г��ִ���<br>\n";
				exit();
			}
		}
		///	<����>
		///	����Ա����ת��Ϊ���顣
		///	</����>
		function ToArray($field, $spacer, $num=0)
		{
			if(!is_array($this->$field))
				$this->$field = SplitEx($spacer, $this->$field, $num);
		}
		
		///	<����>
		///	����Ա����ת��Ϊ������
		///	</����>
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