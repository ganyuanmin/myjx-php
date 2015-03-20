<?php

class UserRankController extends Controller
{

    public function indexAction()
    {
        $userrankModel = new UserrankModel();
        $rows = $userrankModel->getAll();
        $this->assign('rows', $rows);
        $this->display('index.html');
    }

    public function editAction()
    {
        if (isset($_GET['id']))
        {
            $userrankModel = new UserrankModel();
            $row = $userrankModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $userrankModel = new UserrankModel();
        if (empty($_POST['id']))
        {
            $result = $userrankModel->save($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Userrank&a=edit',$userrankModel->errorInfo,2);
            }
        }else
        {
            $result = $userrankModel->update($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Userrank&a=edit&id='.$_POST['id'],$userrankModel->errorInfo,2);
            }
        }
        $this->redirect('index.php?p=Admin&c=Userrank&a=index');
    }
    
    public function removeAction()
    {
        $id = $_GET['id'];
        $userrankModel = new UserrankModel();
        $userrankModel->deleteByPK($id);
        $this->redirect('index.php?p=Admin&c=Userrank&a=index');
    }
}
