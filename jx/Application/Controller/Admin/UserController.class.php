<?php

class UserController extends Controller
{

    public function indexAction()
    {
        $condition = '';
        if (!empty($_REQUEST['keyword']))
        {
            $condition = "name like '%{$_REQUEST['keyword']}%'";
        }
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : $GLOBALS['config']['Admin']['pageSize'];
        $userModel = new UserModel();
        $pageResult = $userModel->getPageResult($page, $pageSize, $condition);
        $this->assign('rows', $pageResult['rows']);
        $pageHtml = PageTool::show('index.php?p=Admin&c=User&a=index', $pageResult['count'], $page, $pageSize, $_REQUEST);
        $this->assign('pageHtml', $pageHtml);
        setcookie('__forword__', $_SERVER['REQUEST_URI']);
        $this->display('index.html');
    }

    public function editAction()
    {
        $userModel = new UserModel();
        if (isset($_GET['id']))
        {
            $row = $userModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $userModel = new UserModel();
        if (empty($_POST['id']))
        {
            $result = $userModel->save($_POST);
            if ($result == false)
            {
                $this->redirect('index.php?p=Admin&c=user&a=edit', $userModel->errorInfo, 2);
            }
        } else
        {
            $result = $userModel->update($_POST);
            if ($result == false)
            {
                $this->redirect('index.php?p=Admin&c=user&a=editid='.$_POST['id'], $userModel->errorInfo, 2);
            }
        }
        $this->redirect($_COOKIE['__forword__']);
    }
    
    public function removeAction()
    {
        $id = $_GET['id'];
        $userModel = new UserModel();
        $userModel->deleteByPK($id);
        $this->redirect($_COOKIE['__forword__']);
    }
}
