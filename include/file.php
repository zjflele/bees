<?
	class File extends Obj
	{
		//private
		var $fileName;
		var $mod;
		var $handle;
		
		function File($fileName="",$mod="br")
		{
			$this->fileName=$fileName;
			$this->mod=$mod;
			$this->handle=false;
		}
		function SetFileName($fileName)
		{
			return $this->fileName=$fileName;
		}
		function GetMod()
		{
			return $this->mod;
		}
		function SetMod($mod)
		{
			return $this->mod=$mod;
		}
		function Open()
		{
			$file = $this->fileName;
			if(substr($this->fileName,0,1)=="/")
				$file = $_SERVER['DOCUMENT_ROOT'] . $file;
			if($this->handle=fopen($file, $this->mod))
			{
				return $this->handle;
			}
			else
			{
				$this->SetError("打开文件过程中发生错误。");
				$this->OnException();
				return false;
			}
		}
		function BaseName()
		{
			return basename($this->fileName);
		}
		function FileName()
		{
			return $this->fileName;
		}
		function Copy($dist)
		{
			$file = $this->fileName;
			if($this->fileName{0}=="/")
				$file = $_SERVER['DOCUMENT_ROOT'] . $file;
			if($dist{0}=="/")
				$dist = $_SERVER['DOCUMENT_ROOT'] . $dist;
			return copy($file,$dist);
		}
		function Close()
		{
			return fclose($this->handle);
		}
		function DirName()
		{
			return dirname($this->fileName);
		}
		function DiskTotalSpace()
		{
			return disk_total_space($this->fileName);
		}
		function DiskFreeSpace()
		{
			return disk_free_space($this->fileName);
		}
		function Eof()
		{
			return feof($this->handle);
		}
		function Exists()
		{
			return file_exists($this->fileName); 
		}
		function Flush()
		{
			return fflush($this->handle);
		}
		function GetChar()
		{
			return fgetc($this->handle);
		}
		function GetString($len="")
		{
			if($len=="")
				return fgets($this->handle);
			else
				return fgets($this->handle,(int)$len);
		}
		function GetContents()
		{
			return file_get_contents($this->fileName);
		}
		function Size()
		{
			return filesize($this->fileName);
		}
		function Read($len)
		{
			return fread($this->handle,(int)$len);
		}
		function Seek($offset,$whence="")
		{
			if($whence=="")
			{
				return fseek($this->handle);
			}
			else
			{
				return fseek($this->handle,$whence);
			}
		}
		function Tell()
		{
			return ftell($this->handle);
		}
		function Write($content)
		{
			return fwrite($this->handle,$content);
		}
		function IsDir()
		{
			return is_dir($this->fileName);
		}
		function IsFile()
		{
			return is_file($this->fileName);
		}
		function IsWriteable()
		{
			return is_writable($this->fileName);
		}
		function MkDir($pathname)
		{
			$currentPath="";
			str_replace("\\","/",$pathname);
			$pathArr = split("/",$pathname);
			if($pathArr[0] == "")		//使用绝对路径
			{
				$currentPath = $_SERVER['DOCUMENT_ROOT'];
			}
			else
			{
				$currentPath = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']);
			}
			for($i=0; $i<count($pathArr); $i++)
			{
				if($pathArr[$i]=="")
					continue;
				else
					if(is_dir($currentPath . "/" . $pathArr[$i]))
						$currentPath = $currentPath . "/" . $pathArr[$i];
					else
						mkdir($currentPath = $currentPath . "/" . $pathArr[$i]);
			}
		}
		
		function ParseIniFile($processSections=false)
		{
			return parse_ini_file($this->fileName,$processSections);
		}
		function PathInfo()
		{
			return pathinfo($this->fileName);
		}
		function ReName($newName)
		{
			return rename($this->fileName,$newName);
		}
		function ReWind()
		{
			rewind($this->handle);
		}
		function RmDir()
		{
			return rmdir($this->fileName);
		}
		function SetBuffen($buffer)
		{
			return stream_set_write_buffer($this->handle,$buffer);
		}
		function Unlink()
		{
			return unlink($this->fileName);
		}
		function MakeThumbnail($distFile,$distWidth,$distHeight)
		{
			$sourceFile = $this->fileName;
//			if($sourceFile{0}=="/")
//				$sourceFile = $_SERVER['DOCUMENT_ROOT'] . $sourceFile;
			$data = getimagesize($sourceFile); 
			switch ($data[2])
			{ 
				case 1: 
					$oldImage = @imagecreatefromgif($sourceFile); 
					break; 
				case 2: 
					$oldImage = @imagecreatefromjpeg($sourceFile); 
					break; 
				case 3: 
					$oldImage = @imagecreatefrompng($sourceFile); 
					break; 
			}
			if(!$oldImage)
			{
				$this->SetError("不支持从您提交的文件创建缩略图。");
				$this->OnException();
				return false;
			}

			$sourceWidth	= imagesx($oldImage);
			$sourceHeight	= imagesy($oldImage);

			if($sourceWidth * $distHeight > $distWidth * $sourceHeight)
			{
				$distHeight = floor($sourceHeight * $distWidth / $sourceWidth);
			} 
			else
			{
				$distWidth = floor($distHeight * $sourceWidth / $sourceHeight);
			} 

			$newImage = imagecreatetruecolor($distWidth,$distHeight);
			imagecopyresized($newImage, $oldImage, 0, 0, 0, 0, $distWidth, $distHeight, $sourceWidth, $sourceHeight);
			if($distFile{0}=="/")
				$distFile = $_SERVER["DOCUMENT_ROOT"] . $distFile;
			imagejpeg($newImage,$distFile,80);
			imagedestroy($oldImage); 
			imagedestroy($newImage); 
			return true;
		} 
	}

?>