<?php

//

class UploadTool
{

    private $allowTypes;
    private $allowSize;
    private $errorInfo;

    public function __construct($allowTypes = '', $allowSize = '')
    {
        $this->allowTypes = $allowTypes;
        $this->allowSize = empty($allowSize) ? 1024 * 1024 * 2 : $allowSize;
    }

    public function uploadOne($fileName, $uploadPath)
    {
        $preDir = $uploadPath . '/' . date('ymd');
        $uploadDir = UPLOAD_PATH . $preDir;
        if (!is_dir($uploadDir))
        {
            mkdir($uploadDir, 0777, true);
        }
        if ($fileName['error'] != 0)
        {
            $this->errorInfo = '上传失败...';
            return false;
        }
        if (!empty($this->allowTypes) && !in_array($fileName['type'],$this->allowTypes))
        {
            $this->errorInfo = '上传的文件类型不符合要求....';
            return false;
        }
        if ($fileName['size'] > $this->allowSize)
        {
            $this->errorInfo = '上传的文件太大...';
            return false;
        }
        $newFilename = uniqid($uploadPath.'_') . date('YmdHis');
        $newFilename .= strrchr($fileName['name'], '.');
        move_uploaded_file($fileName['tmp_name'], $uploadDir . '/' . $newFilename);
        return 'Upload/' . $preDir . '/' . $newFilename;
    }

    public function multiUpload($files, $uploadPath)
    {
        $filesInfo = array();
        foreach ($files['error'] as $key => $error)
        {
            if ($error == 0)
            {
                $fileInfo['name'] = $files['name'][$key];
                $fileInfo['type'] = $files['type'][$key];
                $fileInfo['size'] = $files['size'][$key];
                $fileInfo['tmp_name'] = $files['tmp_name'][$key];
                $fileInfo['error'] = $files['error'][$key];
                $filesInfo[] = $fileInfo;
            }
        }
        $new_filenames = array();
        foreach ($filesInfo as $file)
        {
            $new_filename = $this->uploadOne($file, $uploadPath);
            if($new_filename ===false)
            {
                return false;
            }else
            {
                $new_filenames[] = $new_filename;
            }
        }
        return $new_filenames;
    }

    public function __set($name, $value)
    {
        if (in_array($name, array('allowTypes', 'allowSize')))
        {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if ($name == 'errorInfo')
        {
            return $this->errorInfo;
        }
    }

}
