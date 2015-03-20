<?php

class ArticleModel extends CheckModel
{

    public function save($article)
    {
        $result = $this->check($article['name']);
        if ($result)
        {
            return $this->insertData($article);
        }
        return $result;
    }

    public function update($article)
    {
        $condition = "name = '{$article['name']}' and id<>'{$article['id']}'";
        $result = $this->check($article['name'],$condition);
        if ($result)
        {
            return $this->insertData($article);
        }
        return $result;
    }

}
