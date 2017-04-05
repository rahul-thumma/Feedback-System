<?php

/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 11/12/2015
 * Time: 11:19 AM
 */

require_once 'Connection.php';
class ConnectionManager
{

    static $connection = null;

    public  static  function  getInstance()
    {
        if(ConnectionManager::$connection == null)
            ConnectionManager::$connection = new Connection();
        return ConnectionManager::$connection;
    }

    private function __construct()
    {

    }
    private function __clone()
    {

    }
}