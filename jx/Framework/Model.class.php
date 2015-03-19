<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author admin
 */
abstract class Model
{

    protected $db;
    public $errorInfo;
    public $fields;
    public $tableName;

    public function __construct()
    {
        $this->initDB();
        $this->initFields();
    }

    public function initFields()
    {
        $sql = "desc {$this->table()}";
        $rows = $this->db->fetchAll($sql);
        foreach ($rows as $row)
        {
            if ($row['Key'] == 'PRI')
            {
                $this->fields['pk'] = $row['Field'];
            } else
            {

                $this->fields[] = $row['Field'];
            }
        }
    }

    public function initDB()
    {
        $this->db = DB::getInstance($GLOBALS['config']['DB']);
    }

    public function table()
    {
        $tablePrefix = $GLOBALS['config']['DB']['prefix'];
        if (empty($this->tableName))
        {
            $this->tableName = strtolower(strstr(get_class($this), 'Model', true));
        }
        return $tablePrefix . $this->tableName;
    }

    public function getAll($condition = '')
    {
        $sql = "select * from {$this->table()}";
        if (!empty($condition))
        {
            $sql .= ' where ' . $condition;
        }
        return $this->db->fetchAll($sql);
    }

    public function getPageResult($page, $pageSize, $condition = '')
    {
        if (empty($condition))
        {
            $condition = '1=1';
        }
        $count = $this->count($condition);
        $start = ($page - 1) * $pageSize;
        if ($start >= $count && $start > 0)
        {
            $start-=$pageSize;
        }
        $rows = $this->getAll("$condition limit " . $start . ',' . $pageSize);
        return array('rows' => $rows, 'count' => $count);
    }

    public function getByPK($pk, $condition = '')
    {
        $sql = "select * from {$this->table()} where {$this->fields['pk']}=$pk";
        if (!empty($condition))
        {
            $sql .= ' where ' . $condition;
        }
        return $this->db->fetchRow($sql);
    }

    public function insertData(&$data)
    {
        $this->ignoreFields($data);
        $sql = "insert into {$this->table()} (";
        if (key_exists($this->fields['pk'], $data))
        {
            unset($data[$this->fields['pk']]);
        }
        $keys = array_keys($data);
        $keys = array_map(function($key) {
            return '`' . $key . '`';
        }, $keys);
        $keys = implode(',', $keys);
        $sql .=$keys . ') values (';
        $values = array_values($data);
        $values = array_map(function($value) {
            return "'" . $value . "'";
        }, $values);
        $values = implode(',', $values);
        $sql .=$values . ')';
        return $this->db->query($sql);
    }

    private function ignoreFields(&$data)
    {
        $keys = array_keys($data);
        foreach ($keys as $key)
        {
            if (!in_array($key, $this->fields))
            {
                unset($data[$key]);
            }
        }
    }

    public function updateData(&$data, $condition = '')
    {
        $this->ignoreFields($data);
        $sql = "update {$this->table()} set ";
        foreach ($data as $key => $value)
        {
            if ($key != $this->fields['pk'])
            {
                $sql .= '`' . $key . "`='" . $value . "',";
            }
        }
        $sql = rtrim($sql, ',');
        if (!empty($condition))
        {
            $sql .= 'where ' . $condition;
        } else if (array_key_exists($this->fields['pk'], $data))
        {
            $sql .= "where {$this->fields['pk']} ={$data[$this->fields['pk']]}";
        } else
        {
            return false;
        }
        return $this->db->query($sql);
    }

    public function deleteByPK($pk)
    {
        $sql = "delete from {$this->table()} where {$this->fields['pk']}=$pk";
        return $this->db->query($sql);
    }

    public function count($condition = '')
    {
        $sql = "select count(*) as count from {$this->table()}";
        if (!empty($condition))
        {
            $sql .= ' where ' . $condition;
        }
        return $this->db->fetchColumn($sql);
    }

    public function get_insert_id()
    {
        return mysql_insert_id();
    }

}
