<?php

class ArticleCatController extends Controller
{

    public function indexAction()
    {
        $articleCatModel = new ArticleCatModel();
        $articleTypeModel = new ArticleTypeModel();
        $types = $articleTypeModel->getAll();
        $rows = $articleCatModel->getList();
        $this->assign('rows', $rows);
        $this->assign('types', $types);
        $this->display('index.html');
    }

    public function editAction()
    {
        $articleCatModel = new ArticleCatModel();
        $rows = $articleCatModel->getList();
        if (isset($_GET['id']))
        {
            $row = $articleCatModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->assign('rows', $rows);
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $articleCatModel = new ArticleCatModel();
        if (empty($_POST['id']))
        {
            $result = $articleCatModel->save($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=ArticleCat&a=edit', $articleCatModel->errorInfo, 2);
            }
        } else
        {
            $result = $articleCatModel->update($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=ArticleCat&a=edit&id=' . $_POST['id'], $articleCatModel->errorInfo, 2);
            }
        }
        $this->redirect('index.php?p=Admin&c=ArticleCat&a=index');
    }

    public function removeAction()
    {
        $id = $_GET['id'];
        $articleCatModel = new ArticleCatModel();
        $result = $articleCatModel->delete($id);
        if($result === false)
        {
            $this->redirect('index.php?p=Admin&c=ArticleCat&a=index');
        }
        $this->redirect('index.php?p=Admin&c=ArticleCat&a=index');
    }

}
