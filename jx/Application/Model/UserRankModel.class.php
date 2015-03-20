<?php

class UserRankModel extends CheckModel
{
    public function save($userrank)
    {
        $result = $this->check($userrank['name']);
        if($result)
        {
            return $this->insertData($userrank);
        }
        return $result;
    }
    
    public function update($userrank)
    {
        $condition = "name = '{$userrank['name']}' and id<>{$userrank['id']}";
        $result = $this->check($userrank['name'],$condition);
        if ($result)
        {
            return $this->insertData($userrank);
        }
        return $result;
    }

}
