<?php

class BrandModel extends Model
{

    public function save($brand)
    {
        $name = trim($brand['name']);
        if (empty($name))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $count = $this->count("name={$brand['name']}");
        if ($count != 0)
        {
            $this->errorInfo = '用户名已存在';
            return false;
        }
        return $this->insertData($brand);
    }

    public function update($brand)
    {
        $name = trim($brand['name']);
        if (empty($name))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $count = $this->count("name={$brand['name']} and id<>{$brand['id']}");
        if ($count != 0)
        {
            $this->errorInfo = '用户名已存在';
            return false;
        }
        return $this->updateData($brand);
    }

}
