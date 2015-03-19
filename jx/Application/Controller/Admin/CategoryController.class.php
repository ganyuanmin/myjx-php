<?php

class CategoryController extends Controller
{

    public function indexAction()
    {
        $categoryModel = new CategoryModel();
        $rows = $categoryModel->getList();
        $this->assign('rows', $rows);
        $this->display('index.html');
    }

    public function editAction()
    {
        $categoryModel = new CategoryModel();
        if (!empty($_GET['id']))
        {
            $category = $categoryModel->getByPK($_GET['id']);
            $this->assign($category);
        }
        $rows = $categoryModel->getList();
        $this->assign('rows', $rows);
        $this->display('edit.html');
    }

    public function removeAction()
    {
        $id = $_GET['id'];
        $categoryModel = new CategoryModel();
        $result = $categoryModel->delete($id);
        if (!$result)
        {
            $this->redirect('index.php?p=Admin&c=Category&a=index', $categoryModel->errorInfo, 2);
        } else
        {
            $this->redirect('index.php?p=Admin&c=Category&a=index');
        }
    }

    public function saveAction()
    {
        $categoryModel = new CategoryModel();
        if (empty($_POST['id']))
        {
            $result = $categoryModel->save($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Category&a=edit', $categoryModel->errorInfo, 2);
            }
        } else
        {
            $result = $categoryModel->update($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Category&a=edit&id=' . $_POST['id'], $categoryModel->errorInfo, 2);
            }
        }
        $this->redirect('index.php?p=Admin&c=Category&a=index');
    }

}
