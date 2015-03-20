<?php

class GoodsModel extends CheckModel
{

    public function save($goods)
    {
        $goods_status = 0;
        $is_best = isset($goods['is_best']) ? $goods['is_best'] : 0;
        $is_new = isset($goods['is_new']) ? $goods['is_new'] : 0;
        $is_hot = isset($goods['is_hot']) ? $goods['is_hot'] : 0;
        $goods_status = $goods_status | $is_best | $is_best | $is_hot;
        $goods['goods_status'] = $goods_status;
        $result = $this->check($goods['name']);
        if ($result)
        {
            return $this->insertData($goods);
        }
        return $result;
    }

    public function update($goods)
    {
        $goods_status = 0;
        $is_best = isset($goods['is_best']) ? $goods['is_best'] : 0;
        $is_new = isset($goods['is_new']) ? $goods['is_new'] : 0;
        $is_hot = isset($goods['is_hot']) ? $goods['is_hot'] : 0;
        $goods_status = $goods_status | $is_best | $is_best | $is_hot;
        $goods['goods_status'] = $goods_status;
        $result = $this->check($goods['name']);
        if ($result)
        {
            return $this->updateData($goods);
        }
        return $result;
    }

}
