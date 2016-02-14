<?php

	/// <基本信息>
	///	<描述>
	///	自动扫表变量进行操作数据库 
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2005.3.13
	///	</最后修改日期>
	///	<版本>
	///	 3.0
	///	</版本>
	///	</基本信息>

	class EasyDB extends StdDB
	{
		//共有变量
		var $Mark;
		var $AcceptType;			//接收数据的类型
		var $AcceptVars;			//接收的值
		var $Sql;
		var $Table;
		var $IDVars;
		var $Fields;
		var $OrderFields;
		var $SortTypes;
		var $Limit;
		var $Line;
		//私有变量
		var $result;

		function EasyDB($table="")
		{
			Vars::Vars();
                        if (strpos($table, TABLEPRE)===FALSE) $table = TABLEPRE.$table;
			$this->Table		= $table;
			$this->Mark		= "";
			$this->AcceptType	= "REQUEST";
			$this->AcceptVars	= "*";
			$this->IDVars		= "";
			$this->Fields		= "*";
			$this->Line			= "";
			$this->OrderFields	= "";
			$this->SortType		= "";
			$this->Limit		= "";
		}

		///	<描述>
		///	取得当前的Sql 语句。
		///	</描述>
		function GetSql()
		{
			return $this->Sql;
		}
		function SetSql($sql)
		{
			$this->Sql=$sql;
		}

		///	<描述>
		///	执行一条Sql 语句。
		///	</描述>
		function Query($sql)
		{
			if($this->result = StdDB::Query($sql))
				return true;
			else
			{
				//$this->SetError($this->GetError());
				//$this->OnException();
				return false;
			}
		}

		///	<描述>
		///	执行当前SQL语句。
		///	</描述>
		function Execute()
		{
			return $this->Query($this->Sql);
		}

		///	<描述>
		///	把取得的记录拆分到数组里。
		///	</描述>
		function FetchLine($type=MYSQL_BOTH)
		{
			return $this->Line = StdDB::FetchLine($this->result,$type);
		}

		///	<描述>
		///	跳转到记录集的某一行。
		///	</描述>
		function DataSeek($num)
		{
			return StdDB::DataSeek($this->result,$num);
		}

		///	<描述>
		///	记录集中包含记录的数目。
		///	</描述>
		function NumRows()
		{
			return StdDB::NumRows($this->result);
		}

		///	<描述>
		///	跳转到字段集的某一个字段。
		///	</描述>
		function FieldSeek($off)
		{
			return StdDB::FieldSeek($this->result,$off);
		}

		///	<描述>
		///	取得字段集的数组。
		///	</描述>
		function FetchField()
		{
			return StdDB::FetchField($this->result);
		}

		///	<描述>
		///	取得字段集的字段数目。
		///	</描述>
		function NumFields()
		{
			return StdDB::NumFields($this->result);
		}

		///	<描述>
		///	设置数据库操作结果集限制。
		///	</描述>
		function SetLimit($limit)
		{
			//	$this->Sql="set rowcount " . $num;	//Sql Server
			$this->Limit = $limit;
		}

		///	<描述>
		///	取得当前记录的某个字段的值。
		///	</描述>
		function GetField($id=NULL)
		{
			if(is_null($id))
				return next($this->Line);
			else
				return trim($this->Line[$id]);
		}

		///	<描述>
		///	输出当前记录的某个字段的值。
		///	</描述>
		function PrintField($id)
		{
			print $this->GetField($id);
		}

		///	<描述>
		///	生成插入语句。
		///	</描述>
		function CreateInsertSql()
		{
			$fields = "";
			$values = "";
			$AcceptVarsArr = split(",",$this->AcceptVars);
			$acceptTypeArr		= split(",",$this->AcceptType);
			foreach($acceptTypeArr as $index=>$acceptType)
			{
				$acceptType=ucwords(strtolower(trim($acceptType)));
				foreach($this->$acceptType as $key=>$value)
				{
					if($this->AcceptVars!="*" && InArray($key, $AcceptVarsArr)<0 || InString($key,$this->Mark)<0)
					{
						continue;
					}
					if(InString($key,$this->Mark)==0 && $this->Mark!="")
					{
						$key = SubString($key, strlen($this->Mark . "_"));
					}
					$fields .= "`" . $key . "`, ";
					$values .= "'" . str_replace("'", "\'", $value) . "', ";
				}
			}
			$fields = substr($fields, 0, -2);
			$values = substr($values, 0, -2);			
			$this->Sql = "INSERT INTO " .$this->Table . " (" . $fields . ") VALUES (" . $values . ")" ;
		}

		///	<描述>
		///	插入数据。
		///	</描述>
		function Insert()
		{
			$this->CreateInsertSql();
			//echo $this->GetSql();exit();			
			return $this->Execute();
		}

		///	<描述>
		///	生成更新语句。
		///	</描述>
		function CreateUpdateSql()
		{
			$this->Sql = "UPDATE " .$this->Table . $this->UpdateContent() . $this->CreateWhere() . ($this->Limit!="" ? (" LIMIT " . (string)$this->Limit) : "");
		}

		///	<描述>
		///	生成更新语句的字段赋值部分。
		///	</描述>
		function UpdateContent()
		{
			$content			= " SET ";
			$acceptVarsArr		= split(",",$this->AcceptVars);
			$acceptTypeArr		= split(",",$this->AcceptType);
			$iDVarsArr			= split(",",$this->IDVars);
			foreach($iDVarsArr as $key=>$value)
			{
				list($operator, $idVar) = $this->ParseKey($value);
				$iDVarsArr[$key] = $idVar;
			}
			foreach($acceptTypeArr as $index=>$acceptType)
			{
				$acceptType=ucwords(strtolower(trim($acceptType)));
				foreach($this->$acceptType as $key=>$value)
				{
					//如果在Where 语句中存在，则跳过。
					if(InArray($key, $iDVarsArr)>=0)
					{
						continue;
					}
					//如果不在接受范围内，则跳过。
					if($this->AcceptVars!="*" && InArray($key, $acceptVarsArr)<0)
					{
						continue;
					}
					//如果不符合标识符，则跳过。
					if(InString($key,$this->Mark)!=0)
					{
						continue;
					}
					//如果存在标识符，则除去标识符。
					if(InString($key,$this->Mark)==0 && $this->Mark!="")
					{
						$key = SubString($key, strlen($this->Mark . "_"));
					}
					$content .= "`" . $key . "`='" . str_replace("'", "\'", $value) . "', ";
				}
			}
			$content = substr($content, 0, -2);
			return $content;
		}

		///	<描述>
		///	更新数据。
		///	</描述>
		function Update()
		{
			$this->CreateUpdateSql();
			//echo $this->GetSql();exit();				
			return $this->Execute();
		}

		///	<描述>
		///	生成删除语句。
		///	</描述>
		function CreateDeleteSql()
		{
			$this->Sql = "DELETE FROM " .$this->Table . $this->CreateWhere() . ($this->Limit!="" ? (" LIMIT " . (string)$this->Limit) : "");
		}

		///	<描述>
		///	删除数据。
		///	</描述>
		function Delete()
		{
			$this->CreateDeleteSql();
			return $this->Execute();
		}

		///	<描述>
		///	生成查询语句。
		///	</描述>
		function CreateSelectSql()
		{
			$orderFieldsArr = split(",",$this->OrderFields);
			$sortTypesArr = split(",",$this->SortTypes);
			$order = "";
			foreach($orderFieldsArr as $key=>$value)
			{
				if($value=="")
					continue;
				$sort 		= $key<count($sortTypesArr) &&  $sortTypesArr[$key]!="" ? (" " . $sortTypesArr[$key]) : "";
				$order		.= " " . $value . $sort . ",";
			}
			$order	 = substr($order, 0, -1);
			$this->Sql = "SELECT ". $this->Fields . " FROM " .$this->Table . $this->CreateWhere() . ($order != "" ? " ORDER BY" . $order : "") . ($this->Limit!="" ? (" LIMIT " . (string)$this->Limit) : "");
			
		}

		///	<描述>
		///	查询数据。
		///	</描述>
		function Select()
		{
			$this->CreateSelectSql();
			return $this->Execute();
		}

		///	<描述>
		///	生成存在语句。
		///	</描述>
		function CreateHavingSql()
		{
			$this->Sql = "SELECT count(*) counts FROM " .$this->Table . $this->CreateWhere();
		}

		///	<描述>
		///	查询是否存在。
		///	</描述>
		function Having($str="")
		{
			$this->CreateHavingSql();
			$this->Execute();
			$this->FetchLine();
			return $this->GetField(0);
		}

		///	<描述>
		///	生成SQL语句的Where 部分。用|表示或,用&和,表示与,可以加括号.
		///	</描述>
		function CreateWhere()
		{
//			$where				= " WHERE 1 AND(";
			$where 				= "";
			$iDVars = $this->IDVars;
			$iDVars = str_replace(" ", "", $this->IDVars);
			$iDVars = str_replace(",", "&", $iDVars);
			while(list($type, $value) = $this->ParseIDVars($iDVars))
			{
				if($type == "separator")
				{
					$where .= $value;
				}
				else
				{
					list($operator, $idVar) = $this->ParseKey($value);
					$where .= $this->CreateWhereDepart($operator, $idVar);
				}
			}
			$where = trim($where);
			return $where == "" ? "" : (" WHERE " . $where);
//			$where .= ")";
//			return $where ;
		}
		
		///	<描述>
		///	生成SQL语句的Where 部分中的某部分。
		///	</描述>
		function ParseIDVars(&$iDVars)
		{
			if($iDVars == "")
				return "";
			$arr = array("(",")","&","|");
			$sqlTmp = array(" (",") "," AND "," OR ");
			$len = strlen($iDVars);
			
			if(($pos = InArray($iDVars[$i], $arr)) >= 0)
			{
				$iDVars = substr($iDVars, 1);
				return array("separator", $sqlTmp[$pos]);
			}
			else
			{
				for($i = 0; $i < $len; $i++)
				{
					if(InArray($iDVars[$i], $arr)>=0)
						break;
				}
				$theIDVar = substr($iDVars, 0, $i);
				$iDVars = substr($iDVars, $i);
				return array("key", $theIDVar);
			}
		}
		
		///	<描述>
		///	生成SQL语句的Where 部分中的某部分。
		///	</描述>
		function CreateWhereDepart($operator, $idVar)
		{
			$acceptTypeArr		= split(",",$this->AcceptType);
			foreach($acceptTypeArr as $index=>$acceptType)
			{
				$acceptType=ucwords(strtolower(trim($acceptType)));
				foreach($this->$acceptType as $index=>$value)
				{
					if($index == $idVar)
					{
						if(is_array($this->{$acceptType}[$idVar]))
						{
							$str = "";
							reset($this->{$acceptType}[$idVar]);
							$arr = each($this->{$acceptType}[$idVar]);
							$str .= "`" . $idVar . "` " . $operator . " '" . str_replace("'", "\'", $arr[1]) . "'";
							while($arr = each($this->{$acceptType}[$idVar]))
								$str .= " or `" . $idVar . "` " . $operator . " '" . str_replace("'", "\'", $arr[1]) . "'";
							return " (" . $str . ")";
						}
						else
						{
							return " `" . $idVar . "` " . $operator . " '" . str_replace("'", "\'", $value) . "'";
						}
					}
				}
			}
		}

		///	<描述>
		///	解析标识字段的运算符。
		///	</描述>
		function ParseKey($key)
		{
			$tmp = substr($key,0,2);
			if(($tmp == ">=") || ($tmp == "<=") || ($tmp == "!=") || ($tmp == "<>"))
				return array($tmp, substr($key, 2));
			if(($tmp == "!%"))
				return array("NOT LIKE BINARY", substr($key, 2));
			$tmp = substr($key,0,1);
			if(($tmp == ">") || ($tmp == "<") || ($tmp == "="))
				return array($tmp, substr($key, 1));
			if(($tmp == "%"))
				return array("LIKE BINARY", substr($key, 1));
			if(($tmp == "!"))
				return array("!=", substr($key, 1));
			return array("=", $key);
			
		}

		///	<描述>
		///	异常处理。
		///	</描述>
		function OnException()
		{
			Obj::OnException();
			print "<pre>\n";
			print "\t最后一条数据库操作语句：" . $this->GetSql() . "\n";
			print "</pre>\n";
		}
		
		function getInsertId()
		{
			return StdDB::GetInsertId($this->result);	
		}
	}
	
?>