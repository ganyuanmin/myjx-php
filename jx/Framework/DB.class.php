<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db
 *
 * @author admin
 */
class DB
{

    /**
     * 操作数据库,需要使用到相关的配置信息
     * host     主机
     * port     端口
     * username 用户名
     * password 密码
     * charset  字符节
     * database 数据库名
     */
    private $host;
    private $port;
    private $username;
    private $password;
    private $charset;
    private $dbname;
    private $link;
    private static $instance;

    /**
     * 
     * @param type $params 用于接受需要初始化的配置信息
     */
    private function __construct($params)
    {
        foreach ($params as $key => $values)
        {
            $this->$key = $values;
        }
        $this->conn();
    }

    private function __clone()
    {
        
    }

    public static function getInstance($params = array())
    {
        if (self::$instance instanceof self)
        {
            return self::$instance;
        }
        return self::$instance = new db($params);
    }

    public function query($sql)
    {
        if ($sql)
        {
            $result = mysql_query($sql);
            if ($result)
            {
                return $result;
            } else
            {
                echo 'sql语句:' . $sql . ',br />' . mysql_error();
                die();
            }
        }
        return false;
    }

    public function fetchAll($sql)
    {
        $result = mysql_query($sql);
        $rows = array();
        if ($result)
        {
            while ($row = mysql_fetch_assoc($result))
            {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function fetchRow($sql)
    {
        $result = mysql_query($sql);
        if ($result)
        {
            if ($row = mysql_fetch_assoc($result))
            {
                return $row;
            }
        }
        return false;
    }

    public function fetchColumn($sql)
    {
        $result = mysql_query($sql);
        if ($result)
        {

            if ($row = mysql_fetch_row($result))
            {
                return $row[0];
            }
        }
        return false;
    }

    private function conn()
    {
        $this->link = mysql_connect($this->host . ':' . $this->port, $this->username, $this->password);
        mysql_set_charset($this->charset);
        $rst = mysql_select_db($this->dbname);
    }

}
