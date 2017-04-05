<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 11/12/2015
 * Time: 10:49 AM
 */

require_once '../ConnectionManager.php';

$db = ConnectionManager::getInstance();

$response  = array();




if (!empty($_POST["facultyid"]) && !empty($_POST["facultyfirstName"]) && !empty($_POST["facultylastName"]) && !empty($_POST["facultydepartment"]))
{

$fid = $_POST["facultyid"];
$fname = $_POST["facultyfirstName"];
$lname = $_POST["facultylastName"];
$fdept = $_POST["facultydepartment"];

$result = mysql_query("insert into faculty(facultyId, firstName,lastName, department) VALUE ('$fid','$fname','$lname','$fdept')");


$insertUser = mysql_query("INSERT INTO user (UserID, Password, FirstName,  LastName, typeOfUser) VALUES
                                     ('$fid','$fid', '$fname ', '$lname', 'Faculty')");

if ($result)
{
$response["success"] = 1;
$response["message"] = "Successfully added faculty details";
echo json_encode($response);
}

else{
    $response["success"] = 0;
    $response["message"] = "Failed to add Faculty";
    echo json_encode($response);
}

}

else {
    $response["success"] = -1;
    $response["message"] = "Required fields are missing";
    echo json_encode($response);
}

?>