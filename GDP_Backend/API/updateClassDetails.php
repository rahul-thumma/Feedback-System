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

if(!empty($_POST["CourseID"]) && !empty($_POST["FacultyName"]) && !empty($_POST["SectionNumber"]) && !empty($_POST["SectionNumber"])
    && !empty($_POST["CourseName"]) && !empty($_POST["StartTime"]) && !empty($_POST["EndTime"])) {

    $cid = $_POST["CourseID"];
    $fname = $_POST["FacultyName"];
    $sec = $_POST["SectionNumber"];
    $stime = $_POST["StartTime"];
    $etime = $_POST["EndTime"];
    $cname = $_POST["CourseName"];

    $updateClass = mysql_query("update course set facultyname='$fname',starttime='$stime',endtime='$etime'
                    WHERE CourseID='$cid' AND SectionNumber='$sec'");
    if($updateClass){
        $response["success"] = 1;
        $response["message"] = "Successfully updated class details";
        echo json_encode($response);
    }else{
        $response["success"] = 1;
        $response["message"] = "Failed to updated class details";
        echo json_encode($response);
    }

}else{
    $response["success"] = 0;
    $response["message"] = "Failed to updated class details";
    echo json_encode($response);
}
?>