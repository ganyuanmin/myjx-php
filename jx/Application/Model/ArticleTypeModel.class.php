<?php

class ArticleTypeModel extends CheckModel
{

    public function save($articleType)
    {
        $result = $this->check($articleType['name']);
        if ($result)
        {
            return $this->insertData($articleType);
        }
        return $result;
    }

    public function update($articleType)
    {
        $condition = "name = '{$articleType['name']}' and id<>{$articleType['id']}";
        $result = $this->check($articleType['name'],$condition);
        if ($result)
        {
            return $this->updateData($articleType);
        }
        return $result;
    }

}
