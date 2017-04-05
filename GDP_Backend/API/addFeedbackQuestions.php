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

$assignmentid = $obj->assignmentid;

foreach($obj->assignments as $val){
    $question = $val->question;
    $type = $val->type;
    $resp = $val->response;



    $resp = str_replace('@',',',$resp);
         $result = mysql_query("INSERT INTO feedbackquestions (AssignmentID, QuestionType, Question, Responses)
              VALUES ('$assignmentid','$type', '$question', '$resp')");
   if(!$result){
       $count = $count+1;
   }
}
if ($count==0) {
    $response["success"] = 1;
    $response["message"] = "Successfully Added Feedback Questions";
    echo json_encode($response);
} else {
    mysql_query("Delete from feedbackquestions WHERE AssignmentID = '$assignmentid'");
    $response["success"] = 0;
    $response["message"] = "Failed to Add Feedback questions";
    echo json_encode($response);
}

?>