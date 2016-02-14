<?php

	/// <������Ϣ>
	///	<����>
	///	�Զ�ɨ��������в������ݿ� 
	///	</����>
	///	<����>
	///	�����
	///	</����>
	///	<����޸�����>
	///	2005.3.13
	///	</����޸�����>
	///	<�汾>
	///	 3.0
	///	</�汾>
	///	</������Ϣ>

	class EasyDB extends StdDB
	{
		//���б���
		var $Mark;
		var $AcceptType;			//�������ݵ�����
		var $AcceptVars;			//���յ�ֵ
		var $Sql;
		var $Table;
		var $IDVars;
		var $Fields;
		var $OrderFields;
		var $SortTypes;
		var $Limit;
		var $Line;
		//˽�б���
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

		///	<����>
		///	ȡ�õ�ǰ��Sql ��䡣
		///	</����>
		function GetSql()
		{
			return $this->Sql;
		}
		function SetSql($sql)
		{
			$this->Sql=$sql;
		}

		///	<����>
		///	ִ��һ��Sql ��䡣
		///	</����>
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

		///	<����>
		///	ִ�е�ǰSQL��䡣
		///	</����>
		function Execute()
		{
			return $this->Query($this->Sql);
		}

		///	<����>
		///	��ȡ�õļ�¼��ֵ������
		///	</����>
		function FetchLine($type=MYSQL_BOTH)
		{
			return $this->Line = StdDB::FetchLine($this->result,$type);
		}

		///	<����>
		///	��ת����¼����ĳһ�С�
		///	</����>
		function DataSeek($num)
		{
			return StdDB::DataSeek($this->result,$num);
		}

		///	<����>
		///	��¼���а�����¼����Ŀ��
		///	</����>
		function NumRows()
		{
			return StdDB::NumRows($this->result);
		}

		///	<����>
		///	��ת���ֶμ���ĳһ���ֶΡ�
		///	</����>
		function FieldSeek($off)
		{
			return StdDB::FieldSeek($this->result,$off);
		}

		///	<����>
		///	ȡ���ֶμ������顣
		///	</����>
		function FetchField()
		{
			return StdDB::FetchField($this->result);
		}

		///	<����>
		///	ȡ���ֶμ����ֶ���Ŀ��
		///	</����>
		function NumFields()
		{
			return StdDB::NumFields($this->result);
		}

		///	<����>
		///	�������ݿ������������ơ�
		///	</����>
		function SetLimit($limit)
		{
			//	$this->Sql="set rowcount " . $num;	//Sql Server
			$this->Limit = $limit;
		}

		///	<����>
		///	ȡ�õ�ǰ��¼��ĳ���ֶε�ֵ��
		///	</����>
		function GetField($id=NULL)
		{
			if(is_null($id))
				return next($this->Line);
			else
				return trim($this->Line[$id]);
		}

		///	<����>
		///	�����ǰ��¼��ĳ���ֶε�ֵ��
		///	</����>
		function PrintField($id)
		{
			print $this->GetField($id);
		}

		///	<����>
		///	���ɲ�����䡣
		///	</����>
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

		///	<����>
		///	�������ݡ�
		///	</����>
		function Insert()
		{
			$this->CreateInsertSql();
			//echo $this->GetSql();exit();			
			return $this->Execute();
		}

		///	<����>
		///	���ɸ�����䡣
		///	</����>
		function CreateUpdateSql()
		{
			$this->Sql = "UPDATE " .$this->Table . $this->UpdateContent() . $this->CreateWhere() . ($this->Limit!="" ? (" LIMIT " . (string)$this->Limit) : "");
		}

		///	<����>
		///	���ɸ��������ֶθ�ֵ���֡�
		///	</����>
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
					//�����Where ����д��ڣ���������
					if(InArray($key, $iDVarsArr)>=0)
					{
						continue;
					}
					//������ڽ��ܷ�Χ�ڣ���������
					if($this->AcceptVars!="*" && InArray($key, $acceptVarsArr)<0)
					{
						continue;
					}
					//��������ϱ�ʶ������������
					if(InString($key,$this->Mark)!=0)
					{
						continue;
					}
					//������ڱ�ʶ�������ȥ��ʶ����
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

		///	<����>
		///	�������ݡ�
		///	</����>
		function Update()
		{
			$this->CreateUpdateSql();
			//echo $this->GetSql();exit();				
			return $this->Execute();
		}

		///	<����>
		///	����ɾ����䡣
		///	</����>
		function CreateDeleteSql()
		{
			$this->Sql = "DELETE FROM " .$this->Table . $this->CreateWhere() . ($this->Limit!="" ? (" LIMIT " . (string)$this->Limit) : "");
		}

		///	<����>
		///	ɾ�����ݡ�
		///	</����>
		function Delete()
		{
			$this->CreateDeleteSql();
			return $this->Execute();
		}

		///	<����>
		///	���ɲ�ѯ��䡣
		///	</����>
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

		///	<����>
		///	��ѯ���ݡ�
		///	</����>
		function Select()
		{
			$this->CreateSelectSql();
			return $this->Execute();
		}

		///	<����>
		///	���ɴ�����䡣
		///	</����>
		function CreateHavingSql()
		{
			$this->Sql = "SELECT count(*) counts FROM " .$this->Table . $this->CreateWhere();
		}

		///	<����>
		///	��ѯ�Ƿ���ڡ�
		///	</����>
		function Having($str="")
		{
			$this->CreateHavingSql();
			$this->Execute();
			$this->FetchLine();
			return $this->GetField(0);
		}

		///	<����>
		///	����SQL����Where ���֡���|��ʾ��,��&��,��ʾ��,���Լ�����.
		///	</����>
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
		
		///	<����>
		///	����SQL����Where �����е�ĳ���֡�
		///	</����>
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
		
		///	<����>
		///	����SQL����Where �����е�ĳ���֡�
		///	</����>
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

		///	<����>
		///	������ʶ�ֶε��������
		///	</����>
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

		///	<����>
		///	�쳣����
		///	</����>
		function OnException()
		{
			Obj::OnException();
			print "<pre>\n";
			print "\t���һ�����ݿ������䣺" . $this->GetSql() . "\n";
			print "</pre>\n";
		}
		
		function getInsertId()
		{
			return StdDB::GetInsertId($this->result);	
		}
	}
	
?>