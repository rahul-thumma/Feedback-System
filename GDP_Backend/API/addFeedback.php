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

$x =  file_get_contents("php://input");

$count = 0;
$obj = json_decode($x);

$response = array();

$assignmentId = $obj->assignmentId;
$studentID = $obj->studentID;
/*$topicName = $obj->topicName;
$courseID = $obj->courseId;
$presentationType = $obj->presentationType;*/
$comments = $obj->comments;
    $assignmentDetails = mysql_query("select * from assignment WHERE AssignmentID='$assignmentId'");
        if(mysql_num_rows($assignmentDetails)>0){
            $row = mysql_fetch_array($assignmentDetails);
            $courseID = $row["CourseID"];
            $presentationType = trim($row["AssignmentType"]);
            $topicName = $row["TopicName"];
            $sectionNum = $row["SectionNumber"];

            if(trim($presentationType)=="Individual"){
                $presenterName = $row["StudentList"];
foreach($obj->assignments as $val){
    $presentationName = $val->PresentationName;
    $questionType = $val->QuestionType;
    $question = $val->Question;
    $questionResponse = $val->QuestionResponse;
    $question = strtr ($question, array ("@@!!@@" => " "));

    $result = mysql_query("INSERT INTO studentfeedback (StudentID, CourseID,PresentationName, QuestionType, Question,QuestionResponse,TopicName)
                               VALUES ('$studentID','$courseID','$presenterName ', '$questionType', '$question','$questionResponse','$topicName')");

                     if(!$result){
                         $count = $count+1;
                     }
                }
            }else{

                $temp = mysql_query("select * from assignmentgroup WHERE AssignmentID='$assignmentId'");

                while($row = mysql_fetch_array($temp)) {
                    $student =  trim($row["studentID"]);

                    if($student!="class") {
                        //   foreach ($row["studentID"] as $student) {
                        foreach ($obj->assignments as $val) {
                           // $presentationName = $val->PresentationName;
                            $questionType = $val->QuestionType;
                            $question = $val->Question;
                            $questionResponse = $val->QuestionResponse;
                            $question = strtr($question, array("@@!!@@" => " "));


                            $result = mysql_query("INSERT INTO studentfeedback (StudentID, CourseID,PresentationName, QuestionType, Question,QuestionResponse,TopicName)
                               VALUES ('$studentID','$courseID','$student ', '$questionType', '$question','$questionResponse','$topicName')");
                            if (!$result) {
                                $count = $count + 1;
                            }

                        }
                        //   }
                    }
                }
            }
    }


if ($count==0) {
    $response["success"] = 1;
    $response["message"] = "Feedback is successfully submitted";
    echo json_encode($response);
} else {
   // mysql_query("Delete from feedbackquestions WHERE AssignmentID = '$studentID'");
    $response["success"] = 0;
    $response["message"] = "Failed to submit feedback.";
    $response["Result"] = $result;
    echo json_encode($response);
}

?>