<?php

class AdminManagerController extends Controller
{

    public function loginAction()
    {
        $this->display('login.html');
    }
    public function checkLoginAction()
    {
        new SessionDBTool();
        if(isset($_POST['captcha'])&&CaptchaTool::check($_POST['captcha']))
        {
            $this->redirect('index.php?p=Admin&c=AdminManager&a=login','验证码错误',2);
        }
        $adminManagerModel = new AdminManagerModel();
        $result = $adminManagerModel->checkLogin($_POST);
        if($result>0)
        {
            $_SESSION['hasLogin']=true;
            if(isset($_POST['remember']))
            {
                setcookie('user_id',$result['id'],60*60*24*30,'/');
                setcookie('user_password',md5($result['password'].'hello'),60*60*24*30,'/');
            }
            $this->redirect('index.php?p=Admin&c=Index&a=index');
        }
        $this->redirect('index.php?p=Admin&c=AdminManager&a=login','用户名或者密码不正确',2);
    }
    public function indexAction()
    {
        $adminManagerModel = new AdminManagerModel();
        $rows = $adminManagerModel->getAll();
        $this->assign('rows', $rows);
        $this->display('index.html');
    }

    public function editAction()
    {
        if (isset($_GET['id']))
        {
            $adminManagerModel = new AdminManagerModel();
            $row = $adminManagerModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $adminManagerModel = new AdminManagerModel();
        if(!empty($_POST['id']))
        {
            $result = $adminManagerModel->update($_POST);
            if ($result === false)
            {
                $this->redirect("index.php?p=Admin&c=AdminManager&a=edit&id={$_POST['id']}", $adminManagerModel->errorInfo, 2);
            }
        } else
        {
            $result = $adminManagerModel->save($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=AdminManager&a=edit', $adminManagerModel->errorInfo, 2);
            }
        }
        $this->redirect('index.php?p=Admin&c=AdminManager&a=index');
    }
    
    public function removeAction()
    {
        $id = $_GET['id'];
        $adminManagerModel = new AdminManagerModel();
        $adminManagerModel->deleteByPK($id);
        $this->redirect('index.php?p=Admin&c=AdminManager&a=index');
    }

}
