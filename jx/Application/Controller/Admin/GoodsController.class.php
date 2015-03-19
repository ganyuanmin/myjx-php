<?php

class GoodsController extends Controller
{

    public function indexAction()
    {
        $condition = '1=1';
        $conditionArr = array();
        if (isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != -1)
        {
            $conditionArr[] = ' and category_id = ' . $_REQUEST['category_id'];
        }
        if (isset($_REQUEST['brand_id']) && $_REQUEST['brand_id'] != -1)
        {
            $conditionArr[] .= ' and  brand_id = ' . $_REQUEST['brand_id'];
        }
        if (isset($_REQUEST['goods_status']) && $_REQUEST['goods_status'] != -1)
        {
            $conditionArr[] = " and goods_status&{$_REQUEST['goods_status']}={$_REQUEST['goods_status']}";
        }
        if (isset($_REQUEST['is_on_sale']) && $_REQUEST['is_on_sale'] != -1)
        {
            $conditionArr[] = ' and is_on_sale = ' . $_REQUEST['is_on_sale'];
        }
        if (!empty($_REQUEST['keyword']))
        {
            $conditionArr[] = " and name like '%{$_REQUEST['keyword']}%' ";
        }
        if (!empty($conditionArr))
        {
            $condition.= implode('', $conditionArr);
        }
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : $GLOBALS['config']['Admin']['pageSize'];
        $goodsModel = new GoodsModel();
        $pageResult = $goodsModel->getPageResult($page, $pageSize, $condition);
        $pageHtml = PageTool::show('index.php?p=Admin&c=Goods&a=index', $pageResult['count'], $page, $pageSize, $conditionArr);
        $this->assign('rows', $pageResult['rows']);
        $this->assign('pageHtml', $pageHtml);
        $categoryModel = new CategoryModel();
        $categorys = $categoryModel->getList();
        $this->assign('categorys', $categorys);
        $brandModel = new BrandModel();
        $brands = $brandModel->getAll();
        $this->assign('brands', $brands);
        setcookie('__forword__', $_SERVER['REQUEST_URI']);
        $this->display('index.html');
    }

    public function editAction()
    {
        $categoryModel = new CategoryModel();
        $categorys = $categoryModel->getList();
        $this->assign('categorys', $categorys);
        $brandModel = new BrandModel();
        $brands = $brandModel->getAll();
        $this->assign('brands', $brands);
        $goodsModel = new GoodsModel();
        if (isset($_GET['id']))
        {
            $good = $goodsModel->getByPK($_GET['id']);
            $this->assign($good);
        }
        $this->display('edit.html');
    }

    public function saveAction()
    {
        $goods = $_POST;
        $goodsModel = new GoodsModel();
        if ($_FILES['image_ori']['error'] == 0)
        {
            $uploadTool = new UploadTool();
            $image_ori = $uploadTool->uploadOne($_FILES['image_ori'], 'goods');
            $imageTool = new ImageTool();
            $image_thumb = $imageTool->thomb($image_ori, 130, 130);
            $goods['image_ori'] = $image_ori;
            $goods['image_thumb'] = $image_thumb;
        }
        if (empty($_POST['id']))
        {
            $result = $goodsModel->save($goods);
            if ($result == false)
            {
                $this->redirect('index.php?p=Admin&c=Goods&a=edit', $goodsModel->errorInfo, 2);
            }
        } else
        {
            $result = $goodsModel->update($goods);
            if ($result == false)
            {
                $this->redirect('index.php?p=Admin&c=Goods&a=edit&id=' . $goods['id'], $goodsModel->errorInfo, 2);
            }
        }
        $this->redirect($_COOKIE['__forword__']);
    }

    public function removeAction()
    {
        $id = $_GET['id'];
        $goodsModel = new GoodsModel();
        $goodsModel->deleteByPK($id);
        $this->redirect($_COOKIE['__forword__']);
    }

}
