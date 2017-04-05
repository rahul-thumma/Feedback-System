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

if(!empty($_GET["courseId"]) && !empty($_GET["SectionNumber"])) {

    $cid = $_GET["courseId"];
    $sec = $_GET["SectionNumber"];
    $result = mysql_query("SELECT * FROM student WHERE CourseID='$cid' AND SectionNumber='$sec'") or die(mysql_error());

    if (mysql_num_rows($result) > 0) {
        $response['students'] = array();

        while ($row = mysql_fetch_array($result)) {
            $students = array();
            $students["StudentID"] = $row["StudentID"];
            $students["firstname"] = $row["firstname"];
            $students["lastname"] = $row["lastname"];
            $students["email"] = $row["email"];
            array_push($response["students"], $students);
        }
        $response["success"] = 1;
        echo json_encode($response);
    } else {
        $response["success"] = 0;
        $response["message"] = "No students found";
        echo json_encode($response);
    }
}else{
    $response["success"] = 0;
    $response["message"] = "No class is selected";
    echo json_encode($response);
}
?>