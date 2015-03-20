<?php

class AdminManagerModel extends CheckModel
{

    public function save($adminManager)
    {
        $condition = "username='{$adminManager['username']}'";
        $result = $this->check($adminManager['username'], $condition);
        if ($result)
        {
            return $this->insertData($adminManager);
        }
        return $result;
    }

    public function update($adminManager)
    {

        $adminManager['password'] = md5($adminManager['password']);
        $condition = "username='{$adminManager['username']}' and password = '{$adminManager['password']}'";
        $result = $this->check($adminManager['username'],$condition);
        if ($result)
        {
            return $this->updateData($adminManager);
        }
        return $result;
    }

    public function checkLogin($user)
    {
        $sql = "select * from jx_admin_manager where username='{$user['username']}' and  password=md5('{$user['password']}')";
        return $this->db->fetchRow($sql);
    }

}
