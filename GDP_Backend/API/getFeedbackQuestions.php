<?php
/**
 * Created by PhpStorm.
 * User: S522623
 * Date: 11/21/2015
 * Time: 6:04 PM
 */
require_once '../ConnectionManager.php';

$response = array();

$db = ConnectionManager::getInstance();
$x =  file_get_contents("php://input");
$obj = json_decode($x);
$assignmentid = $obj->assignmentId;

if($assignmentid!=""){


   // $assignmentid = "19";
    $result = mysql_query("SELECT * FROM feedbackquestions WHERE AssignmentID='$assignmentid'") or die(mysql_error());


if(mysql_num_rows($result)>0){
    $response['question'] = array();

    while($row = mysql_fetch_array($result))
    {
        $feebackquestion = array();
        $feebackquestion["QuestionID"] = $row["QuestionID"];
        $feebackquestion["AssignmentID"] = $row["AssignmentID"];
        $feebackquestion["QuestionType"] = $row["QuestionType"];
        $feebackquestion["Question"] = $row["Question"];
        $feebackquestion["Responses"] = $row["Responses"];

        array_push($response["question"],$feebackquestion);
    }
    $response["success"] = 1;
    echo json_encode($response);
}
else {
    $response["success"] = 0;
    $response["message"] = "No Feedback Quesions found";
    echo json_encode($response);
}
}
else {
    $response["success"] = 0;
    $response["message"] = "All fields need to select";
    echo json_encode($response);
}
?>