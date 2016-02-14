<?php
/*
* Copyright (C) 2006-2007 foolmen.com
* 
* File Name: picThumb.func.php
* ��������ͼ.
* 
* Last Modified:
*         2006-02-24 11:49
*/
define(OP_TO_FILE, 1);              //�����ָ���ļ�
define(OP_OUTPUT, 2);               //ͼƬ��������������
define(OP_NOT_KEEP_SCALE, 4);       //������ͼƬ����, ��ʹ������
define(OP_BEST_RESIZE_WIDTH, 8);    //���������� 
define(OP_BEST_RESIZE_HEIGHT, 16);  //�߶�������� 
define(CM_DEFAULT,  0);             // Ĭ��ģʽ
define(CM_LEFT_OR_TOP,  1);         // �����
define(CM_MIDDLE,       2);         // ��
define(CM_RIGHT_OR_BOTTOM,  3);     // �һ���
/**************************************************************************
* ������: makeThumb
* ����: ��������ͼƬ
* @param string $srcFile Դ�ļ�
* @param string $srcFile Ŀ���ļ�
* @param int $dstW Ŀ��ͼƬ�Ŀ�ȣ���λ�����أ�
* @param int $dstH Ŀ��ͼƬ�ĸ߶ȣ���λ�����أ�
* @param int $option ���Ӳ������������ʹ�ã���1+2(���� 1|2)��ʾͬʱִ��1��2�Ĺ��ܡ�
*      1: Ĭ�ϣ������ָ���ļ� 2: ͼƬ�������������� 4: ������ͼƬ���� 
*      8������������ 16���߶��������
* @param int $cutmode ����ģʽ 0: Ĭ��ģʽ������ģʽ 1: ����� 2: �� 3: �һ���
* @param int $startX ���е���ʼ�����꣨���أ�
* @param int $startY ���е���ʼ�����꣨���أ�
* @return array return[0]=0: ����; return[0] Ϊ������� return[1] string: ��������
* ������룺* -1 Դ�ļ������ڡ�-2 ��֧�ֵ�ͼƬ�������
* -3 ��֧�ֵ�ͼƬ��������
* -4 HTTPͷ��Ϣ�Ѿ�������޷�����������ͼƬ��
* -5 �޷���������ͼƬ����
**************************************************************************/
function makeThumb( $srcFile, $dstFile, $dstW, $dstH, $option=OP_TO_FILE, 
    $cutmode=CM_DEFAULT, $startX=0, $startY=0 ) {
    $img_type = array(1=>"gif", 2=>"jpeg", 3=>"png");
    $type_idx = array("gif"=>1, "jpg"=>2, "jpeg"=>2, "jpe"=>2, "png"=>3);
    
    if (!file_exists($srcFile)) {
        return array(-1, "Source file not exists: $srcFile.");
    }

    $path_parts = @pathinfo($dstFile);
    $ext = strtolower ($path_parts["extension"]);
    if ($ext == "") {
        return array(-5, "Can't detect output image's type.");
    }

    $func_output = "image" . $img_type[$type_idx[$ext]];
    if (!function_exists ($func_output)) {
        return array(-2, "Function not exists for output��$func_output.");
    }

    $data = @GetImageSize($srcFile);
    $func_create = "imagecreatefrom" . $img_type[$data[2]];
    if (!function_exists ($func_create)) {
        return array(-3, "Function not exists for create��$func_create.");
    }

    $im = @$func_create($srcFile);
    $srcW = @ImageSX($im);
    $srcH = @ImageSY($im);
    $srcX = 0;
    $srcY = 0;
    $dstX = 0;
    $dstY = 0;

    if ($option & OP_BEST_RESIZE_WIDTH) {
        $dstH = round($dstW * $srcH / $srcW);
    }

    if ($option & OP_BEST_RESIZE_HEIGHT) {
        $dstW = round($dstH * $srcW / $srcH);
    }

    $fdstW = $dstW;
    $fdstH = $dstH;

    if ($cutmode != CM_DEFAULT) { // ����ģʽ 1: ����� 2: �� 3: �һ���
        $srcW -= $startX;
        $srcH -= $startY;
        if ($srcW*$dstH > $srcH*$dstW) { 
            $testW = round($dstW * $srcH / $dstH);
            $testH = $srcH;
        } else {
            $testH = round($dstH * $srcW / $dstW);
            $testW = $srcW;
        }
        switch ($cutmode) {
            case CM_LEFT_OR_TOP: $srcX = 0; $srcY = 0; break;
            case CM_MIDDLE: $srcX = round(($srcW - $testW) / 2); 
                            $srcY = round(($srcH - $testH) / 2); break;
            case CM_RIGHT_OR_BOTTOM: $srcX = $srcW - $testW; 
                                     $srcY = $srcH - $testH;
        }
        $srcW = $testW;
        $srcH = $testH;
        $srcX += $startX;
        $srcY += $startY;
    } else { // ԭʼ����
        if (!($option & OP_NOT_KEEP_SCALE)) {
            // ���´�������´�С��������ͼƬ����
            if ($srcW*$dstH>$srcH*$dstW) { 
                $fdstH=round($srcH*$dstW/$srcW); 
                $dstY=floor(($dstH-$fdstH)/2); 
                $fdstW=$dstW;
            } else { 
                $fdstW=round($srcW*$dstH/$srcH); 
                $dstX=floor(($dstW-$fdstW)/2); 
                $fdstH=$dstH;
            }

            $dstX=($dstX<0)?0:$dstX;
            $dstY=($dstX<0)?0:$dstY;
            $dstX=($dstX>($dstW/2))?floor($dstW/2):$dstX;
            $dstY=($dstY>($dstH/2))?floor($dstH/s):$dstY;
        }
    } /// end if ($cutmode != CM_DEFAULT) { // ����ģʽ

    if( function_exists("imagecopyresampled") and 
        function_exists("imagecreatetruecolor") ){
        $func_create = "imagecreatetruecolor";
        $func_resize = "imagecopyresampled";
    } else {
        $func_create = "imagecreate";
        $func_resize = "imagecopyresized";
    }

    $newim = @$func_create($dstW,$dstH);
    $black = @ImageColorAllocate($newim, 255,255,255);
    $back = @imagecolortransparent($newim, $black);
    @imagefilledrectangle($newim,0,0,$dstW,$dstH,$black);
    @$func_resize($newim,$im,$dstX,$dstY,$srcX,$srcY,$fdstW,$fdstH,$srcW,$srcH);

    if ($option & OP_TO_FILE) {
        @$func_output($newim,$dstFile);
    }

    if ($option & OP_OUTPUT) {
        if (function_exists("headers_sent")) {
            if (headers_sent()) {
                return array(-4, "HTTP already sent, can't output image to browser.");
            }
        }
        header("Content-type: image/" . $img_type[$type_idx[$ext]]);
        @$func_output($newim);
    }

    @imagedestroy($im);
    @imagedestroy($newim);
    return array(0, "OK");
} 
?>