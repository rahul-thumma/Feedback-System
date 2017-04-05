<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 3/6/2016
 * Time: 9:42 PM
 */

require_once '../ConnectionManager.php';
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.html');
}
$userId = $_SESSION['username'];
$response = array();
$studentList = "";
$db = ConnectionManager::getInstance();
// echo "i am in getallstu";
$result = mysql_query("SELECT * FROM student,assignment where student.CourseID=assignment.CourseID and student.SectionNumber=assignment.SectionNumber and student.StudentID = '$userId'") or die(mysql_error());

if(mysql_num_rows($result)>0){
    $response['assignments'] = array();

    while($row = mysql_fetch_array($result))
    {
        $assignmentid = $row["AssignmentID"];
        $assignment = array();
        $assignment["AssignmentID"] = $row["AssignmentID"];
        $assignment["CourseID"] = $row["CourseID"];
        $type = $row["AssignmentType"];
        $assignment["AssignmentType"] = $type;
        $assignment["TopicName"] = $row["TopicName"];
        $assignment["SectionNumber"] = $row["SectionNumber"];
        $assignment["PresentationTime"] = $row["PresentationTime"];
       if(trim($type)== "Individual"){
           $assignment["StudentList"] = $row["StudentList"];
       }else{
        $students = mysql_query("Select * from assignmentgroup WHERE AssignmentID='$assignmentid'");
           $count = 0;
           while($record = mysql_fetch_array($students)){
               if($count==0){
                   $studentList = $record["studentID"];
                   $count++;
               }
               $studentList = $studentList.",".$record["studentID"];
           }
           $assignment["StudentList"] = $studentList;
           $assignment["TeamName"] = $row["StudentList"];
       }

        array_push($response["assignments"],$assignment);
    }
    $response["success"] = 1;
    echo json_encode($response);
}
else {
    $response["success"] = 0;
    $response["message"] = "No Presentation found";
    echo json_encode($response);
}


?>