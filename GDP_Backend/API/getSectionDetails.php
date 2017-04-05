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

if(!empty($_GET["courseId"]) && !empty($_GET["SectionNumber"])) {

    $id = $_GET["courseId"];

    $secNum = $_GET["SectionNumber"];


$result = mysql_query("SELECT * FROM course WHERE CourseID='$id' AND SectionNumber='$secNum'") or die(mysql_error());

if(mysql_num_rows($result)>0){
    $response['section'] = array();

    while($row = mysql_fetch_array($result))
    {
        $section = array();
        $section["CourseID"] = $row["CourseID"];
        $section["CourseName"] = $row["CourseName"];
        $section["SectionNumber"] = $row["SectionNumber"];
        $section["facultyname"] = $row["facultyname"];
        $section["starttime"] = $row["starttime"];
        $section["endtime"] = $row["endtime"];

        $result1 = mysql_query("SELECT * FROM student WHERE CourseID='$id' AND SectionNumber='$secNum'") or die(mysql_error());
        $section["students"] = array();
        while($r = mysql_fetch_array($result1)) {
            $students["StudentID"] = $r["StudentID"];
            $students["firstname"] = $r["firstname"];
            $students["lastname"] = $r["lastname"];
            $students["email"] = $r["email"];
            array_push($section["students"],$students);
        }
        array_push($response["section"],$section);
    }
    $response["success"] = 1;
    echo json_encode($response);
}
else {
    $response["success"] = 0;
    $response["message"] = "No section found";
    echo json_encode($response);
}
}else{
    $response["success"] = 0;
    $response["message"] = "No section found";
    echo json_encode($response);

}
?>