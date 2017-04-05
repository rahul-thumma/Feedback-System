<?php
/**
 * Created by PhpStorm.
 * User: s522626
 * Date: 3/1/2016
 * Time: 4:04 PM
 */


require_once '../ConnectionManager.php';

$response = array();

$db = ConnectionManager::getInstance();

if(!empty($_GET["id"])){

    $id = $_GET["id"];
    $assginmentRecord = mysql_query("Select * from assignment WHERE AssignmentID='$id'");

    $response["assignemt"]=array();

        $row = mysql_fetch_array($assginmentRecord);

        $assignment["id"]=$id;
        $assignment["CourseID"]=$row["CourseID"];
        $assignment["AssignmentType"]=$row["AssignmentType"];
        $assignment["TopicName"]=$row["TopicName"];
        $assignment["SectionNumber"]=$row["SectionNumber"];
        $assignment["PresentationTime"]=$row["PresentationTime"];
        $assignment["StudentList"] = array();
        if($row["AssignmentType"]!="Individual "){

            $presenterRecords = mysql_query("Select * from assignmentgroup WHERE AssignmentID='$id'");

            while($students = mysql_fetch_array($presenterRecords)){
                $sid = $students["studentID"];
                $stuDetails = mysql_query("Select * from student where StudentID='$sid'");
                $student = mysql_fetch_array($stuDetails);

                $StudentList['firstname'] = $student["firstname"];
                $StudentList['lastname'] = $student["lastname"];
                $StudentList['email'] = $student["email"];
                $StudentList["studentID"] = $students["studentID"];
                array_push($assignment["StudentList"],$StudentList);
            }

        }else{
            $assignment["StudentList"]=$row["StudentList"];
        }
        array_push($response["assignemt"],$assignment);
    $questionsRecord = mysql_query("select * from feedbackquestions WHERE AssignmentID='$id'");
    $response["feedbackquestions"]=array();
    while($question = mysql_fetch_array($questionsRecord)){

        $feedbackquestions["QuestionID"]=$question["QuestionID"];
        $feedbackquestions["QuestionType"]=$question["QuestionType"];
        $feedbackquestions["Question"]=$question["Question"];
        $feedbackquestions["Responses"]=$question["Responses"];

        array_push($response["feedbackquestions"],$feedbackquestions);
    }

    echo json_encode($response);
}

?>