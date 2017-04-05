<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 26/2/2016
 * Time: 10:49 PM
 */

require_once '../ConnectionManager.php';

$response = array();

$db = ConnectionManager::getInstance();

if(!empty($_POST["StudentID"] && $_POST["CourseID"] && $_POST["SectionNumber"])) {

    $sid = $_POST["StudentID"];
    $cid = $_POST["CourseID"];
    $sec = $_POST["SectionNumber"];

    $deleteStudent = mysql_query("DELETE FROM student WHERE StudentID='$sid' AND CourseID='$cid' AND SectionNumber='$sec'");
        if($deleteStudent){
            $response["success"] = 1;
            $response["message"] = "Successfully deleted student";
            echo json_encode($response);
        }else{
            $response["success"] = 1;
            $response["message"] = "Failed to deleted student";
            echo json_encode($response);
        }

}else{
    $response["success"] = 0;
    $response["message"] = "Please select student";
    echo json_encode($response);
}
?>