<?
	/// <基本信息>
	///	<描述>
	///	PHP DataGrid，数据显示、分页
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2004.7.11
	///	</最后修改日期>
	///	<版本>
	///	2.0
	///	</版本>
	///	</基本信息>

	class Page extends EasyDB
	{
		var $RowTemplet;					///输出内容的行模板，用<FIELD_index>、<FIELD_fieldname>代表所要输出的字段内容。
		var $HeadTemplet;					///输出内容的头模板，用<FIELD_index>、<FIELD_fieldname>代表所要输出的标题内容。
		var $SortableFields;				///可以用来排序的字段。
		var $HiddenFields;					///隐藏的字段，不在页面显示的字段，用来在页面之间传值。
		var $Titles;						///表头标题。标题之间用“,”（半角的逗号）分割或者为数组。
		var $PageVars;						///页面之间传递的变量的名称，用于显示条件检索出来的数据
		var $ShowTitle;						///是否显识标题。可以为：true/flalse。
		var $ShowFieldName;					///是否显示字段名称。可以为：true/flalse。
		var $ShowNoContentMsg;				///结果集为空时是否显示提示信息。
		var $ResultSize;					///结果集限制。默认为-1，无限制。
		var $PageSize;						///每页显示记录数量
		var $NavText;						///导航文本，默认为：首页 上一页 下一页 尾页。
		var $NoContentMsg;
		var $Unit;							///记录单位

		//	私有变量
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
			$this->NavText			=	"首页,上一页,下一页,尾页";
			$this->NoContentMsg		=	"对不起，没有找到相关内容。";
			$this->Unit				=	"条记录";
			//私有变量
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
		
		/// <描述>
		///	初始化数据，执行查询语句
		/// </描述>
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

		///	<描述>
		///	显示主体内容。接受属性设置标签：content_table、content_table_th、content_table_th_td、
		///			content_table_th_td_<FIELD_name>、content_table_th_td_a、
		///			content_table_th_td_a_<FIELD_name>、content_table_tr、content_table_tr_td、
		///			content_table_tr_td_<FIELD_name>、content_table_tr_td_a、content_table_tr_td_a_<FIELD_name>、content_table_tr_td_nocontent
		///	</描述>
		function ShowContent()
		{
			if (!$this->isOpened)
			{
				$this->SetError("您还没有打开数据。请确认您调用了Open() 函数<br>\n");
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

		///	<描述>
		///	显示分页导航接受的，属性设置标签：page_table、page_table_form、page_table_form_tr、
		///			page_table_form_tr_td、page_table_form_tr_td_a、page_table_form_tr_td_totalrows、
		///			page_table_form_tr_td_totalrows、page_table_form_tr_td_page、page_table_form_tr_td_totalpage、
		///			page_table_form_tr_td_resultsize
		///	</描述>
		function ShowPage()
		{
			if (!$this->isOpened)
			{
				$this->SetError("您还没有打开数据。请确认您调用了Open() 函数<br>\n");
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
				print "共";
				$this->BeginTag("span","page_table_form_tr_td_totalrows","",false);
				print $this->totalRows;
				$this->EndTag("span", "", "", false);
				print $this->Unit . " ";
				$this->BeginTag("span","page_table_form_tr_td_pagesize","",false);
				print $this->PageSize;
				$this->EndTag("span", "", "", false);
				print "条/页 \n";
				$this->BeginTag("span","page_table_form_tr_td_page","",false);
				print $this->page;
				$this->EndTag("span", "", "", false);
				print "/";
				$this->BeginTag("span","page_table_form_tr_td_totalpage","",false);
				print $this->totalPages;
				$this->EndTag("span", "", "", false);
				print "页 \n";
				if($this->ResultSize>=0)
				{
					print "限制显示 ";
					$this->BeginTag("span","page_table_form_tr_td_resultsize","",false);
					print $this->ResultSize;
					$this->EndTag("span", "", "", false);
					print $this->Unit . "\n";
				}
				print "跳转到第<input type=\"text\" value=\"" . $this->page . "\" name=\"page\" size=\"2\" maxlength=\"9\">页\n";
				print "<input type=\"submit\" name=\"submit\" value=\"Go\">";
				$this->EndTag("td");
				$this->EndTag("tr");
				$this->EndTag("form");
				$this->EndTag("table");
			}
		}
		
		///	<描述>
		///	添加链接。$target 默认值为“_self”，在本页打开；为“_blank”在新开窗口中打开链接。为“_pop”时为弹出窗口，为“_modal”为模式对话框。
		///	$page中可用<FIELD_name>代替名为name的字段
		/// </描述>
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
		
		///	<描述>
		///	设置表格标签的属性。SetProperty("table","propertyName","content")
		///	</描述>
		function SetProperty($tag,$propertyName,$content=NULL)
		{
			if(is_null($content))
			{
				//删除属性
				unset($this->property[$tag][$propertyName]);
			}
			else
			{
				if(isset($this->property[$tag]))
					unset($this->property[$tag][$propertyName]);
				$this->property[$tag][$propertyName] = "\"" . $content . "\"";
				//添加，修改属性。
			}
		}
		
		///	<描述>
		///	对字段进行函数绑定。$obj->BindFunction("name","substr(\"<Field_name>\",0,20)") 将对明为name的字段绑定函数substr，函数参数中字段表示同模板中的规则相同。<Field>表示当前字段。
		/// </描述>
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
			if($this->HeadTemplet=="")		//不用模板
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
			else							//使用模板
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
				if($this->RowTemplet=="")		//不用模板
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
				else							//用模板
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
