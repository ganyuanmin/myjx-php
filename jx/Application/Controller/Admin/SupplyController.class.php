<?php

class SupplyController extends Controller
{

    public function indexAction()
    {
        $supplyModel = new SupplyModel();
        $rows = $supplyModel->getAll();
        $this->assign('rows', $rows);
        $this->display('index.html');
    }

    public function editAction()
    {
        if (isset($_GET['id']))
        {
            $supplyModel = new SupplyModel();
            $row = $supplyModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $supplyModel = new SupplyModel();
        if (empty($_POST['id']))
        {
            $result = $supplyModel->save($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Supply&a=edit',$supplyModel->errorInfo,2);
            }
        } else
        {
            $result = $supplyModel->update($_POST);
            if ($result === false)
            {
                $this->redirect('index.php?p=Admin&c=Supply&a=edit&id='.$_POST['id'],$supplyModel->errorInfo,2);
            }
        }
        $this->redirect('index.php?p=Admin&c=Supply&a=index');
    }
    
    public function removeAction()
    {
        $id = $_GET['id'];
        $supplyModel = new SupplyModel();
        $supplyModel->deleteByPK($id);
        $this->redirect('index.php?p=Admin&c=Supply&a=index');
    }
}
