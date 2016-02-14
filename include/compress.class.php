  <?
    /*
    * ѹ��ͼƬ��
    * ���ܣ�        ��ͼƬѹ����ָ����С
    * ֧��ͼƬ���ͣ�jpg/gif/png
    * ������       Huloo
    * ʱ��:         2007-8-17
    * ����޸�ʱ��: 2007-8-18
    */
    
    class CompressImage
    {
     public  $src_img_path;  //Դ�ļ�·��
     public  $dsc_img_path;  //Ŀ���ļ�·��
     public  $dsc_size;      //Ŀ���ļ��ߴ�
     private $handle;        //��ȡͼƬ���
     private $src_dir;       //Դ�ļ�Ŀ¼
     private $src_name;      //Դ�ļ���
     private $src_ext;       //Դ�ļ���ʽ
     private $separator;     //Ŀ¼�ָ���
     private $src_w;         //Դ�ļ���
     private $src_h;         //Դ�ļ���
     private $spe_char;      //ת��ת���ַ�(����)
     
     function __construct($src_img_path='',$dsc_dir='',$dsc_size='')
     {
      $src_img_path == '' && $this->Error("Դ�ļ�·��Ϊ��");
      $this->src_img_path = $src_img_path;
      $this->setsrcvars();
      $this->dsc_img_path  = $dsc_dir == ''? $this->src_dir:$dsc_dir;
      $this->dsc_size = $dsc_size;     
      $this->sethandle();
      $this->setimagewidth();
      $this->setimageheight();
      //$this->spe_char = array("\n"=>"\\n","\r"=>"\\r","\t"=>"\\t","\1"=>"\\1","\2"=>"\\2","\3"=>"\\3","\4"=>"\\4","\5"=>"\\5","\6"=>"\\6","\7"=>"\\7","\\"=>"\\\\");
     }
       
     //����Դ�ļ���Ϣ
     function setsrcvars()
     {
      $this->setseparator();
      $pos = strrpos($this->src_img_path,$this->separator);
      $this->src_dir = $pos === false? "." : substr($this->src_img_path, 0, $pos);
      $imgname = $pos === false? $this->src_img_path:substr($this->src_img_path, $pos+1);
      $pos = strrpos($imgname,".");
      $this->src_name = substr($imgname, 0, $pos);
      $this->src_ext  = substr($imgname, $pos+1);
      strpos("jpg/jpeg/gif/png",$this->src_ext) === false && $this->Error("�ݲ�֧�ִ�ͼƬ��ʽ");
     }
     
     //����Ŀ¼�ָ���
     function setseparator()
     {
      $os = getenv("os");
      if($os == 'Windows_NT')      
      {              
         $this->separator = "\\";    //windows����ϵͳ
     }
      else
         $this->separator = "/";     //linux����ϵͳ
   }
  
     //���ö�ȡͼƬ���
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
     
     //��ȡԴͼƬ�Ŀ�
     function setimagewidth()
     {
      $this->src_w = imagesx($this->handle); 
     }
  
     //��ȡԴͼƬ�ĸ�
     function setimageheight()
     {
      $this->src_h = imagesy($this->handle); 
     }
     
     //ѹ��ͼƬ
     function compress()
     {
      ($this->src_img_path == '' or $this->dsc_img_path == '') && $this->Error("Դ�ļ���Ŀ���ļ�·��Ϊ��"); 
      $this->dsc_size == '' && $this->Error("δ����Ŀ���ļ��ߴ�");
   
      //������ͼƬ��С
      $this->setimageheight();
      $this->setimagewidth();
      if($this->src_w == $this->src_h) $other_size = $this->dsc_size;
      if($this->src_w > $this->src_h) $other_size = intval(($this->src_h * $this->dsc_size)/$this->src_w);
      if($this->src_w < $this->src_h)
      {
       $other_size = $this->dsc_size;
       $this->dsc_size = intval(($this->src_w * $other_size)/$this->src_h);
      }
      //�������
      
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
         
     //���������Ϣ
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
  
     //������ʾ�������ִ���ʱ������ʾ����ִֹ��
     function Error($msg)
     {
      echo "<b>Error:</b>".$msg; 
      exit;
     }
    }
   ?>