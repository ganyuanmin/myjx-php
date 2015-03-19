<?php
class SupplyController extends Controller
{
    public function indexAction()
    {
        $supplyModel = new SupplyModel();
        $rows = $supplyModel->getAll();
        $this->assign('rows',$rows);
        $this->display('index.html');
    }
    public function editAction()
    {
        if(isset($_GET['id']))
        {
            $supplyModel = new SupplyModel();
            $row = $supplyModel->getByPK($_GET['id']);
            $this->assign($row);
        }
        $this->display('edit.html');
    }
}
