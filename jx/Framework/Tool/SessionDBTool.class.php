<?php

class SessionDBTool
{

    private $database;

    public function __construct()
    {
        session_set_save_handler(
            array($this, 'open'), 
            array($this, 'close'), 
            array($this, 'read'), 
            array($this, 'write'),
            array($this, 'destory'), 
            array($this, 'gc'));
        @session_start();
    }

    public function open($savePath, $sessionName)
    {
        $this->database = DB::getInstance($GLOBALS['config']['DB']);
    }

    public function close()
    {
        
    }

    public function read($sessionId)
    {
        $sql = "select sess_data from session where sess_id = '$sessionId'";
        $row = $this->database->fetchColumn($sql);
        if (!$row)
        {
            return '';
        }
        return $row;
    }

    public function write($sessionId, $data)
    {
        $sql = "insert into session values('$sessionId','$data',unix_timestamp()) on duplicate key "
            . "update sess_data='$data',last_modify=unix_timestamp()";
        $this->database->query($sql);
    }

    public function destory($sessionId)
    {
        $sql = "delete from session where sess_id=$sessionId";
        return $this->database->query($sql);
    }

    public function gc($lifeTime)
    {
        $sql = "delete from session where last_modify+$lifeTime < unix_timestamp()";
        return $this->database->query($sql);
    }

}
