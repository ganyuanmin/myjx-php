<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class HomeController extends Controller{
    //主页
    public function indexAction(){
         //1.调用brandmodel,获取数据库信息
        $brand=new BrandModel();
        $brands=$brand->selectlist();
        //2.分配brand数据
        $this->assign('brands', $brands);
        //3.调用goodsmodel,获取数据库信息
//        $good=new GoodsModel();
//        $goods=$good->selectlist();
        //4.分配goods数据
//        $this->assign('goods', $goods);
        //5.调用视图
        $this->display('index.html');
    }
    //登录页
    public function loginAction(){
        $this->display('login.html');
    }
    //注册页
    public function registAction(){
        $this->display('regist.html');
    }
    public function shopAction(){
        $this->display('shop.html');
    }
}

