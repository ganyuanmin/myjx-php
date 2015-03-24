<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 *登录/注册
 */
class UserController extends Controller{
    //登陆
    public function loginAction(){
        //1.接收数据（username,password）
        //2.比较验证码是否匹配
//        var_dump($_POST['captcha']);
        new SessionDBTool();//页面每重新载入一次session就要开启一次
//        var_dump($_SESSION);
//        exit(); 
        if(!CaptchaTool::check($_POST['captcha'])){
             
             $this->redirect('index.php?p=Home&c=Home&a=login','验证码错误',3);
         }
    
        //3.调用model从数据库查找
        $user_login=new UserModel();
      
        $result=$user_login->select($_POST);
        //4.是否存在此用户名&&比较提交的密码和数据库查询到的密码,如果都满足,调用登陆成功页面
        if($result){
            new SessionDBTool();
            $_SESSION['username']=$_POST['username'];
            $this->redirect('index.php?p=Home&c=Home&a=index');
//            $this->display('index.html');
        }
        //5.否则返回登录页面并显示错误信息
       $this->redirect('index.php?p=Home&c=Home&a=login',$user_login->error_info,3);
        
    }
    public function registAction(){
        //1.接受数据(username,password1,password2)
        //2.比较验证码是否匹配
        new SessionDBTool();
        if(!CaptchaTool::check($_POST['captcha'])){
            $this->redirect('index.php?p=Home&c=Home&a=regist','验证码错误',3);
        }
        //3.比较两次密码输入是否相同
        if($_POST['password1']!==$_POST['password2']){
             $this->redirect('index.php?p=Home&c=Home&a=regist','密码验证失败',3);
        }
        //4.向model发送数据,验证username是否存在,如果不存在添加进数据库
            $user_regist=new UserModel();
            $result=$user_regist->insert($_POST);
            if($result){
               
                new SessionDBTool();
                $_SESSION['username']=$_POST['username'];
//                $this->display('index.html');
                $this->redirect('index.php?p=Home&c=Home&a=index');
            }else{
                $this->redirect('index.php?p=Home&c=Home&a=regist',$user_regist->error_info,3);
            }
        }
}