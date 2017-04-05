<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 11/12/2015
 * Time: 11:13 AM
 */
class Connection
{

    function __construct()
    {
        $this->connect();
    }

    function __destruct()
    {
        $this->close();
    }

    function connect()
    {
        require_once __DIR__.'/db_config.php';

        $connection = mysql_connect(SERVER, USER, PASSWORD) or die(mysql_error());

        $dbconnect = mysql_select_db(DATABASE) or die(mysql_error()) or die(mysql_error());

        return $connection;
    }

    function  close()
    {
        mysql_close();
    }
}