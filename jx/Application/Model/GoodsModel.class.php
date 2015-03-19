<?php

class GoodsModel extends Model
{
    public function save($goods)
    {
        $name = trim($goods['name']);
        $goods_status = 0;
        $is_best = isset($goods['is_best'])?$goods['is_best']:0;
        $is_new = isset($goods['is_new'])?$goods['is_new']:0;
        $is_hot = isset($goods['is_hot'])?$goods['is_hot']:0;
        $goods_status = $goods_status | $is_best |$is_best |$is_hot;
        $goods['goods_status'] =$goods_status;
        if(empty($name))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $count = $this->count('name='.$name);
        if($count!=0)
        {
            $this->errorInfo = '商品已经存在';
            return false;
        }
        return $this->insertData($goods);
    }
    
    public function update($goods)
    {
        $name = trim($goods['name']);
        $goods_status = 0;
        $is_best = isset($goods['is_best'])?$goods['is_best']:0;
        $is_new = isset($goods['is_new'])?$goods['is_new']:0;
        $is_hot = isset($goods['is_hot'])?$goods['is_hot']:0;
        $goods_status = $goods_status | $is_best |$is_best |$is_hot;
        $goods['goods_status'] =$goods_status;
        if(empty($name))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $count = $this->count("name = $name and id<>{$goods['id']}");
        if($count!=0)
        {
            $this->errorInfo = '商品已经存在';
            return false;
        }
        return $this->updateData($goods);
    }
}
