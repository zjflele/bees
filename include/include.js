	function SetValue(name,value)
	{
		theForm="document.forms[0]";
		if(arguments.length==3)
			theForm = arguments[2];
		theForm=eval(theForm);
		
		pos = name.indexOf('[]');
		if(pos >= 0)
		{
			oldName = name;
			name = name.substring(0,pos);
			ChangeName(oldName, name, theForm);
		}
		//alert(name.type);
		for(i=0;i<theForm.elements.length;i++)
		{
	
			if(theForm.elements[i].name==name)
			{
				//复选框
				if(theForm.elements[i].type=="checkbox")
				{				
					if(theForm.elements[i].value==value)
					{
						theForm.elements[i].checked=true;	
		
					}
				}
	
				//单选按钮
				if(theForm.elements[i].type=="radio")
				{				
					if(theForm.elements[i].value==value)
					{
						theForm.elements[i].checked=true;	
					}
				}
	
				//输入框
				if(theForm.elements[i].type=="text" || theForm.elements[i].type=="hidden" || theForm.elements[i].type=="textarea")
				{
					theForm.elements[i].value=value;
				}
	
				//下拉列表
				if(theForm.elements[i].type=="select-one")
				{
					for(j=0;j<theForm.elements[i].length;j++)
					{
						if(theForm.elements[i][j].value==value)
						{
							theForm.elements[i][j].selected=true;
						}
					}
				}
				
				//--
			}
		}
		if(pos>= 0)
		{
			ChangeName(name, oldName);
		}
		return;
	}
	
	function SetTag(tagName, value)
	{
		obj = "document.all." + tagName;
		obj = eval(obj);
		obj.innerHTML = value;
	}
	
	function ChangeName(oldName, newName)
	{
		theForm="document.forms[0]";
		if(arguments.length==3)
			theForm = arguments[2];
		theForm=eval(theForm);
		for(i=0;i<theForm.elements.length;i++)
		{
			if(theForm.elements[i].name==oldName)
			{
				theForm.elements[i].name=newName
			}
		}
	}
	
	function SetFocus()
	{
		if(arguments.length==0)
		{
			theForm = "document.forms[0]";
			theForm=eval(theForm);
			for(i=0;i<theForm.elements.length;i++)
			{
				if(theForm.elements[i].type=="hidden" || theForm.elements[i].disabled)
				{
					continue;
				}
				theForm.elements[i].focus();
				return;
			}
		}
		else
		{
			if(arguments.length==1)
				obj = "document.forms[0]." + arguments[0];
			else
				obj = arguments[0] + "." + arguments[1];
		}
		obj = eval(obj);
		try
		{
			obj.focus();
		}
		catch(e)
		{}
	}
	
	//多个复选框只能单选或者不选择.
	function ChangeSelect(obj)
	{
		theForm=document.forms[0];
		var oldStatus;
		oldStatus = obj.checked;

		for(i=0;i<theForm.elements.length;i++)
		{
			if(theForm.elements[i].name==obj.name)
			{
				theForm.elements[i].checked=false;	
			}
		}

		if(oldStatus)
			obj.checked = true;
		else
			obj.checked = false;
		return true;
		
	}

	function StrLength(str)
	{
		var i,count,len;
		len=0;
		count=str.length;
		for(i=0;i<count;i++)
		{
			if(str.charCodeAt(i)<=255)
				len++;
			else
				len+=2;
		}
		return len;
	}

	function HaveInvalidChar(str)
	{
		var Letters = "`=~!@#$%^&*()_+[]{}\\|/?.>,<;:'\?<>/\"";
		 var i;
		 var c;
		 for( i = 0; i < String.length; i ++ )
		 {
			  c = str.charAt( i );
		  if (Letters.indexOf( c ) >= 0)
			 return true;
		 }
		 return false;
	}
	
	function IsEmail (str)
	{
		if (str.length > 100)
		{
			return false;
		}
	
		var regu = "^(([0-9a-zA-Z]+)|([0-9a-zA-Z]+[_.0-9a-zA-Z-]*[0-9a-zA-Z]+))@([a-zA-Z0-9-]+[.])+([a-zA-Z]{2}|net|NET|com|COM|gov|GOV|mil|MIL|org|ORG|edu|EDU|int|INT)$"
		var re = new RegExp(regu);
		if (str.search(re) != -1) 
			return true;
		else 
			return false;
	}
	
	function IsUrl(theelement) 
	{ 
		if(!theelement)
			return false;

		for (var i=0; i<theelement.length; i++) 
		{ 
			var Char = theelement.charAt(i); 
			if ((Char < "a" || Char > "z") && (Char < "A" || Char > "Z") && (Char <"0" || Char > "9") && (Char != "_") && (Char != ".") && (Char != "~")) 
				return false; 
		} 
		return true; 
	}