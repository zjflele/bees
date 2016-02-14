  <?
    /*
    * 压缩图片类
    * 功能：        将图片压缩至指定大小
    * 支持图片类型：jpg/gif/png
    * 开发：       Huloo
    * 时间:         2007-8-17
    * 最后修改时间: 2007-8-18
    */
    
    class CompressImage
    {
     public  $src_img_path;  //源文件路径
     public  $dsc_img_path;  //目标文件路径
     public  $dsc_size;      //目标文件尺寸
     private $handle;        //读取图片句柄
     private $src_dir;       //源文件目录
     private $src_name;      //源文件名
     private $src_ext;       //源文件格式
     private $separator;     //目录分隔符
     private $src_w;         //源文件宽
     private $src_h;         //源文件高
     private $spe_char;      //转换转义字符(备用)
     
     function __construct($src_img_path='',$dsc_dir='',$dsc_size='')
     {
      $src_img_path == '' && $this->Error("源文件路径为空");
      $this->src_img_path = $src_img_path;
      $this->setsrcvars();
      $this->dsc_img_path  = $dsc_dir == ''? $this->src_dir:$dsc_dir;
      $this->dsc_size = $dsc_size;     
      $this->sethandle();
      $this->setimagewidth();
      $this->setimageheight();
      //$this->spe_char = array("\n"=>"\\n","\r"=>"\\r","\t"=>"\\t","\1"=>"\\1","\2"=>"\\2","\3"=>"\\3","\4"=>"\\4","\5"=>"\\5","\6"=>"\\6","\7"=>"\\7","\\"=>"\\\\");
     }
       
     //设置源文件信息
     function setsrcvars()
     {
      $this->setseparator();
      $pos = strrpos($this->src_img_path,$this->separator);
      $this->src_dir = $pos === false? "." : substr($this->src_img_path, 0, $pos);
      $imgname = $pos === false? $this->src_img_path:substr($this->src_img_path, $pos+1);
      $pos = strrpos($imgname,".");
      $this->src_name = substr($imgname, 0, $pos);
      $this->src_ext  = substr($imgname, $pos+1);
      strpos("jpg/jpeg/gif/png",$this->src_ext) === false && $this->Error("暂不支持此图片格式");
     }
     
     //设置目录分隔符
     function setseparator()
     {
      $os = getenv("os");
      if($os == 'Windows_NT')      
      {              
         $this->separator = "\\";    //windows操作系统
     }
      else
         $this->separator = "/";     //linux操作系统
   }
  
     //设置读取图片句柄
     function sethandle()
     {
      switch($this->src_ext)
      {
       case 'png':
        $this->handle = imagecreatefrompng($this->src_img_path);
        break;
       case 'jpg':
       case 'jpeg':
        $this->handle = imagecreatefromjpeg($this->src_img_path);
        break;
       case 'gif':
        $this->handle = imagecreatefromgif($this->src_img_path);
        break;
      } 
     }
     
     //读取源图片的宽
     function setimagewidth()
     {
      $this->src_w = imagesx($this->handle); 
     }
  
     //读取源图片的高
     function setimageheight()
     {
      $this->src_h = imagesy($this->handle); 
     }
     
     //压缩图片
     function compress()
     {
      ($this->src_img_path == '' or $this->dsc_img_path == '') && $this->Error("源文件或目标文件路径为空"); 
      $this->dsc_size == '' && $this->Error("未设置目标文件尺寸");
   
      //计算新图片大小
      $this->setimageheight();
      $this->setimagewidth();
      if($this->src_w == $this->src_h) $other_size = $this->dsc_size;
      if($this->src_w > $this->src_h) $other_size = intval(($this->src_h * $this->dsc_size)/$this->src_w);
      if($this->src_w < $this->src_h)
      {
       $other_size = $this->dsc_size;
       $this->dsc_size = intval(($this->src_w * $other_size)/$this->src_h);
      }
      //计算结束
      
      $newimgname = $this->src_name."_".$this->dsc_size."_".$other_size.".".$this->src_ext;
      
      $d_im = imagecreatetruecolor($this->dsc_size, $other_size);
      $white = imagecolorallocatealpha($d_im, 255, 255, 255, 0);
      imagefilledrectangle($d_im, 0, 0, $this->dsc_size, $other_size, $white);
      imagecopyresampled($d_im, $this->handle, 0, 0, 0, 0, $this->dsc_size, $other_size, $this->src_w, $this->src_h);
      switch($this->src_ext)
      {
       case 'png':
        imagepng($d_im,$this->dsc_img_path.$this->separator.$newimgname);
        break;
       case 'jpg':
       case 'jpeg':
        imagejpeg($d_im,$this->dsc_img_path.$this->separator.$newimgname);
        break;
       case 'gif':
        imagegif($d_im,$this->dsc_img_path.$this->separator.$newimgname);
        break;
      }
     }
         
     //输出变量信息
     function echovars()
     {
      echo "src_img_path:".$this->src_img_path."<br />"; 
      echo "dsc_img_path:".$this->dsc_img_path."<br />"; 
      echo "dsc_size:".$this->dsc_size."<br />"; 
      echo "src_dir:".$this->src_dir."<br />"; 
      echo "src_name:".$this->src_name."<br />"; 
      echo "src_ext:".$this->src_ext."<br />"; 
      echo "separator:".$this->separator."<br />"; 
      echo "src_w:".$this->src_w."<br />"; 
      echo "src_h:".$this->src_h."<br />"; 
    }
  
     //错误提示，当出现错误时产生提示并终止执行
     function Error($msg)
     {
      echo "<b>Error:</b>".$msg; 
      exit;
     }
    }
   ?>