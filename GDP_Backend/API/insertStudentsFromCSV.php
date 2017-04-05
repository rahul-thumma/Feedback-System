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
echo  implode("|",array_keys($_POST));
//Code added for insert studetns from CSV


$file = $_FILES['file-0']['tmp_name'];
//echo $file;
$handle = fopen($file, 'r');
while(($fileop = fgetcsv($handle,1000,",")) !== false) {
    $studentID = $fileop[0];
    $firstname = $fileop[1];
    $lastname = $fileop[2];
    $email = $fileop[3];
    echo $studentID . $firstname . $lastname . $email;

    if (isset($studentID) || isset($firstname) || isset($lastname) || isset($email)) {
        $result = mysql_query("INSERT INTO student (StudentID, firstname, lastname, email) VALUES
                            ('$studentID', '$firstname', '$lastname ', '$email')");
        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Successfully added student list";
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "Failed to add students list";
            echo json_encode($response);
        }

    } else {
        $response["success"] = 0;
        $response["message"] = "File is empty";
        echo json_encode($response);
    }
}
?>