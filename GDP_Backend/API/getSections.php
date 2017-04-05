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




if(!empty($_POST["CourseID"])) {
    $cid = $_POST["CourseID"];
    /* $cid = "8";*/
    $result = mysql_query("SELECT SectionNumber FROM course WHERE CourseID = '$cid'");

    if (mysql_num_rows($result) > 0) {
        $response['section'] = array();
        $section = array();
        while ($row = mysql_fetch_array($result)) {
            $section["SectionNumber"] = $row["SectionNumber"];

            array_push($response["section"], $section);
        }
        $response["success"] = 1;
        echo json_encode($response);
    } else {
        $response["success"] = 0;
        $response["message"] = "No Student found";
        echo json_encode($response);
    }
}
?>