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

if (isset($_POST["CourseID"]) || isset($_POST["AssignmentType"])|| isset($_POST["TopicName"])|| isset($_POST["PresentationTime"])
    || isset($_POST["StudentList"])|| isset($_POST["SectionNumber"])) {

    $cid = $_POST["CourseID"];
    $assignmenttype = $_POST["AssignmentType"];
    $topicname = $_POST["TopicName"];
    $presentationtime = $_POST["PresentationTime"];
    $studentlist = $_POST["StudentList"];
    $sectionnumber = $_POST["SectionNumber"];


    if($assignmenttype == 'Group'){
        $teamName = $_POST["TeamName"];

        $isExist = mysql_query("select * from assignment WHERE AssignmentType = '$assignmenttype' AND TopicName = '$topicname'
          AND PresentationTime = '$presentationtime' AND StudentList = '$teamName' AND SectionNumber = '$sectionnumber'");

        $assignmentCount  = mysql_num_rows($isExist);
        if($assignmentCount == 0){
            $result = mysql_query("INSERT INTO assignment (CourseID, AssignmentType, TopicName, PresentationTime,SectionNumber,
          StudentList) VALUES ('$cid','$assignmenttype ', '$topicname', '$presentationtime', '$sectionnumber','$teamName')");

            $assignmentid =  mysql_insert_id();
            $arr = array();
            $arr = split(",",$studentlist);
            foreach($arr as $item){
                $result1 = mysql_query("INSERT INTO assignmentgroup (AssignmentID, studentID) VALUES ('$assignmentid','$item')");
            }
            if ($result && $result1) {
                $response["success"] = 1;
                $response["assignmentID"] = $assignmentid;
                $response["message"] = "Successfully Created New Assignment";
                echo json_encode($response);
            } else {
                $response["success"] = 0;
                $response["assignmentID"] = $assignmentid;
                $response["message"] = "Failed to Create New Assignment";
                echo json_encode($response);
            }
        }else{
            $response["success"] = 0;
            $response["message"] = "Presentation Already Exists";
            echo json_encode($response);
        }

    }
    else if($assignmenttype == 'Individual') {
        if (isset($cid) || isset($assignmenttype) || isset($topicname) || isset($presentationtime) || isset($studentlist) || isset($sectionnumber)) {
            $isExist = mysql_query("select * from assignment WHERE AssignmentType = '$assignmenttype' AND TopicName = '$topicname'
          AND PresentationTime = '$presentationtime' AND StudentList = '$studentlist' AND SectionNumber = '$sectionnumber'");

            $assignmentCount = mysql_num_rows($isExist);
            if ($assignmentCount == 0) {
                $result = mysql_query("INSERT INTO assignment (CourseID, AssignmentType, TopicName, PresentationTime,SectionNumber,
          StudentList) VALUES ('$cid','$assignmenttype ', '$topicname', '$presentationtime', '$sectionnumber','$studentlist')");

                $assignmentid = mysql_insert_id();


                if ($result) {
                    $response["success"] = 1;
                    $response["assignmentID"] = $assignmentid;
                    $response["message"] = "Successfully Created New Assignment";
                    echo json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["assignmentID"] = $assignmentid;
                    $response["message"] = "Failed to Create New Assignment";
                    echo json_encode($response);
                }
            } else {
                $response["success"] = 0;
                $response["message"] = "Presentation Already Exists";
                echo json_encode($response);
            }
        }
    }else{

        $isExist = mysql_query("select * from assignment WHERE AssignmentType = '$assignmenttype' AND TopicName = '$topicname'
          AND PresentationTime = '$presentationtime'  AND SectionNumber = '$sectionnumber'");

        $assignmentCount  = mysql_num_rows($isExist);
        if($assignmentCount == 0){
            $result = mysql_query("INSERT INTO assignment (CourseID, AssignmentType, TopicName, PresentationTime,SectionNumber,
          StudentList) VALUES ('$cid','$assignmenttype ', '$topicname', '$presentationtime', '$sectionnumber','$cid')");

            $assignmentid =  mysql_insert_id();

            $recordClass = mysql_query("Select * from student where CourseID = '$cid' AND SectionNumber = '$sectionnumber'");

            if (mysql_num_rows($recordClass) > 0) {
                while ($row = mysql_fetch_array($recordClass)) {

                    $stuId = $row["StudentID"];
                    $result1 = mysql_query("INSERT INTO assignmentgroup (AssignmentID, studentID) VALUES ('$assignmentid','$stuId')");

                }
                $response["success"] = 1;
                $response["message"] = "assignment found";

            }


            $arr = array();
            $arr = split(",",$studentlist);
            foreach($arr as $item){
                $result1 = mysql_query("INSERT INTO assignmentgroup (AssignmentID, studentID) VALUES ('$assignmentid','$item')");
            }
            if ($result && $result1) {
                $response["success"] = 1;
                $response["assignmentID"] = $assignmentid;
                $response["message"] = "Successfully Created New Assignment";
                echo json_encode($response);
            } else {
                $response["success"] = 0;
                $response["assignmentID"] = $assignmentid;
                $response["message"] = "Failed to Create New Assignment";
                echo json_encode($response);
            }
        }else{
            $response["success"] = 0;
            $response["message"] = "Presentation Already Exists";
            echo json_encode($response);
        }
    }
}

else {
    $response["success"] = 0;
    $response["message"] = "some fields are missing";
    echo json_encode($response);
}

?>