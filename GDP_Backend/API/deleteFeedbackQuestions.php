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

if(!empty($_POST["id"])) {

    $id = $_POST["id"];

     $deletequestion = mysql_query("DELETE FROM feedbackquestions WHERE QuestionID='$id'");
    if($deletequestion){
        $response["success"] = 1;
        $response["message"] = "Successfully deleted question";
        echo json_encode($response);
    }else{
        $response["success"] = 1;
        $response["message"] = "Failed to delete question";
        echo json_encode($response);
    }

}else{
    $response["success"] = 0;
    $response["message"] = "Please select question";
    echo json_encode($response);
}
?>