	var xmlHttp = createXMLHttpRequest();
	
	function createXMLHttpRequest()
	{
		var xmlHttp;
		try
		{
			xmlHttp = new XMLHttpRequest();
		}
		catch(e)
		{
		    var xmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
                                    "MSXML2.XMLHTTP.5.0",
                                    "MSXML2.XMLHTTP.4.0",
                                    "MSXML2.XMLHTTP.3.0",
                                    "MSXML2.XMLHTTP",
                                    "Microsoft.XMLHTTP");
			for(var i=0;i<xmlHttpVersions.length && !xmlHttp;i++)
			{
				try
				{
					xmlHttp = new ActiveXObject(xmlHttpVersions[i]);
				}
				catch(e) {}
			}
		}
		
		if(xmlHttp) return xmlHttp;
	}

function pswd()
{

  // proceed only if the xmlHttp object isn't busy
  if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
  {
    // retrieve the name typed by the user on the form
    pwd = encodeURIComponent(document.getElementById("pwd").value);
    // execute the quickstart.php page from the server
    //alert("pwd_edit.php?pwd=" + pwd + "&action=pwd");
    xmlHttp.open("GET", "pwd_edit.php?pwd=" + pwd + "&action=pwd", true);  
    // define the method to handle server responses
    xmlHttp.onreadystatechange = handleServerResponse;
    // make the server request
    xmlHttp.send(null);
  }
}
function process()
{
  if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
  {
  
  password1 = document.getElementById("pwd1").value;
  password2 = document.getElementById("pwd2").value;
  //alert (password1 + password2);
  xmlHttp.open("GET","pwd_edit.php?password1=" + password1 + "&password2=" + password2 + "&action=pwd1",true);
  xmlHttp.onreadystatechange = pshandleSeverResponse;
  xmlHttp.send(null);
  }
}
function pshandleSeverResponse()
{
  if (xmlHttp.readyState == 4) 
  {
    // status of 200 indicates the transaction completed successfully
    if (xmlHttp.status == 200) 
    { 
      xmlResponse = xmlHttp.responseXML;
      //alert(helloMessage);
      xmlDocumentElement = xmlResponse.documentElement;
      pass = xmlDocumentElement.firstChild.data;
     
      if (pass == 0)
      document.getElementById("divpassword2").innerHTML = '(两次密码正确)';	 
      else if (pass == 1)
      document.getElementById("divpassword2").innerHTML = '(两次密码输入不一致)';	     
      else
      document.getElementById("divpassword2").innerHTML = '(输入密码不符合条件)';
	  if ((document.getElementById("password").innerHTML ==  '(原密码输入正确)') && (document.getElementById("divpassword2").innerHTML = '(两次密码正确)'))
	  {
		  document.getElementById("submit").disabled = false ;
	  }
	  
    }
    else
    {
    alert("There was a problem accessing the server: " + xmlHttp.statusText);
    }
  }
  else
  {
  document.getElementById("divpassword2").innerHTML = '正在验证....';
  }
}
// executed automatically when a message is received from the server
function handleServerResponse() 
{
  //alert("fdafds");
  // move forward only if the transaction has completed
  if (xmlHttp.readyState == 4) 
  {
    // status of 200 indicates the transaction completed successfully
    if (xmlHttp.status == 200) 
    {
      // extract the XML retrieved from the server
      xmlResponse = xmlHttp.responseXML;
      //alert(helloMessage);
      xmlDocumentElement = xmlResponse.documentElement;
      helloMessage = xmlDocumentElement.firstChild.data;
	  //myDiv = document.getElementById("divuserid");
	  //alert (helloMessage);
	  if (helloMessage==0)
      document.getElementById("password").innerHTML =  '(对不起，原密码输入不正确)';      
	  else
	  document.getElementById("password").innerHTML =  '(原密码输入正确)';	
	  
    } 
    // a HTTP status different than 200 signals an error
    else 
    {
      alert("There was a problem accessing the server: " + xmlHttp.statusText);
    }
  }
  else
  {
  document.getElementById("password").innerHTML =  '正在验证....';
  }
}
