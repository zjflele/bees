<?php
class cache {
  //����Ŀ¼
  var $cacheRoot        = "./cachefile/";
  //�������ʱ��������0Ϊ������
  var $cacheLimitTime   = 0;
  //�����ļ���
  var $cacheFileName    = "";
  //������չ��
  var $cacheFileExt     = "html";
 
  /*
   * ���캯��
   * int $cacheLimitTime �������ʱ��
   */
  function cache( $cacheLimitTime ,$cacheroot) {
	if ($cacheroot!='') $this->cacheRoot = $cacheroot;
    if( intval( $cacheLimitTime ) ) 
      $this->cacheLimitTime = $cacheLimitTime;
    $this->cacheFileName = $this->getCacheFileName();
    ob_start();
  }
  
  /*
   * ��黺���ļ��Ƿ������ø���ʱ��֮��
   * ���أ�����ڸ���ʱ��֮���򷵻��ļ����ݣ���֮�򷵻�ʧ��
   */
  function cacheCheck(){
    if( file_exists( $this->cacheFileName ) ) {
      $cTime = $this->getFileCreateTime( $this->cacheFileName );
      if( $cTime + $this->cacheLimitTime > time() ) {
		//header("Content-type: text/vnd.wap.wml; charset=utf-8");
        echo file_get_contents( $this->cacheFileName );
		//echo "ddd";
        //ob_end_flush();
        return true;
      }else{
		return false;
	  }
    }
  }
 
  /*
   * �����ļ����������̬
   * string $staticFileName ��̬�ļ����������·����
   */
  function caching( $staticFileName = "" ){
	$cTime = $this->getFileCreateTime( $this->cacheFileName );
    if( !($cTime + $this->cacheLimitTime > time()) ) {
    if( $this->cacheFileName ) {
      $cacheContent = ob_get_contents();
      //echo $cacheContent;
      ob_end_flush();
 
      if( $staticFileName ) {
          $this->saveFile( $staticFileName, $cacheContent );
      }
 
      if( $this->cacheLimitTime )
        $this->saveFile( $this->cacheFileName, $cacheContent );
    }
	}else{
	  ob_end_flush();
	}
  }
  
  /*
   * ��������ļ�
   * string $fileName ָ���ļ���(������)����all��ȫ����
   * ���أ�����ɹ�����true����֮����false
   */
  function clearCache( $fileName = "all" ) {
    if( $fileName != "all" ) {
      $fileName = $this->cacheRoot . strtoupper(md5($fileName)).".".$this->cacheFileExt;
      if( file_exists( $fileName ) ) {
        return @unlink( $fileName );
      }else return false;
    }
    if ( is_dir( $this->cacheRoot ) ) {
      if ( $dir = @opendir( $this->cacheRoot ) ) {
        while ( $file = @readdir( $dir ) ) {
          $check = is_dir( $file );
          if ( !$check )
          @unlink( $this->cacheRoot . $file );
        }
        @closedir( $dir );
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
 
  /*
   * ���ݵ�ǰ��̬�ļ����ɻ����ļ���
   */
  function getCacheFileName() {	
	$RE_URL = (strpos($_SERVER["REQUEST_URI"],"index.php") == false)?$_SERVER["REQUEST_URI"]:"index.php";
    return  $this->cacheRoot . strtoupper(md5($RE_URL)).".".$this->cacheFileExt;
  }
 
  /*
   * �����ļ�����ʱ��
   * string $fileName   �����ļ����������·����
   * ���أ��ļ�����ʱ���������ļ������ڷ���0
   */
  function getFileCreateTime( $fileName ) {
    if( ! trim($fileName) ) return 0;
 
    if( file_exists( $fileName ) ) { 
      return intval(filemtime( $fileName ));
    }else return 0;
  }
  
  /*
   * �����ļ�
   * string $fileName  �ļ����������·����
   * string $text      �ļ�����
   * ���أ��ɹ�����ture��ʧ�ܷ���false
   */
  function saveFile($fileName, $text) {
    if( ! $fileName || ! $text ) return false;
 
    if( $this->makeDir( dirname( $fileName ) ) ) {
      if( $fp = fopen( $fileName, "w" ) ) {
        if( @fwrite( $fp, $text ) ) {
          fclose($fp);
          return true;
        }else {
          fclose($fp);
          return false;
        }
      }
    }
    return false;
  }
 
  /*
   * ������Ŀ¼
   * string $dir Ŀ¼�ַ���
   * int $mode   Ȩ������
   * ���أ�˳����������ȫ���ѽ�����true��������ʽ����false
   */
  function makeDir( $dir, $mode = "0777" ) {
    if( ! $dir ) return 0;
    $dir = str_replace( "\\", "/", $dir );
    
    $mdir = "";
    foreach( explode( "/", $dir ) as $val ) {
      $mdir .= $val."/";
      if( $val == ".." || $val == "." || trim( $val ) == "" ) continue;
      
      if( ! file_exists( $mdir ) ) {
        if(!@mkdir( $mdir, $mode )){
         return false;
        }
      }
    }
    return true;
  }
}
?>