<?php

class AdminManagerModel extends Model
{
    public function save($adminManager)
    {
        if(empty($adminManager['username']))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $count = $this->count("username = {$adminManager['username']}");
        if($count>0)
        {
            $this->errorInfo = '用户名已经存在';
            return false;
        }
        $adminManager['password'] = md5($adminManager['password']);
        return $this->insertData($adminManager);
    }
    
    public function update($adminManager)
    {
        
        if (empty($adminManager['username']))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $count = $this->count("username = {$adminManager['username']}");
        if ($count > 0)
        {
            $this->errorInfo = '用户名已经存在';
            return false;
        }
        $adminManager['password'] = md5($adminManager['password']);
        return $this->updateData($adminManager);
    }
    
    public function checkLogin($user)
    {
        $sql = "select * from jx_adminmanager where username='{$user['username']}' and  password=md5('{$user['password']}')";
        return $this->db->fetchRow($sql);
    }
}
