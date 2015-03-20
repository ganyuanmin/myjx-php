<?php

class ArticleController extends Controller
{

    public function indexAction()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : $GLOBALS['config']['Admin']['pageSize'];
        $articleCatModel = new ArticleCatModel();
        $articleCats = $articleCatModel->getList();
        $this->assign('articleCats', $articleCats);
        $articleModel = new ArticleModel();
        $pageResult = $articleModel->getPageResult($page, $pageSize, "1=1 order by id desc");
        $pageHtml = PageTool::show('index.php?p=Admin&c=Article&a=index', $pageResult['count'], $page, $pageSize);
        $this->assign('rows', $pageResult['rows']);
        $this->assign('pageHtml', $pageHtml);
        setcookie('__forword__',$_SERVER['REQUEST_URI']);
        $this->display('index.html');
    }

    public function editAction()
    {
        if ($_GET['id'])
        {
            $articleModel = new ArticleModel();
            $row = $articleModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $articleModel = new ArticleModel();
        if (empty($_POST['id']))
        {
            $result = $articleModel->save($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Article&a=edit', $articleModel->errorInfo, 2);
            }
        } else
        {
            $result = $articleModel->update($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Article&a=edit&id=' . $_POST['id'], $articleModel->errorInfo, 2);
            }
        }
        $this->redirect($_COOKIE['__forword__']);
    }
    
    public function removeAction()
    {
        $articleModel = new ArticleModel();
        $articleModel->deleteByPK($_GET['id']);
        $this->redirect($_COOKIE['__forword__']);
    }

}
