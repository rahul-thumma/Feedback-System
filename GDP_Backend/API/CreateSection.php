<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 11/12/2015
 * Time: 10:49 AM
 */


require_once '../ConnectionManager.php';

$response = array();
//echo "iam in register";
$db = ConnectionManager::getInstance();
/*echo  implode("|",array_keys($_POST));
$cid = $_POST["CourseID"];
$fname = $_POST["FacultyName"];
$snum = $_POST["SectionNumber"];
$cName = $_POST["CourseName"];
echo $cName;
$stime = $_POST["StartTime"];
$endtime = $_POST["EndTime"];*/

//echo implode("|",array_keys($_POST));
//echo $_POST["info"];


/*foreach ($_POST as $key => $value) {
    //do something
}*/

$result = "success";
if (isset($_POST["info"])) {

    $x = json_decode($_POST["info"]);
    $cid = $x->course[0]->CourseID;
    $fname = $x->course[0]->FacultyName;
    $snum = $x->course[0]->SectionNumber;
    $cName = $x->course[0]->CourseName;
    $stime = $x->course[0]->StartTime;
    $endtime = $x->course[0]->EndTime;
    $text = "";
    $ss = 1;
    $failedUser="";


    // code for checking course id and course name are unique or not

    /*    $isUniqueCourseID = 0 ;
        $isUniqueCourseName = 0 ;
    if (isset($cid) || isset($cName)) {

        $iscourseName = mysql_query("select CourseName from course where CourseID = '$cid'");

        while ($row = mysql_fetch_array($iscourseName)) {
            if ($row["CourseName"] != $cName) {
                $isUniqueCourseName = $isUniqueCourseName + 1;
            }
        }
        $iscourseID = mysql_query("select CourseID from course where CourseName = '$cName'");

        while ($row = mysql_fetch_array($iscourseID)) {
            if ($row["CourseID"] != $cName) {
                $isUniqueCourseID = $isUniqueCourseID + 1;
            }
        }
    }*/



        if (isset($cid) || isset($cname) || isset($snum) || isset($cName) || isset($stime) || isset($endtime)) {
            $result2 = mysql_query("INSERT INTO course (CourseID, CourseName, SectionNumber, facultyname, starttime,endtime) VALUES
                            ('$cid', '$cName', '$snum ', '$fname', '$stime', '$endtime')");

            if (!$result2) {
                $result = "section fail";
            }
        }

        if ($result == "success") {
            foreach ($x->file[0] as $key => $value) {
                //do something
                $v = $value;

                // $myArray = split ("\r", $v);
                $text = str_replace("\r", "%", $value);

                $myArray = split("%", $text);
                foreach ($myArray as $value1) {

                    $arr2 = array();
                    $arr2 = split(",", $value1);
                    $items = array();
                    foreach ($arr2 as $value2) {
                        $items[] = $value2;
                    }
                    if (count($items) == 4) {

                        $counter = 1;
                        $studentID = "";
                        $firstname = "";
                        $lastname = "";
                        $email = "";
                        foreach ($items as $value3) {
                            if ($counter == 1) {
                                $studentID = $value3;
                            }
                            if ($counter == 2) {
                                $firstname = $value3;
                            }
                            if ($counter == 3) {
                                $lastname = $value3;
                            }
                            if ($counter == 4) {
                                $email = $value3;
                            }
                            $counter = $counter + 1;
                        }

                        if ($studentID != null || $firstname != null || $lastname != null || $email != null) {
                            $result1 = mysql_query("INSERT INTO student (StudentID, CourseID, SectionNumber, firstname, lastname, email) VALUES
                            ('$studentID','$cid', '$snum ', '$firstname', '$lastname ', '$email')");

                            if (!$result1) {
                                $result = "student fail";
                                mysql_query("delete from course where CourseID = '$cid' ");
                            }
                            if ($result == "success") {
                                $userRecords = mysql_query("SELECT * FROM user");

                                if (mysql_num_rows($userRecords) > 0) {
                                    $isUserCount = 0;
                                    while ($row = mysql_fetch_array($userRecords)) {
                                        if ($row["UserID"] == $studentID) {
                                            $isUserCount = $isUserCount + 1;
                                        }
                                    }
                                    if ($isUserCount == 0) {

                                        $insertUser = mysql_query("INSERT INTO user (UserID, Password, FirstName,  LastName, typeOfUser) VALUES
                                     ('$studentID','$studentID', '$firstname ', '$lastname', 'Student')");
                                        if (!$insertUser) {
                                            $result = "user fail";
                                            $failedUser = $studentID;
                                        }

                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($result == "success") {
            $response["success"] = 1;
            $response["message"] = "Successfully Created New Section";
            echo json_encode($response);
        }elseif($result == "section fail"){
            $response["success"] = 0;
            $response["message"] = "Successfully Created New Section";
            echo json_encode($response);
        }elseif($result == "student fail"){
            $response["success"] = 0;
            $response["message"] = "Failed to add student in the section";
            echo json_encode($response);
        }elseif($result == "user fail"){
            $response["success"] = 0;
            $response["message"] = "Failed to add student into the user database";
            $response["failedUser"] = $failedUser;
            echo json_encode($response);
        }
        else {
           $response["success"] = 0;
            $response["message"] = "Failed to Create New Section";
            echo json_encode($response);
        }
    }

  else {
        $response["success"] = 0;
        $response["message"] = "Required field is missing";
        echo json_encode($response);
    }

?>