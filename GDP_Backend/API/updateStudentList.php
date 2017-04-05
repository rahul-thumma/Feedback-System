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
$addNewStudent = true;
$updateStudent = true;
$addNewUser = true;
$updateUser = true;
$isNewItem = false;
$isDeleted = true;
$isUpdateItem = false;
if(!empty($_POST["studentlist"])) {

    $x = json_decode($_POST["studentlist"]);
    $cid = $x->courseId;
    $sec = $x->sectionNum;
    $students = array();
    foreach($x->updatedStudentList as $val){
        $sid = $val->id;
        $fname = $val->firstname;
        $lname =$val->lastname;
        $email = $val->email;
        array_push($students,$sid);

        if(array_key_exists('isNew',$val)){
            $isNewItem = true;
            $result = mysql_query("INSERT INTO student(StudentID,CourseID,SectionNumber,firstname,lastname,email)
                        VALUE ('$sid','$cid','$sec','$fname','$lname','$email')");
            if($result){
            $userRecords = mysql_query("SELECT * FROM user");

            if (mysql_num_rows($userRecords) > 0) {
                $isUserCount = 0;
                while ($row = mysql_fetch_array($userRecords)) {
                    if ($row["UserID"] == $sid) {
                        $isUserCount = $isUserCount + 1;
                    }
                }
                if ($isUserCount == 0) {

                    $insertUser = mysql_query("INSERT INTO user (UserID, Password, FirstName,  LastName, typeOfUser) VALUES
                                     ('$sid','$sid', '$fname ', '$lname', 'Student')");
                    if(!$insertUser){
                        $addNewUser = false;
                    }

                }
             }
            }else{
                $addNewStudent = false;
            }
        }
        else{
        $records = mysql_query("SELECT * FROM student where StudentID='$sid' AND firstname='$fname' AND lastname='$lname' AND email='$email' AND
                          CourseID='$cid' AND SectionNumber='$sec'");

        if(mysql_num_rows($records)==0){
            $isUpdateItem = true;
            $updateStudent = mysql_query("UPDATE student set firstname='$fname',lastname='$lname',email='$email' WHERE StudentID='$sid'");
            if($updateStudent){
                $updateUser =  mysql_query("UPDATE user set FirstName='$fname',LastName='$lname'WHERE UserID='$sid'");
                if(!$updateUser){
                    $updateUser = false;
                }
            }else{
                $updateStudent = false;
            }
        }
        }
    }
    //to Delete
//    $studentrecords = mysql_query("SELECT * FROM student WHERE CourseID='$cid' AND SectionNumber='$sec'");
//    $numOfStudents = mysql_num_rows($studentrecords);
//    while ($row = mysql_fetch_array($studentrecords)) {
//        $temp = $row["StudentID"];
//        $isStudentExist = 0;
//        $deleteStudent = "";
//        foreach($students as $item){
//            if($item == $row["StudentID"]){
//                $isStudentExist++;
//            }
//        }
//        if($isStudentExist!=1){
//            $deleteStudent = mysql_query("DELETE FROM student WHERE StudentID='$temp'");
//            if(!$deleteStudent){
//                $isDeleted = false;
//            }
//        }
//
//    }


    if($addNewUser && $addNewStudent && $updateStudent && $updateUser){
        $response["success"] = 1;
        $response["message"] = "Successfully Updated Student details";
        echo json_encode($response);
    }else{
        $response["success"] = 0;
        if($isNewItem){
            if($addNewStudent){
                $response["message"] = "Failed to add New Student";
            }
            if($addNewUser){
                $response["message"] = "Failed to Create a login Account for Added Student";
            }
        }if($isUpdateItem){
            if($updateStudent){
                $response["message"] = "Failed to update Student";
            }
            if($updateUser){
                $response["message"] = "Failed to update User";
            }
        }
        echo json_encode($response);

    }

}else{
    $response["success"] = 0;
    $response["message"] = "No class is selected";
    echo json_encode($response);
}
?>