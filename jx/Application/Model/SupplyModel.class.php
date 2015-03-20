<?php

class SupplyModel extends CheckModel
{

    public function save($supply)
    {
        $result = $this->check($supply['name']);
        if ($result)
        {
            return $this->insertData($supply);
        }
        return $result;
    }

    public function update($supply)
    {
        $result = $this->check($supply['name']);
        if ($result)
        {
            return $this->updateData($supply);
        }
        return $result;
    }

}
