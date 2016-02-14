<?php
$FILEERRORMSG[0] = "Cannot create dir. Please check you system set.";
$FILEERRORMSG[1] = "Cannot create file. Please check you system set.";
$FILEERRORMSG[2] = "The file is not exists.";
$FILEERRORMSG[3] = "The dir is not exists.";

class FileIO
{
	function FileIO()
	{
	}
	/**
	*��ȡĿ¼
	*@param $dirPath	dir����
	*@return array		��������
	*/
	function getDirFile($dirPath)
	{
		$fArray = array();
		$dArray = array();
		//������ļ�
		if(FileIO::isFileExists($dirPath))
		{
			$fArray[] = $dirPath;
			return array('file'=>$fArray,'dir'=>$dArray);
		}
		//�������Ŀ¼
		if(!FileIo::isDirExists($dirPath))
		{
			return array('file'=>$fArray,'dir'=>$dArray);
		}

		$handle=opendir($dirPath);
		while($file=readdir($handle))
		{
			if($file=='.' || $file=='..') continue;
			$fileName = $dirPath.$file;
			if(FileIo::isDirExists($fileName))
			{
				$dArray[] = $file;
			}
			if(FileIO::isFileExists($fileName))
			{
				$fArray[] = $file;
			}
		}
		closedir($handle);
		return array('file'=>$fArray,'dir'=>$dArray);
		
	}
	/**
	* 
	* @author  sanshi
	* @version 1.0.0 Thu Aug 18 01:08:55 CST 2005
	* @param 		string		$fileName	�ļ���		
	* @return  		string		$fileType	�ļ���׺
	* @deprecated
	*	ȡ���ļ���׺��ֻȡ���ļ������һ����׺����
	*/
	function getFileType($fileName)
	{
		return strtolower(end(explode('.',$fileName)));
	}
	/**
	*д��һ���ļ�
	*@param $fileName	�ļ�����
	*@param $data		�ļ���д�������
	*@param $mode		�ļ�д��ģʽ
	*@return bool		�ɹ�����true ʧ���о�����ʾ
	*/
	function writeFile($fileName,$data,$mode="",$isCp=false)
	{
		global $FILEERRORMSG;
		$fileName = str_replace("\\","/",$fileName);
		$dirName = dirname( $fileName );//��ò����ļ�Ŀ¼
		//$data=strval($data);
		if( !is_dir($dirName) ) //�������Ŀ¼
		{
			if( !FileIo::createDir($dirName) ) //������ܽ���Ŀ¼
			{
				return false; 
			}
		}
		//����bak�ļ�
		if( FileIO::isFileExists($fileName) && $isCp ) //�ж��ļ��Ƿ����
				FileIO::copyFile($fileName,$fileName."_".date("Y,m,d,H,i,s")); //�����ļ����ɹ�����true
		if( function_exists("file_put_contents") && empty($mode) ) //�������������$mode�ǿ�
		{
			$inputLen = file_put_contents($fileName,strval($data)); //��$date���ַ���д��$fileName�ļ�����
			if( $inputLen != strlen($data) ) //���$inputLen û�г���
			{
				//trigger_error($FILEERRORMSG[1],SystemExceptionType(2));
				return false; 
			}
		}else{
			$mode .= empty($mode) ? "w+":"b";  //�ǿվ�д�룬������Ƕ�����b
			//echo $mode; exit();
			$fp = fopen($fileName,$mode);
			if( !$fp )
			{
				//trigger_error($FILEERRORMSG[1],SystemExceptionType(2));
				return false;
			}
			fwrite($fp,$data,strlen($data));  //д������
			@fclose($fp); //�ر����� 
		}
		return true;
	}
	/**
	* ����Ŀ¼
	*@parma		$dirName	Ŀ¼����
	*@return	bool		�ɹ�����true
	*/
	function createDir($dirName)
	{
		//echo $dirName;exit();
		global $FILEERRORMSG;
		$dirName = str_replace("\\","/",$dirName);
		$dirArr = explode('/',$dirName);
		//���ӶԾ���Ŀ¼���ж�
		if(substr($dirName,0,1)=='/')
			$dirTemp = "/";
		else
			$dirTemp = "";
		foreach( (array)$dirArr as $dir )
		{
			if( empty($dir) ) continue;
			$dirTemp.= $dir."/";
			if( !is_dir($dirTemp) )
			{
				if( !@mkdir($dirTemp,0777) )
				{
					trigger_error($FILEERRORMSG[0]."dir:".$dirTemp,SystemExceptionType(2));
					return false;
				}
				chmod($dirTemp,0777);
			}
		}
		
		return true;
	}
	/**
	*ȡ���ļ�������
	*@parma		$fileName	Ҫȡ�õ��ļ�����
	*@return	���ʧ�ܷ��� false �ɹ������ļ�����
	*/
	function getFileContent( $fileName )
	{
		if( !FileIO::isFileExists($fileName) ) return false;
		if( function_exists("file_get_contents") )
			return file_get_contents( $fileName );
		else
			return fread( fopen($fileName,"r"),filesize($fileName)+1 );

	}
	/**
	*�ж�һ���ļ��Ƿ����
	*@param		$fileName	�жϵ��ļ�����
	*@return	bool		������ڷ���true
	*/
	function isFileExists( $fileName )
	{
		clearstatcache();
		return file_exists( $fileName ) && is_file( $fileName );
	}
	/**
	*�ж�һ���ļ��Ƿ����
	*@param		$dirName	�жϵ��ļ�����
	*@return	bool		������ڷ���true
	*/
	function isDirExists( $dirName )
	{
		clearstatcache();
		return file_exists( $dirName ) && is_dir( $dirName );
	}
	/**
	*ɾ���ļ�
	*@param		$fileName	ɾ�����ļ�����	
	*@return	bool		ɾ���ɹ�����true
	*/
	function delFile($fileName)
	{
		//global $FILEERRORMSG;
		if( FileIO::isFileExists($fileName) )
			return unlink($fileName);
		//trigger_error($FILEERRORMSG[2],SystemExceptionType(2));
		return true;
	}
	/**
	*ɾ��Ŀ¼
	*@param		$dirName	ɾ����Ŀ¼����	
	*@return	bool		ɾ���ɹ�����true
	*/
	function delDir($dirName)
	{
		global $FILEERRORMSG;
		 if( !FileIO::isDirExists($dirName) )
		 {
			trigger_error($FILEERRORMSG[3],SystemExceptionType(2));
		 }
		 $handle = @opendir($dirName);
		 while(false !== ($file = @readdir($handle)))
		 {
            if($file != "." && $file != "..")
            {
                @chmod($dirName . "/" . $file, 0777); //�ı��ļ�ģʽ
                if(FileIO::isDirExists($dirName . "/" . $file))  //�ж�Ŀ¼�Ƿ����
                {
                    FileIO::delDir($dirName . "/" . $file); //���ھ�ɾ��Ŀ¼
                }else{
                    if( !FileIO::delFile($dirName . "/" . $file)) return false; //
                }
            }
         }
        @closedir($handle);
        @rmdir($dirName);
		return true;
	}
	/**
	*�ļ�����
	*@param		$source		Դ�ļ�
	*@param		$dest		Ŀ���ļ�
	*return		bool		���Ƴɹ�����true
	*/
	function copyFile($source, $dest)
	{
		if( !FileIO::isFileExists($source) ) return false;
		$destDir = dirname($dest);
		if( !FileIO::isDirExists($destDir))
		{
			if( !FileIO::createDir($destDir) ) return false;
		}
		return copy($source, $dest);
	}
	/**
	*Ŀ¼����
	*@param		$source		Դ�ļ�
	*@param		$dest		Ŀ���ļ�
	*return		bool		���Ƴɹ�����true
	*/
	function copyDir($source, $dest)
	{
		if( !FileIO::isDirExists($source) ) return false;
		if( !FileIO::isDirExists($dest) ) FileIO::createDir( $dest );
		$handle = @opendir($source);
		 while(false !== ($file = @readdir($handle)))
		 {
            if($file != "." && $file != "..")
            {
				@chmod($source . "/" . $file, 0777);
				if( FileIO::isDirExists($source . "/" . $file) )
				{ 
					FileIO::copyDir( $source."/".$file."/",$dest."/".$file."/" );
				}else{
					if( !FileIO::copyFile( $source."/".$file,$dest."/".$file ) )
					{
						@closedir($handle);
						return false;
					}
				}
			}
         }
        @closedir($handle);
		return true;
	}
	/**
	*�ļ��ƶ�
	*@param		$source		Դ�ļ�
	*@param		$dest		Ŀ���ļ�
	*return		bool		���Ƴɹ�����true
	*/
	function moveFile($source,$dest)
	{
		return FileIO::copyFile($source,$dest) && FileIo::delFile($source);
	}
	/**
	*Ŀ¼�ƶ�
	*@param		$source		Դ�ļ�
	*@param		$dest		Ŀ���ļ�
	*return		bool		���Ƴɹ�����true
	*/
	function moveDir($source,$dest)
	{
		return FileIO::copyDir($source,$dest) && FileIo::delDir($source);
	}
	
	//�������齨�����������ļ�
	/**
	 * @param  $result Ϊ��������������,�±�Ϊid,ֵΪtitle
	 * @param  $cacheName Ϊ��������������,�ļ���Ϊ .data.php
	 * @param  $dir       Ϊ�����ļ�����ĵ�ַ
	 * @param  $key       ��������±� ȡ�������ֵ��Ϊ���������±�
	 * @param  $value     ��������±� ȡ�������ֵ��Ϊ���������ֵ
	 * */
	function makeCacheFile($result,$cacheName,$dir,$key='id',$value='title')
	{
		$temp[] ="<?php";
		$temp[] ="\${$cacheName} = array();";
		for ($i=0;$i<count($result);$i++)
		{
			if(isset($result[$i][$key]))
				$temp[] = "\${$cacheName}['{$result[$i][$key]}']=\"{$result[$i][$value]}\";";
			else 
				$temp[] = "\${$cacheName}[]=\"{$result[$i][$value]}\";";
		}
		$temp[] = "?>";
		$fileName = $dir."{$cacheName}.data.php";
		//print_r(implode("\n",$temp));exit();
		unset($result);
		return $make = FileIO::writeFile($fileName,implode("\n",$temp));
	}
	function makeCacheFile2($result,$cacheName,$dir,$key='id',$value='title')
	{
		$temp[] ="<?php";
		$temp[] ="\${$cacheName} = array();";
		for ($i=0;$i<count($result);$i++)
		{
			if(isset($result[$i][$key]))
				$temp[] = "\${$cacheName}['{$result[$i][$key]}'][]=\"{$result[$i][$value]}\";";
			else 
				$temp[] = "\${$cacheName}[]=\"{$result[$i][$value]}\";";
		}
		$temp[] = "?>";
		$fileName = $dir."{$cacheName}.data.php";
		//print_r(implode("\n",$temp));exit();
		unset($result);
		return $make = FileIO::writeFile($fileName,implode("\n",$temp));
	}
	function makeArrayCache($cacheName,$cacheArr,$dir,$filePostfix="data.php")
	{
		$temp[] ="<?php";
		$temp[] ="\${$cacheName} = array();";
		foreach ($cacheArr as $i => $value)
		{
			$cache = $cacheArr[$i];
			if(is_array($cache))
			{
				foreach($cache As $k=>$v)
				{
					$v = str_replace("\n","",$v);
					$temp[] = "\${$cacheName}[{$i}][{$k}]=\"{$v}\";";
				}
				
			}else{
				$cache = str_replace("\n","",$cache);
				$temp[] ="\${$cacheName}[{$i}]=\"{$cache}\";";
			}
		}
		$temp[] = "?>";
		$fileName = $dir."{$cacheName}.{$filePostfix}";
		//print_r(implode("\n",$temp));exit();
		unset($cacheArr);
		return $make = FileIO::writeFile($fileName,implode("\n",$temp));
	}
	//�������齨�����������ļ�
	/**
	 * @param  $str Ϊhash���ֶ�
	 * @return fileName Ϊhash����ļ�������Ŀ¼��
	 * */
	function getHashFileName($str,$isFileName=false)
	{
		$fileName = "";
		$hashTemp = md5(strval($str));
		$fileName .=substr($hashTemp,0,2)."/";//һ��Ŀ¼Ϊ256��
		$fileName .=substr($hashTemp,2,2)."/";//����Ŀ¼�µ���Ŀ¼Ϊ 256��
		$fileName .=substr($hashTemp,4,3);//����Ŀ¼�µ���Ŀ¼Ϊ 4096��
		if($isFileName)
		{
			$fileName .=substr($hashTemp,7);
		}
		//$fileName .=substr($hashTemp,7);
		return $fileName;
	}
	/**
	 * @param  $fileName  �ļ���
	 * @param  $overTime  ����ʱ��
	 * @return ����true
	 * */
	function isOverTime($fileName,$overTime)
	{
		if(FileIO::isFileExists($fileName))
		{
			//php5
			//if(time()-fileatime($fileName)>$overTime)
			//php 4
			if(time()-filemtime($fileName)>$overTime)
			{
				return true;
			}else {
				return false;
			}
		}
		return true;
	}
}

function SystemExceptionType($type)
{
	$type = intval($type);
	if($type <0 || $type>2 ) $type = 0;
	$ErrorType[0] = E_USER_ERROR;
	$ErrorType[1] = E_USER_WARNING;
	$ErrorType[2] = E_USER_NOTICE;
	return $ErrorType[$type];
}
//echo FileIO::moveDir("c2","c3");
//echo FileIO::copyDir("cache","c2");
//echo FileIO::delDir("c2");
?>