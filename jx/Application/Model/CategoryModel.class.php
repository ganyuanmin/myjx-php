<?php

class CategoryModel extends CheckModel
{

    public function getList()
    {
        $rows = $this->getAll();
        return $this->getTree($rows);
    }

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

    public function delete($id)
    {
        $count = $this->count('parent_id=' . $id);
        if ($count > 0)
        {
            $this->errorInfo = '不能删除有子元素的节点';
            return false;
        }
        return $this->deleteByPK($id);
    }

    public function save($category)
    {
        $rows = $this->getAll();
        $name = trim($category['name']);
        $result = $this->check($category['name']);
        if ($result)
        {
            return $this->insertData($category);
        }
        return $result;
    }

    public function update($category)
    {
        $rows = $this->getAll();
        $name = trim($category['name']);
        if (empty($name))
        {
            $this->errorInfo = '用户名不能为空';
            return false;
        }
        $rows = $this->getTree($category['id']);
        $ids = array_map(function($row) {
            return $row['id'];
        }, $rows);
        $ids[] = $category['id'];
        if (in_array($category['parent_id'], $ids))
        {
            $this->errorInfo = "不能更新到自己或者自己的子节点下";
            return false;
        }
        $parents = $this->getTree($rows, $category['parent_id']);
        foreach ($parents as $parent)
        {
            if ($parent['name'] == $category['name'] && $category['id'] != $parent['id'])
            {
                $this->errorInfo = "商品名已存在";
                return false;
            }
        }
        return $this->updateData($category);
    }

}
