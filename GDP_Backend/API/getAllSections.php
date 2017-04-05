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
// echo "i am in getallstu";
$result = mysql_query("SELECT * FROM course") or die(mysql_error());

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
?>