<?
	/// <������Ϣ>
	///	<����>
	///	 ��� Javascript
	///	</����>
	///	<����>
	///	�����
	///	</����>
	///	<����޸�����>
	///	2004.6.27
	///	</����޸�����>
	///	<�汾>
	///	 1.2
	///	</�汾>
	///	</������Ϣ>
	class Javascript
	{
		function Begin()
		{
			print "<script language=\"javascript\">\n";
		}

		function End()
		{
			print "</script>\n";
		}

		function Open($url, $target, $style)
		{
			print "open(\"" . $url . "\",\"" . $target . "\",\"" . $style . "\");\n";
		}
		
		function SetValue($name,$value,$form="")
		{
			$value = str_replace(array("\"","\r\n","\r","\n"), array("\\\"","\\n","\\n","\\n"), $value);
			print "\tSetValue(\"" . $name . "\",\"" . $value . "\"" . ($form==""?"": ",\"" . $form . "\"") . ");\n";
		}
		
		function SetTag($name,$value)
		{
			$value = str_replace(array("\"","\r\n","\r","\n"), array("\\\"","\\n","\\n","\\n"), $value);
			print "\tSetTag(\"" . $name . "\",\"" . $value . "\"" . ");\n";
		}
		
		function GoToUrl($url,$wnd="")
		{
			print ($wnd!=""?$wnd.".":"")."window.location.href=\"" . $url . "\";\n";
		}
		
		function Alert($msg)
		{
			$msg = str_replace("\"", "\\\"", $msg);
			print "alert(\"" . $msg . "\");\n";
		}
		
		function GoBack()
		{
			print "history.back();\n";
		}
		
		function SetFocus($name)
		{
			print "SetFocus(\"" . $name . "\");\n";
		}
		
		function CloseWindow()
		{
			print "window.close();\n";
		}
	}
?>