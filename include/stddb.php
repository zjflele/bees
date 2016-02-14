<?
	/// <基本信息>
	///	<描述>
	///	自动扫表变量进行操作数据库 
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2004.9.3
	///	</最后修改日期>
	///	<版本>
	///	 2.5
	///	</版本>
	///	</基本信息>

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