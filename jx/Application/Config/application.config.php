<?php

return array(
    'DB' => array(
        'host' => 'localhost',
        'port' => '3306',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf-8',
        'dbname' => 'jx',
        'prefix' => 'jx_',
    ),
    'App' => array(
        'default_controller' => 'Index',
        'default_action' =>'index',
        'default_platform' =>'Admin',
    ),
    'Allow_types'=>array(
        'image/jpeg','image/gif','image/png','image/jpg'
    ),
    'Admin' =>array(
        'pageSize' =>2,
    ),
);

