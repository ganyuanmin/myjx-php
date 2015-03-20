<?php

class ArticleCatModel extends CheckModel
{

    public function getTree($rows, $parent_id = 0, $deep = 0)
    {
        static $tree;
        foreach ($rows as $row)
        {
            if ($row['parent_id'] == $parent_id)
            {
                $row['textName'] = str_repeat('&nbsp', $deep * 5) . $row['name'] . '<br />';
                $tree[] = $row;
                $this->getTree($rows, $row['id'], $deep + 1);
            }
        }
        return $tree;
    }

    public function getList($parent_id = 0)
    {
        $rows = $this->getAll();
        return $this->getTree($rows, $parent_id);
    }

    public function delete($id)
    {
        $condition = "parent_id = $id";
        $count = $this->count($condition);
        if ($count > 0)
        {
            $this->errorInfo = "不能删除有子元素的分类";
            return false;
        }
        return $this->deleteByPK($id);
    }

    public function save($articleCat)
    {
        $result = $this->check($articleCat['name']);
        if ($result)
        {
            return $this->insertData($articleCat);
        }
        return $result;
    }

    public function update($articleCat)
    {
        $condition = "name='{$articleCat['name']}' and id<>{$articleCat['id']}";
        $result = $this->check($articleCat['name'],$condition);
        if ($result)
        {
            return $this->updateData($articleCat);
        }
        return $result;
    }

}
