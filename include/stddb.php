<?
	/// <������Ϣ>
	///	<����>
	///	�Զ�ɨ��������в������ݿ� 
	///	</����>
	///	<����>
	///	�����
	///	</����>
	///	<����޸�����>
	///	2004.9.3
	///	</����޸�����>
	///	<�汾>
	///	 2.5
	///	</�汾>
	///	</������Ϣ>

	class StdDB extends Vars
	{
		function Query($sql)
		{
			return mysql_query($sql);
		}
		
		function GetInsertId(){
			return mysql_insert_id();
		}
		
		function FetchLine($result,$type)
		{
			return mysql_fetch_array($result,$type);
		}
		
		function DataSeek($result,$num)
		{
			return mysql_data_seek($result,$num);
		}
		
		function NumRows($result)
		{
			return mysql_num_rows($result);
		}
		
		function FieldSeek($result,$off)
		{
			return mysql_field_seek($result,$off);
		}
		
		function FetchField($result)
		{
			return mysql_fetch_field($result);
		}
		
		function NumFields($result)
		{
			return mysql_num_fields($result);
		}
		
		function GetError()
		{
			$this->SetError(mysql_error());
			return $this->error;
		}
	}
?>