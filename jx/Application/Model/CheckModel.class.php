<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CheckModel
 *
 * @author admin
 */
abstract class CheckModel extends Model
{

    protected function check($name, $condition = '')
    {
        if (empty($condition))
        {
            $condition = "name = '$name'";
        }
        $name = trim($name);
        if (empty($name))
        {
            $this->errorInfo = "用户名不能为空";
            return false;
        }
        $count = $this->count($condition);
        if ($count > 0)
        {
            $this->errorInfo = "用户名已存在";
            return false;
        }
        return true;
    }

}
