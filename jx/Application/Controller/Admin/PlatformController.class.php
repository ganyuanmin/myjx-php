<?php

class PlatformController extends Controller
{

    public function __construct()
    {
        $this->checkLogin();
    }

    private function checkLogin()
    {
        new SessionDBTool();
        if(CONTROLLER_NAME=='checkLogin')
        {
            return ;
        }
        if (!isset($_SESSION['hasLogin']))
        {
            if(isset($_COOKIE['user_id'])&&isset($_COOKIE['user_password']))
            {
                $adminManagerModel = new AdminManagerModel();
                $row = $adminManagerModel->getByPK($_COOKIE['id']);
                if($_COOKIE['user_id']==$row['id']&&$_COOKIE['user_password']==  md5($row['password'] . 'hello'))
                {
                    $this->redirect('index.php?p=Admin&c=Index&a=index');
                }
            }
            $this->redirect('index.php?p=Admin&c=AdminManager&a=login');
        }
    }

}
