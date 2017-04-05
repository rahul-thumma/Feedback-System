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

//$x =  file_get_contents("php://input");
//$count = 0;
//$obj = json_decode($x);
// echo $obj;
$addNewQuestion = true;
$updateQuestion = true;
$isNewItem = false;
$isDeleted = true;
$isUpdateItem = false;
//if(!empty($_POST["questionslist"]) && !empty($_POST["assignmentID"])) {


    $x = json_decode($_POST["questionslist"]);
    $assignmentID = $x -> assignmentID;
    // $questions = array();
    foreach($x->updatedQuestionsList as $val){
        $question = $val->Question;
        $resp = $val->Responses;
        $qType =$val->questionType;
        if(trim($qType)=="1"){
            $qType="SingleWord";
        }elseif(trim($qType)=="2"){
            $qType="rating";
        }elseif(trim($qType)=="3"){
            $qType="MultipleChoice";
        }else{
            $qType="SingleWord";
        }
       // array_push($questions,$sid);
        if(array_key_exists('isNew',$val)){
            $isNewItem = true;
            $result = mysql_query("INSERT INTO feedbackquestions(AssignmentID,Question,QuestionType,Responses)
                        VALUE ('$assignmentID','$question','$qType','$resp')");
            if(!$result){
                $addNewQuestion = false;
            }
        }
        else{
            $questonId = $val->QuestionID;
            $records = mysql_query("SELECT * FROM feedbackquestions where QuestionID='$questonId' AND Question='$question' AND
                                    QuestionType='$qType' AND Responses='$resp'");

            if(mysql_num_rows($records)==0){
                $isUpdateItem = true;
                $updateQuen = mysql_query("UPDATE feedbackquestions set Question='$question',QuestionType='$qType',Responses='$resp' WHERE QuestionID='$questonId'");
                if(!$updateQuen){
                    $updateQuestion = false;
                }

             }
        }
    }


    if($addNewQuestion  && $updateQuestion){
        $response["success"] = 1;
        $response["message"] = "Successfully Updated Feedback Question details";
        echo json_encode($response);
    }else{
        $response["success"] = 0;
        $response["message"] = "Failed to Update Feedback Question";
        echo json_encode($response);

    }
/*
}else{
    $response["success"] = 0;
    $response["message"] = "Failed to Update Feedback Question ssss";
    echo json_encode($response);
}*/
?>