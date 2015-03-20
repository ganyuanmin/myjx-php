<?php

class BrandModel extends CheckModel
{

    public function save($brand)
    {
        $result = $this->check($brand['name']);
        if ($result)
        {
            return $this->insertData($brand);
        }
        return $result;
    }

    public function update($brand)
    {
        $condition = "name={$brand['name']} and id<>{$brand['id']}";
        $result = $this->check($brand['name'],$condition);
        if ($result)
        {
            return $this->updateData($brand);
        }
        return $result;
    }

}
