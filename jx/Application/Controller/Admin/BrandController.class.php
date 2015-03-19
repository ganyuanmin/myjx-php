<?php

class BrandController extends Controller
{

    public function indexAction()
    {
        $page = isset($_GET['page'])?$_GET['page']:1;
        $pageSize = isset($_GET['pageSize'])?$_GET['pageSize']:$GLOBALS['config']['Admin']['pageSize'];
        $brandModel = new BrandModel();
        $condition = '';
        if(isset($_REQUEST['keyword']))
        {
            $condition = "name like '%{$_REQUEST['keyword']}%'";
        }
        $pageResult = $brandModel->getPageResult($page, $pageSize,$condition);
        $pageHtml = PageTool::show("index.php?p=Admin&c=Brand&a=index", $pageResult['count'], $page, $pageSize,$_REQUEST);
        $this->assign('rows', $pageResult['rows']);
        $this->assign('pageHtml',$pageHtml);
        setcookie('__forword__',$_SERVER['REQUEST_URI']);
        $this->display('index.html');
    }

    public function editAction()
    {
        if (isset($_GET['id']))
        {
            $brandModel = new BrandModel();
            $row = $brandModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $brand = $_POST;
        $brandModel = new BrandModel();
        if(!empty($_FILES['logo']))
        {
            var_dump($GLOBALS['config']['Allow_types']);
            $uploadTool = new UploadTool($GLOBALS['config']['Allow_types']);
            $logoPath = $uploadTool->uploadOne($_FILES['logo'], 'brand');
            if(!$logoPath)
            {
                echo $uploadTool->errorInfo;
                return false;
            }
            $brand['logo'] = $logoPath;
        }
        if (empty($brand['id']))
        {
            $result = $brandModel->save($brand);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Brand&a=edit', $brandModel->errorInfo, 2);
            }
        } else
        {
            $result = $brandModel->update($brand);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Brand&a=edit&id='.$_POST['id'], $brandModel->errorInfo, 2);
            }
        }
        $this->redirect($_COOKIE['__forword__']);
    }

    public function removeAction()
    {
        $id = $_GET['id'];
        $brandModel = new BrandModel();
        $result = $brandModel->deleteByPK($id);
        if ($result)
        {
            $this->redirect($_COOKIE['__forword__']);
        }
    }

}
