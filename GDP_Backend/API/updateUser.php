<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 11/12/2015
 * Time: 10:49 AM
 */

require_once '../ConnectionManager.php';

$response = array();

$db = ConnectionManager::getInstance();
session_start();
$_SESSION["user"] = null;
if(!empty($_POST["ID"]) || !empty($_POST["Password"]))
{

    $id = $_POST["ID"];
    $pwd = $_POST["Password"];



    $result = mysql_query("UPDATE user SET Password = '$pwd' WHERE UserID = '$id'");



    if($result)
    {
        $response["success"] = 1;
        $response["message"] = "Password successfully Updated";
        echo json_encode($response);
    }
    else
    {
        $response["success"] = 0;
        $response["message"] = "Password did not Updated";
        echo json_encode($response);
    }
}
else
{
    $response["success"] = 0;
    $response["message"] = "Required field is missing";
    echo json_encode($response);
}
?>