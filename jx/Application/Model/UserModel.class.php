<?php

class UserModel extends Model
{

    public function save($user)
    {
        $name = $user['name'];
        if (empty($name))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $count = $this->count("name = $name");
        if ($count > 0)
        {
            $this->errorInfo = '用户名已存在';
            return false;
        }
        return $this->insertData($user);
    }

    public function update($user)
    {
        $name = $user['name'];
        if (empty($name))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $count = $this->count("name = $name");
        if ($count > 0)
        {
            $this->errorInfo = '用户名已存在';
            return false;
        }
        return $this->updateData($user);
    }

}
