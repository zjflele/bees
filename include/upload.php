<?php
	/// <基本信息>
	///	<描述>
	///	文件上传类 
	///	</描述>
	///	<作者>
	///	李赤阳
	///	</作者>
	///	<最后修改日期>
	///	2004.8.4
	///	</最后修改日期>
	///	<版本>
	///	 1.0
	///	</版本>
	///	</基本信息>
	
	class UpLoad extends File
	{
		var $Types;
		var $DestFile;
		var $MaxSize;
		var $upFile;
		var $mimeTypeArr;
		
		function UpLoad($upFile)
		{
			File::File($upFile["tmp_name"]);
			$this->upFile	= $upFile;
			$this->DestFile	= "";
			$this->MaxSize	= 200*1024;
			$this->Types	= "all";
			$this->mimeTypeArr = array(
				"asf"	=>	"video/x-ms-asf",
				"avi"	=>	"video/x-msvideo",
				"bmp"	=>	"image/bmp",
				"cer"	=>	"application/x-x509-ca-cert",
				"css"	=>	"text/css",
				"doc"	=>	"application/msword",
				"exe"	=>	"application/octet-stream",
				"gif"	=>	"image/gif",
				"gz"	=>	"application/x-gzip",
				"hlp"	=>	"application/winhlp",
				"hta"	=>	"application/hta",
				"htc"	=>	"text/x-component",
				"htm"	=>	"text/html",
				"htt"	=>	"text/webviewhtml",
				"ico"	=>	"image/x-icon",
				"jpg"	=>	"image/jpeg",
				"jpg"	=>	"image/pjpeg",
				"js"	=>	"application/x-javascript",
				"mdb"	=>	"application/x-msaccess",
				"mid"	=>	"audio/mid",
				"mov"	=>	"video/quicktime",
				"mp3"	=>	"audio/mpeg",
				"mpg"	=>	"video/mpeg",
				"pdf"	=>	"application/pdf",
				"ppt"	=>	"application/vnd.ms-powerpoint",
				"png"	=>	"image/png",
				"ra"	=>	"audio/x-pn-realaudio",
				"rtf"	=>	"application/rtf",
				"swf"	=>	"application/x-shockwave-flash",
				"tar"	=>	"application/x-tar",
				"tgz"	=>	"application/x-compressed",
				"tif"	=>	"image/tiff",
				"tiff"	=>	"image/tiff",
				"txt"	=>	"text/plain",
				"wav"	=>	"audio/x-wav",
				"wps"	=>	"application/vnd.ms-works",
				"xls"	=>	"application/vnd.ms-excel",
				"zip"	=>	"application/zip"
			);
		}

		function Check()
		{
			$this->ToArray("Types", ",");
			if($this->upFile["error"]!=0)
			{
				$this->SetError("上传过程中出现错误！");
				return false;
			}
			if($this->MaxSize>0  && $this->upFile["size"]>$this->MaxSize)
			{
				$this->SetError("上传文件大小超过限制！");
				return false;
			}
			if(InArray("all", $this->Types)<0)
			{
				$flag = false;
				foreach($this->Types as $key=>$value)
				{
					if($this->upFile["type"] == $this->mimeTypeArr[$value])
					{
						$flag = true;
						break;
					}
				}
				if(!$flag)
				{
					$this->SetError("上传文件类型非法，只能是".implode($this->Types, ",")."格式的文件。");
					return false;
				}
			}
			return true;
		}
		
		function GetFileType()
		{
			foreach($this->mimeTypeArr as $key=>$value)
			{
				if($this->upFile["type"] == $value)
				{
					return $key;
				}
			}
			return false;
			
		}
		
		function DoUpLoad()
		{
			$dir = dirname($this->DestFile);
			$this->MkDir($dir);
			//echo $this->DestFile;
			//echo "<br>" . $this->fileName;
			return copy($this->fileName,$this->DestFile);
		}
	}

?>