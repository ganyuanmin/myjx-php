<?php

class ArticleTypeController extends Controller
{

    public function indexAction()
    {
        $articleModel = new ArticleTypeModel();
        $rows = $articleModel->getAll();
        $this->assign('rows', $rows);
        $this->display('index.html');
    }

    public function editAction()
    {
        if (isset($_GET['id']))
        {
            $articleTypeModel = new ArticleTypeModel();
            $row = $articleTypeModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $articleTypeModel = new ArticleTypeModel();
        if (empty($_POST['id']))
        {
            $result = $articleTypeModel->save($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=ArticleType&a=edit', $articleTypeModel->errorInfo, 2);
            }
        } else
        {
            $result = $articleTypeModel->update($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=ArticleType&a=edit&id='.$_POST['id'], $articleTypeModel->errorInfo, 2);
            }
        }
        $this->redirect('index.php?p=Admin&c=ArticleType&a=index');
    }
    
    public function removeAction()
    {
        $id = $_GET['id'];
        $articleTypeModel = new ArticleTypeModel();
        $articleTypeModel->deleteByPK($id);
        $this->redirect('index.php?p=Admin&c=ArticleType&a=index');
    }
}
