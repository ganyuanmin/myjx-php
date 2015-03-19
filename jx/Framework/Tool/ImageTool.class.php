<?php

class ImageTool
{

    private $createFunctions = array(
        'image/png' => 'imagecreatefrompng',
        'image/jpeg' => 'imagecreatefromjpeg',
        'image/gif' => 'imagecreatefromgif',
    );
    private $outFunctions = array(
        'image/png' => 'imagpng',
        'image/jpeg' => 'imagejpeg',
        'image/gif' => 'imagegif',
    );
    private $errorInfo;
    public function thomb($srcPath, $maxWidth, $maxHeight)
    {
        $srcPath = ROOT_PATH . $srcPath;
        if(!file_exists($srcPath))
        {
            $this->errorInfo = '上传的图片路径不存在';
            return false;
        }
        $imageSize = getimagesize($srcPath);
        list($srcWidth,$srcHeight) = $imageSize;
        $mimeType = $imageSize['mime'];
        $scale = max($srcWidth/$maxWidth,$srcHeight/$maxHeight);
        $width = $srcWidth/$scale;
        $height = $srcHeight/$scale;
        $createFunction = $this->createFunctions[$mimeType];
        $src = $createFunction($srcPath);
        $filenameArray = pathinfo($srcPath);
        $filename = $filenameArray['dirname'] .'/'. $filenameArray['filename'] .'_small.' .$filenameArray['extension'];
        $thumb = imagecreatetruecolor($maxWidth, $maxHeight);
        $color = imagecolorallocate($thumb, 255, 255, 255);
        imagefill($thumb, 0, 0, $color);       
        imagecopyresampled($thumb,$src, ($maxWidth-$width)/2, ($maxHeight-$height)/2, 0, 0,$width, $height, $srcWidth, $srcHeight);
        $outFunction = $this->outFunctions[$mimeType];
        $outFunction($thumb,$filename);
        return str_replace(ROOT_PATH, '', $filename);
    }
    
    public function __get($name)
    {
        if($name =='errorInfo')
        {
            return $this->errorInfo;
        }
    }
}
