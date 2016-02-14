<?php

	/// <基本信息>
	///	<描述>
	///	获取服务器变量
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2004.7.1
	///	</最后修改日期>
	///	<版本>
	///	 1.2
	///	</版本>
	/// </基本信息>
	
	class Vars extends Obj
	{
		var $User;
		var $Get;
		var $Post;
		var $Request;
		var $Files;
		var $Session;
		var $Cookie;
		var $Server;
		var $Env;

		///	<描述>
		///	构造函数
		///	</描述>
		function Vars()
		{
			Obj::Obj();
			$this->User		= array();
			$this->Get		= &$_GET;
			$this->Post		= &$_POST;
			$this->Request	= &$_REQUEST;
			$this->Files	= &$_FILES;
			$this->Session	= &$_SESSION;
			$this->Cookie	= &$_COOKIE;
			$this->Server	= &$_SERVER;
			$this->Env		= &$_ENV;
			
		}

		///	<描述>
		///	指定变量名，设置变量的值。默认设置User 的值
		///	</描述>
		function SetValue($key, $value, $type="USER")
		{
			$type = ucwords(strtolower(trim($type)));
			$this->$type[$key] = $value;
		}
		
		///	<描述>
		///	指定变量名，返回变量的值。默认设置顺序 User Session Cookie Request Server Env的值
		///	</描述>
		function GetValue($key, $type=NULL)
		{
			if(!is_null($type))
			{
//				$type = ucwords(strtolower(trim($type)));
//				return (isset($this->$type[$key]) ? $this->$type[$key] : NULL);
				$type =strtoupper(trim($type));

				if($type=="USER")
					return (isset($this->User[$key]) ? $this->User[$key] : NULL);
				if($type=="SESSION")
					return (isset($this->Session[$key]) ? $this->Session[$key] : NULL);
				if($type=="COOKIE")
					return (isset($this->Cookie[$key]) ? $this->Cookie[$key] : NULL);
				if($type=="POST")
					return (isset($this->Post[$key]) ? $this->Post[$key] : NULL);
				if($type=="GET")
					return (isset($this->Get[$key]) ? $this->Get[$key] : NULL);
				if($type=="REQUEST")
					return (isset($this->Request[$key]) ? $this->Request[$key] : NULL);
				if($type=="SERVER")
					return (isset($this->Server[$key]) ? $this->Server[$key] : NULL);
				if($type=="ENV")
					return (isset($this->Env[$key]) ? $this->Env[$key] : NULL);
				return NULL;

			}
			if(isset($this->User[$key]))
				return $this->User[$key];
			if(isset($this->Session[$key]))
				return $this->Session[$key];
			if(isset($this->Cookie[$key]))
				return $this->Cookie[$key];
			if(isset($this->Post[$key]))
				return $this->Post[$key];
			if(isset($this->Get[$key]))
				return $this->Get[$key];
			if(isset($this->Request[$key]))
				return $this->Request[$key];
			if(isset($this->Server[$key]))
				return $this->Server[$key];
			if(isset($this->Env[$key]))
				return $this->Env[$key];
			return NULL;
		}

		function AddSession($name,$value)
		{                   
			$_SESSION[$name]=$value;                       
		}

                
		function AddCookie($name,$value,$time=0,$path="/")
		{
			setcookie($name,$value,$time,$path);
		}


		///	<描述>
		///	显示所有变量。
		///	</描述>
		function ShowAllVars($flag=false)
		{
			$varArr = get_object_vars($this);
			print "<pre>成员变量：\n\n";
			foreach($varArr as $key=>$value)
			{
				if(!$flag && ($key=="Server" || $key== "Env"))
				{
					continue;
				}
				print($key . " = ");
				print_r($this->$key);
				print "\n";
			}
			print "\n</pre>\n";
		}
		

	}

?>