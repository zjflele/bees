<?
	/// <������Ϣ>
	///	<����>
	///	PHP DataGrid��������ʾ����ҳ
	///	</����>
	///	<����>
	///	�����
	///	</����>
	///	<����޸�����>
	///	2004.7.11
	///	</����޸�����>
	///	<�汾>
	///	2.0
	///	</�汾>
	///	</������Ϣ>

	class Page extends EasyDB
	{
		var $RowTemplet;					///������ݵ���ģ�壬��<FIELD_index>��<FIELD_fieldname>������Ҫ������ֶ����ݡ�
		var $HeadTemplet;					///������ݵ�ͷģ�壬��<FIELD_index>��<FIELD_fieldname>������Ҫ����ı������ݡ�
		var $SortableFields;				///��������������ֶΡ�
		var $HiddenFields;					///���ص��ֶΣ�����ҳ����ʾ���ֶΣ�������ҳ��֮�䴫ֵ��
		var $Titles;						///��ͷ���⡣����֮���á�,������ǵĶ��ţ��ָ����Ϊ���顣
		var $PageVars;						///ҳ��֮�䴫�ݵı��������ƣ�������ʾ������������������
		var $ShowTitle;						///�Ƿ���ʶ���⡣����Ϊ��true/flalse��
		var $ShowFieldName;					///�Ƿ���ʾ�ֶ����ơ�����Ϊ��true/flalse��
		var $ShowNoContentMsg;				///�����Ϊ��ʱ�Ƿ���ʾ��ʾ��Ϣ��
		var $ResultSize;					///��������ơ�Ĭ��Ϊ-1�������ơ�
		var $PageSize;						///ÿҳ��ʾ��¼����
		var $NavText;						///�����ı���Ĭ��Ϊ����ҳ ��һҳ ��һҳ βҳ��
		var $NoContentMsg;
		var $Unit;							///��¼��λ

		//	˽�б���
		var $isOpened;
		var $path;
		var $totalRows;
		var $totalPages;
		var $page;
		var $showJs;
		var $property;
		var $bindedFunction;

		function Page($table)
		{
			EasyDB::EasyDB($table);
			$this->RowTemplet		=	"";
			$this->HeadTemplet		=	"";
			$this->SortableFields	=	"";
			$this->HiddenFields		=	"";
			$this->Titles			=	"";
			$this->PageVars			=	"";
			$this->ShowTitle		=	true;
			$this->ShowFieldName	=	false;
			$this->ShowNoContentMsg	=	true;
			$this->ResultSize		=	-1;
			$this->PageSize			=	20;
			$this->NavText			=	"��ҳ,��һҳ,��һҳ,βҳ";
			$this->NoContentMsg		=	"�Բ���û���ҵ�������ݡ�";
			$this->Unit				=	"����¼";
			//˽�б���
			$this->isOpened			=	false;
			$this->path				=	$_SERVER["PHP_SELF"];
			$this->totalRows		=	0;
			$this->totalPages		=	0;
			$this->page				=	1;
			$this->showJs			=	false;
			$this->property			=	array();
			$this->bindedFunction	=	array();
			$this->InitPage();
		}
		
		/// <����>
		///	��ʼ�����ݣ�ִ�в�ѯ���
		/// </����>
		function Open()
		{
			$this->PreOpen();
			$this->totalRows 	= $this->Having();
			$this->totalPages	= @ceil($this->totalRows / $this->PageSize);
			$this->page 		= isset($this->Request["page"]) ? intval($this->Request["page"]) : 1;
			$this->page			= $this->totalRows > $this->ResultSize && $this->ResultSize>=0 && $this->page>ceil($this->ResultSize / $this->PageSize) ? ceil($this->ResultSize / $this->PageSize) : $this->page;
			$this->page			= $this->page>$this->totalPages ? $this->totalPages : $this->page;
			$this->page			= $this->page>0 ? $this->page : 1;
			$this->Limit		= strval(($this->page - 1) * $this->PageSize) . ", " . strval($this->PageSize);
			$this->Limit		= $this->PageSize <= 0 ? "": $this->Limit;
			$this->Select();
			$this->isOpened		= true;
		}

		function Close()
		{
			$this->isOpened		= false;
		}

		///	<����>
		///	��ʾ�������ݡ������������ñ�ǩ��content_table��content_table_th��content_table_th_td��
		///			content_table_th_td_<FIELD_name>��content_table_th_td_a��
		///			content_table_th_td_a_<FIELD_name>��content_table_tr��content_table_tr_td��
		///			content_table_tr_td_<FIELD_name>��content_table_tr_td_a��content_table_tr_td_a_<FIELD_name>��content_table_tr_td_nocontent
		///	</����>
		function ShowContent()
		{
			if (!$this->isOpened)
			{
				$this->SetError("����û�д����ݡ���ȷ����������Open() ����<br>\n");
				$this->OnException();
				exit();
			}

			if($this->NumRows()==0 && $this->ShowNoContentMsg)
			{
				$this->NoContent();
				return;
			}
			
			$this->DataSeek(0);

			if($this->showJs)
				$this->ShowJavascript();

			if(!$this->RowTemplet) 
				$this->BeginTag("table","content_table");

			if($this->ShowTitle)
				$this->ShowHeader("TITLE");

			if($this->ShowFieldName)
				$this->ShowHeader("FIELD");

			$this->ShowBody();

			if(!$this->RowTemplet) 
				$this->EndTag("table");
		}

		///	<����>
		///	��ʾ��ҳ�������ܵģ��������ñ�ǩ��page_table��page_table_form��page_table_form_tr��
		///			page_table_form_tr_td��page_table_form_tr_td_a��page_table_form_tr_td_totalrows��
		///			page_table_form_tr_td_totalrows��page_table_form_tr_td_page��page_table_form_tr_td_totalpage��
		///			page_table_form_tr_td_resultsize
		///	</����>
		function ShowPage()
		{
			if (!$this->isOpened)
			{
				$this->SetError("����û�д����ݡ���ȷ����������Open() ����<br>\n");
				$this->OnException();
				exit();
			}

			if($this->totalRows>0)
			{
				$pageVar	= $this->CreatePageVar($this->OrderFields, $this->SortTypes);
				$this->SetProperty("page_table_form", "action", $this->path . $pageVar);
				$this->BeginTag("table","page_table");
				$this->BeginTag("form","page_table_form");
				$this->BeginTag("tr","page_table_form_tr");
				$this->SetProperty("page_table_form_tr_td", "align", "center");
				$this->BeginTag("td","page_table_form_tr_td");
				if($this->page<2)
				{
					print $this->NavText[0];
					print " ";
					print $this->NavText[1];
					print " \n";
				}
				else
				{
					if($this->NavText[0])
					{
						$this->SetProperty("page_table_form_tr_td_a", "href", $this->path . $pageVar);
						$this->BeginTag("a", "page_table_form_tr_td_a");
						print $this->NavText[0];
						$this->EndTag("a");
					}
					if($this->NavText[1])
					{
						$this->SetProperty("page_table_form_tr_td_a", "href",  $this->path . $pageVar . "&page=" . ($this->page-1));
						$this->BeginTag("a", "page_table_form_tr_td_a");
						print $this->NavText[1];
						$this->EndTag("a");
					}
				}
				if($this->page>=$this->totalPages || $this->ResultSize>=0 && $this->page>=ceil($this->ResultSize/ $this->PageSize))
				{
					print $this->NavText[2];
					print " ";
					print $this->NavText[3];
					print " \n";
				}
				else
				{
					if($this->NavText[2])
					{
						$this->SetProperty("page_table_form_tr_td_a", "href",  $this->path . $pageVar . "&page=" . ($this->page+1));
						$this->BeginTag("a", "page_table_form_tr_td_a");
						print $this->NavText[2];
						$this->EndTag("a");
					}
					if($this->NavText[3])
					{
						$this->SetProperty("page_table_form_tr_td_a", "href",  $this->path . $pageVar . "&page=" . $this->totalPages);
						$this->BeginTag("a", "page_table_form_tr_td_a");
						print $this->NavText[3];
						$this->EndTag("a");
					}
				}
				print "��";
				$this->BeginTag("span","page_table_form_tr_td_totalrows","",false);
				print $this->totalRows;
				$this->EndTag("span", "", "", false);
				print $this->Unit . " ";
				$this->BeginTag("span","page_table_form_tr_td_pagesize","",false);
				print $this->PageSize;
				$this->EndTag("span", "", "", false);
				print "��/ҳ \n";
				$this->BeginTag("span","page_table_form_tr_td_page","",false);
				print $this->page;
				$this->EndTag("span", "", "", false);
				print "/";
				$this->BeginTag("span","page_table_form_tr_td_totalpage","",false);
				print $this->totalPages;
				$this->EndTag("span", "", "", false);
				print "ҳ \n";
				if($this->ResultSize>=0)
				{
					print "������ʾ ";
					$this->BeginTag("span","page_table_form_tr_td_resultsize","",false);
					print $this->ResultSize;
					$this->EndTag("span", "", "", false);
					print $this->Unit . "\n";
				}
				print "��ת����<input type=\"text\" value=\"" . $this->page . "\" name=\"page\" size=\"2\" maxlength=\"9\">ҳ\n";
				print "<input type=\"submit\" name=\"submit\" value=\"Go\">";
				$this->EndTag("td");
				$this->EndTag("tr");
				$this->EndTag("form");
				$this->EndTag("table");
			}
		}
		
		///	<����>
		///	������ӡ�$target Ĭ��ֵΪ��_self�����ڱ�ҳ�򿪣�Ϊ��_blank�����¿������д����ӡ�Ϊ��_pop��ʱΪ�������ڣ�Ϊ��_modal��Ϊģʽ�Ի���
		///	$page�п���<FIELD_name>������Ϊname���ֶ�
		/// </����>
		function AddLink($field, $page, $target="_self", $style=NULL, $confimMsg=NULL)
		{
			if(is_null($target))
				$target = "_self";
			if($target == "_pop")
			{
				$this->showJs = true;
				if(is_null($style))
					$style = "width=500,height=500,resizable=yes,scrollbars=yes";

				if(is_null($confimMsg))
					$confimMsg = "";

				$this->SetProperty("content_table_tr_td_a_" . $field, "href", "#");
				$this->SetProperty("content_table_tr_td_a_" . $field, "onClick", "ConfirmPopWin('" . $page . "','','". $style ."','" . $confimMsg . "')");
				return;
			}
			if($target == "_modal")
			{
				$this->showJs = true;

				if(is_null($style))
					$style = "dialogWidth:400px;dialogHeight:200px;status:no;resizable=yes";

				if(is_null($confimMsg))
					$confimMsg = "";

				$this->SetProperty("content_table_tr_td_a_" . $field, "href", "#");
				$this->SetProperty("content_table_tr_td_a_" . $field, "onClick", "ConfirmShowModal('" . $page . "','','". $style ."','" . $confimMsg . "')");
				return;
			}
			$this->SetProperty("content_table_tr_td_a_" . $field, "href", $page);
			$this->SetProperty("content_table_tr_td_a_" . $field, "target", $target);
			if(!is_null($confimMsg))
			{
				$this->showJs = true;
				$this->SetProperty("content_table_tr_td_a_" . $field, "onClick", "return ConfirmMsg('" . str_replace("'", "\\'", $confimMsg) . "')");
			}
		}
		
		///	<����>
		///	���ñ���ǩ�����ԡ�SetProperty("table","propertyName","content")
		///	</����>
		function SetProperty($tag,$propertyName,$content=NULL)
		{
			if(is_null($content))
			{
				//ɾ������
				unset($this->property[$tag][$propertyName]);
			}
			else
			{
				if(isset($this->property[$tag]))
					unset($this->property[$tag][$propertyName]);
				$this->property[$tag][$propertyName] = "\"" . $content . "\"";
				//��ӣ��޸����ԡ�
			}
		}
		
		///	<����>
		///	���ֶν��к����󶨡�$obj->BindFunction("name","substr(\"<Field_name>\",0,20)") ������Ϊname���ֶΰ󶨺���substr�������������ֶα�ʾͬģ���еĹ�����ͬ��<Field>��ʾ��ǰ�ֶΡ�
		/// </����>
		function BindFunction($field,$functionStr)		
		{
			$this->bindedFunction[$field] = $functionStr;
		}
		
		function PreOpen()
		{
			$this->ToArray("SortableFields",	",");
			$this->ToArray("HiddenFields",	",");
			$this->ToArray("Titles", 		",");
			$this->ToArray("PageVars", 		",");
			$this->ToArray("NavText", 		",");

			if(isset($this->Request["_orderby"]))
				if(InArray($this->Request["_orderby"], $this->SortableFields)>=0)
					$this->OrderFields	= $this->Request["_orderby"];
			if(isset($this->Request["_sorttype"]) && ($this->Request["_sorttype"] == "" || $this->Request["_sorttype"] == "DESC"))
				$this->SortTypes	= $this->Request["_sorttype"];
		}
		
		function InitPage()
		{
			$this->SetProperty("content_table",			"align",		"center");
			$this->SetProperty("content_table",			"width",		"95%");
			$this->SetProperty("content_table",			"border",		"0");
			$this->SetProperty("content_table",			"cellspacing",	"1");
			$this->SetProperty("content_table",			"cellpadding",	"1");
			$this->SetProperty("content_table_tr",		"height",		"20");

			$this->SetProperty("page_table", "align", "center");
			$this->SetProperty("page_table", "width", "90%");
			$this->SetProperty("page_table", "border", "0");
			$this->SetProperty("page_table", "cellspacing", "0");
			$this->SetProperty("page_table", "cellpadding", "0");
			$this->SetProperty("page_table_form", "method", "post");
		}

		function ShowHeader($type="TITLE")
		{
			if($this->HeadTemplet=="")		//����ģ��
			{
				$currentCol=0;
				$hidden=0;
				$this->BeginTag("tr","content_table_th");
				$this->FieldSeek(0);
				while($field = $this->FetchField())
				{
					$name=$field->name;
					if(in_array($name,$this->HiddenFields))
					{
						$hidden++;
						$currentCol++;
						continue;
					}
					$this->BeginTag("td", "content_table_th_td", $name);
					$this->ShowHeaderName($name, ($currentCol - $hidden), $type);
					$this->EndTag("td");
					$currentCol++;
				}
				$this->EndTag("tr");
			}
			else							//ʹ��ģ��
			{
				$outputStr = $this->HeadTemplet;
				preg_match_all("/<FIELD_([\w]+)>/", $outputStr, $matches, PREG_SET_ORDER);
				foreach($matches as $key=>$match)
				{
					$outputStr = str_replace($match[0], $this->CreateHeaderName($match[1], $key, $type), $outputStr);
				}
				print $outputStr;
			}
		}
		
		function CreateHeaderName($name, $index, $type="TITLE")
		{
			$tmp="";
			if (in_array($name, $this->SortableFields) || in_array("*", $this->SortableFields))
			{
				$this->SetProperty("content_table_th_td_a_" . $name, "href", $this->path . $this->CreatePageVar($name,$this->CreateSortType($name)));
				$tmp .= $this->CreateTag("a", "content_table_th_td_a", $name);
				if($type=="TITLE")
					$tmp .= @$this->Titles[$index];
				else
					$tmp .= $name;
				$tmp .= $this->CreateTag("/a");
			}
			else
			{
				if($type=="TITLE")
					$tmp .= @$this->Titles[$index];
				else
					$tmp .= $name;
			}
			return $tmp;
		}
		
		function ShowHeaderName($name, $index, $type="TITLE")
		{
			print $this->CreateHeaderName($name, $index, $type);
		}
		
		function ShowBody()
		{
			while($this->FetchLine())
			{
				$currentCol=0;
				$hidden=0;
				$this->FieldSeek(0);
				if($this->RowTemplet=="")		//����ģ��
				{
					$this->BeginTag("tr", "content_table_tr");
					while($field = $this->FetchField())
					{
						$name=$field->name;
						if(in_array($name,$this->HiddenFields))
						{
							$hidden++;
							$currentCol++;
							continue;
						}
						$this->BeginTag("td", "content_table_tr_td",$name);
						$this->ShowFieldContent($name);
						$this->EndTag("td");
					}
					$this->EndTag("tr");
				}
				else							//��ģ��
				{
					$outputStr = $this->RowTemplet;
					preg_match_all("/<FIELD_([\w]+)>/", $outputStr, $matches,PREG_SET_ORDER);
					foreach($matches as $match)
					{
						$outputStr = str_replace($match[0], $this->CreateFieldContent($match[1]), $outputStr);
					}
					print $outputStr;
				}
			}
		}
		
		function ShowJavascript()
		{
			print "\n";
			print "<script language=\"javascript\">\n";

			print "function ConfirmMsg(msg)\n";
			print "{\n";
			print "	return confirm(msg);\n";
			print "}\n";
			print "\n";
			print "function ConfirmPopWin(url, target, style, msg)";
			print "{\n";
			print "	if(msg==\"\" || confirm(msg))\n";
			print "		window.open(url, target, style);\n";
			print "	else\n";
			print "		return true;\n";
			print "}\n";
			print "\n";
			print "function ConfirmShowModal(url, param, style, msg)";
			print "{\n";
			print "	if(msg==\"\" || confirm(msg))\n";
			print "		window.showModalDialog(url, param, style);\n";
			print "	else\n";
			print "		return true;\n";
			print "}\n";

			print "</script>\n";
			
		}

		function ShowFieldContent($fieldName)
		{
			print $this->CreateFieldContent($fieldName);
		}
		
		function NoContent()
		{
			$this->BeginTag("table","content_table");
			$this->BeginTag("tr","content_table_tr");
			$this->BeginTag("td","content_table_tr_td","nocontent");
			print $this->NoContentMsg;
			$this->EndTag("td");
			$this->EndTag("tr");
			$this->EndTag("table");

		}

		function CreateFieldContent($fieldName)
		{
			$tmp="";
			if(isset($this->bindedFunction[$fieldName]))
			{
				$functionStr = $this->bindedFunction[$fieldName];
				preg_match_all("/<FIELD_([\w]+)>/", $functionStr, $matches,PREG_SET_ORDER);
				foreach($matches as $match)
				{
					$functionStr = str_replace($match[0], $this->GetField($match[1]), $functionStr);
				}
				$functionStr = str_replace("<FIELD>", $this->GetField($fieldName), $functionStr);
				eval ("\$tmp=" . $functionStr.";");
			}
			else
			{
				$tmp = $this->GetField($fieldName);
			}

			if(isset($this->property["content_table_tr_td_a_" . $fieldName]))
			{
				$tmp = $this->CreateTag("a", "content_table_tr_td_a", $fieldName) . $tmp . $this->CreateTag("/a");
			}
			return $tmp;
		}

		function CreatePageVar($order, $sort)
		{
			$tmp="?1=1";

			foreach($this->PageVars as $key=>$value)
			{
				if($value!="")
					$tmp .= "&" . $value . "=" . (is_null($this->GetValue($value,"REQUEST")) ? "" : $this->GetValue($value,"REQUEST"));
			}
			$tmp .= "&_orderby=" . $order . "&_sorttype=" . $sort;
			return $tmp;
		}
		
		function CreateProperty($propertyName, $fieldName)
		{
			if(isset($this->property[$propertyName]))
			{
				$tmp = "";
				foreach($this->property[$propertyName] as $key=>$value)
				{
					$tmp .= " " . $key . "=" . $value;
				}
				preg_match_all("/<FIELD_([\w]+)>/", $tmp, $matches,PREG_SET_ORDER);
				foreach($matches as $match)
				{
					$tmp = str_replace($match[0], $this->GetField($match[1]), $tmp);
				}
				if(strpos($propertyName,"th")===false && strpos($tmp,"<FIELD>")!==false)
				{
					$tmp = str_replace("<FIELD>", $fieldName!="" ? $this->GetField($fieldName) : "", $tmp);
				}
				return $tmp;
			}
			else
				return "";
		}
		
		function CreateSortType($field)
		{
			if($field == $this->OrderFields && ($this->SortTypes =="" || ucwords($this->SortTypes) == "ASC"))
				return "DESC";
			else
				return "";
		}

		function CreateTag($tag, $propertyName="", $propertyNameEx="", $nextLine = true)
		{
			return "<" . $tag . $this->CreateProperty($propertyName,$propertyNameEx) . $this->CreateProperty($propertyName . "_" . $propertyNameEx, $propertyNameEx) . ">" . ($nextLine ? "\n" : "");
		}

		function BeginTag($tag, $propertyName="", $propertyNameEx="", $nextLine = true)
		{
			print $this->CreateTag($tag, $propertyName, $propertyNameEx, $nextLine);
		}

		function EndTag($tag, $propertyName="", $propertyNameEx="", $nextLine = true)
		{
			print $this->CreateTag("/" . $tag, $propertyName, $propertyNameEx, $nextLine);
		}
	}
	
?>
