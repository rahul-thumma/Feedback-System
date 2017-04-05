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


$result = mysql_query("SELECT * FROM user WHERE UserID = '$id' AND Password = '$pwd'");

    if(!empty($result))
    {
        if (mysql_num_rows($result) == 1)

        {
            $_SESSION['username'] = $_POST['ID'];

             $row = mysql_fetch_array($result) ;
            $user = array();

            $user["UserID"] = $row["UserID"];
            $user["FirstName"] = $row["FirstName"];
            $user["LastName"] = $row["LastName"];
             $user["typeOfUser"] = $row["typeOfUser"];
            $user["isFirstTime"] = $row["isFirstTime"];
            $_SESSION['typeOfUser'] = $row['typeOfUser'];
            $_SESSION['FirstName'] = $row['FirstName'];
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