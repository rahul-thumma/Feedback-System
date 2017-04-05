<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 12/05/2015
 * Time: 4:49 AM
 */

require_once '../ConnectionManager.php';

$response = array();
$db = ConnectionManager::getInstance();

if (isset($_POST["ID"]) || isset($_POST["pwd"])) {

    $sid = $_POST["ID"];
    $pwd = $_POST["pwd"];

    $result = mysql_query("UPDATE user SET Password = '$pwd', isFirstTime = FALSE where UserID='$sid'");

        if ($result) {

            $result1 = mysql_query("SELECT * FROM user WHERE UserID = '$sid'");
            $row = mysql_fetch_array($result1);
            $response["typeOfUser"] = $row["typeOfUser"];
            $response["success"] = 1;
            $response["message"] = "Successfully updated User password";
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "Failed to update User password";
            echo json_encode($response);
        }

}

else {
    $response["success"] = 0;
    $response["message"] = "some fields are missing";
    echo json_encode($response);
}

?>