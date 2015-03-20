<?php

class UserModel extends CheckModel
{

    public function save($user)
    {
        $result = $this->check($user['name']);
        if($result)
        {
            return $this->insertData($user);
        }
        return $result;
    }

    public function update($user)
    {
        $result = $this->check($user['name']);
        if($result)
        {
            return $this->updateData($user);
        }
        return $result;
    }

}
