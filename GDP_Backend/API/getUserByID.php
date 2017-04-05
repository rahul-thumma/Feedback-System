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
if(!empty($_POST["ID"]))
{

    $id = $_POST["ID"];

    $result = mysql_query("SELECT * FROM user WHERE UserID = '$id'");

    if(!empty($result))
    {
        if (mysql_num_rows($result) == 1)

        {
            $user = array();
            $row = mysql_fetch_array($result) ;

            $result1 = mysql_query("SELECT * FROM student WHERE StudentID = '$id'");
            $row1 = mysql_fetch_array($result1) ;
            $user["Email"] = $row1["email"];



            $user["UserID"] = $row["UserID"];
            $user["Password"] = $row["Password"];
            $user["FirstName"] = $row["FirstName"];
            $user["LastName"] = $row["LastName"];
            $user["typeOfUser"] = $row["typeOfUser"];
            $response["success"] = 1;
            $response["user"] = array();
            array_push($response["user"], $user);
            echo json_encode($response);
        }

        else {
            $response["success"] = 0;
            $response["message"] = "No user found";
            echo json_encode($response);
        }
    }
    else
    {
        $response["success"] = 0;
        $response["message"] = "No user found1";
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