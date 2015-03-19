<?php

abstract class Controller
{

    public function redirect($url, $msg = '', $times = 0)
    {
        if (headers_sent())
        {
            echo <<<JS
         <script type="text/javascript">
            window.setTimeout(function()
            {
                window.location
            },$times.'000')
        </script>  
JS;
            if ($times)
            {
                echo $msg;
            }
        } else
        {
            if (!$times)
            {
                header('Location:' . $url);
            } else
            {
                echo $msg;
                header("refresh:$times ; $url");
            }
        }
        exit();
    }

    private $data=array();

    public function display($fileName)
    {
        if (isset($this->data))
            extract($this->data);
        require CURRENT_VIEW_PATH . $fileName;
    }

    public function assign($name, $value = '')
    {
        if (is_array($name))
        {
            $this->data = array_merge($this->data, $name);
        } else
        {
            $this->data[$name] = $value;
        }
    }

}
