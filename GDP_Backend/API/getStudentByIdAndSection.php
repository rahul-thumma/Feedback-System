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

if(isset($_GET["CourseID"]) && isset($_GET["SectionNumber"])) {

    $cid = $_GET["CourseID"];
    $secNum = $_GET["SectionNumber"];


    $result = mysql_query("SELECT *  FROM student WHERE CourseID = '$cid' AND SectionNumber = '$secNum'");

   if(mysql_num_rows($result) > 0){
       $response['student'] = array();
       while($row = mysql_fetch_array($result)){
           $student = array();
           $student["ID"] = $row["StudentID"];
           $student["FirstName"] = $row["firstname"];
           $student["LastName"] = $row["lastname"];
            array_push($response['student'],$student);
       }
       $response["success"] = 1;
       echo json_encode($response);
   }
}
else {
    $response["success"] = 0;
    $response["message"] = "No Student found";
    echo json_encode($response);
}
?>