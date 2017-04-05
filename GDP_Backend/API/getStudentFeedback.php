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

if(isset($_GET["StudentID"])) {

    $sid = $_GET["StudentID"];

    $result = mysql_query("SELECT *  FROM studentfeedback WHERE PresentationName = '$sid'");

    if (mysql_num_rows($result) > 0) {
        $response['feedback'] = array();
        $feedback = array();
        while ($row = mysql_fetch_array($result)) {
            $feedback["PresentationName"] = $row["PresentationName"];
            $feedback["QuestionType"] = $row["QuestionType"];
            $feedback["Question"] = $row["Question"];
            $feedback["CourseID"] = $row["CourseID"];
            $feedback["TopicName"] = $row["TopicName"];
            $feedback["QuestionResponse"] = $row["QuestionResponse"];
            array_push($response["feedback"], $feedback);
        }
        $response["success"] = 1;
        echo json_encode($response);
    } else {
        $response["success"] = 0;
        $response["message"] = "No Feedback Response found";
        echo json_encode($response);
    }

}
else {
    $response["success"] = 0;
    $response["message"] = "No Student found";
    echo json_encode($response);
}
?>