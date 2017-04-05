<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 11/12/2015
 * Time: 10:49 AM
 */

require_once '../ConnectionManager.php';



$db = ConnectionManager::getInstance();

if(!empty($_POST["Course"] && $_POST["Section"])) {

    $cid = $_POST["Course"];
    $secNum = $_POST["Section"];

    $count = 1;
    if(preg_match('/,/',$secNum)){

        $parts = explode(',', $secNum);
        $count = count($parts);

    }
    $response = array();
    $response['assignment'] = array();
    for($i=0; $i<=$count-1; $i++) {

        if ($count == 1) {
            $secNum = $secNum;
        } else {
            $secNum = $parts[$i];
        }

        $result = mysql_query("SELECT * FROM assignment WHERE CourseID = '$cid' and SectionNumber = '$secNum'");

        $resultCourse = mysql_query("SELECT * FROM course WHERE CourseID = '$cid'");

        $temp = mysql_fetch_array($resultCourse);

        $courseName = $temp["CourseName"];

        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_array($result)) {

                $assignment = array();
                $assignment["CourseName"] = $courseName;
                $assignment["AssignmentID"] = $row["AssignmentID"];
                $assignment["CourseID"] = $row["CourseID"];
                $assignment["AssignmentType"] = $row["AssignmentType"];
                $assignment["TopicName"] = $row["TopicName"];
                $assignment["PresentationTime"] = $row["PresentationTime"];
                $type = trim($assignment["AssignmentType"]);
                $assignId = $assignment["AssignmentID"];

                if($type == "Individual"){
                    $assignment["StudentList"] = $row["StudentList"];
                    $assignment["StudentNames"] = $row["StudentList"];
                 $studentsid = $row["StudentList"];
                    $stuListRecord = mysql_query("SELECT * FROM student WHERE student.StudentID = '$studentsid'");
                    if(mysql_num_rows($stuListRecord) > 0){
                        $rowList = mysql_fetch_array($stuListRecord);
                        $assignment["StudentNames"] = $rowList["firstname"]." ".$rowList["lastname"];

                    }

                }else if($type == "Group" || $type == "Class"){
                    $stuListRecord = mysql_query("SELECT * FROM assignmentgroup,student WHERE AssignmentID = '$assignId' AND assignmentgroup.studentID=student.StudentID");
                    if(mysql_num_rows($stuListRecord) > 0){
                        $list = "";
                        $nameslist = "";
                        while($rowList = mysql_fetch_array($stuListRecord)){
                            $list = $list.",".$rowList["studentID"];
                            $nameslist = $nameslist.",".$rowList["firstname"]." ".$rowList["lastname"];
                        }
                        $list = ltrim($list,",");
                        $nameslist = ltrim($nameslist,",");
                        $assignment["StudentList"] = $list;
                        $assignment["StudentNames"] = $nameslist;
                    }

                }else{
                    $assignment["StudentList"] = $row["StudentList"];
                    $assignment["StudentNames"] = $row["StudentList"];
                }

                $assignment["SectionNumber"] = $row["SectionNumber"];
                array_push($response["assignment"], $assignment);
            }
            $response["success"] = 1;
            $response["message"] = "assignment found";

        }

    }
    echo json_encode($response);

}

else {
    $response["success"] = 0;
    $response["message"] = "please choose the courseid and sectionNum ";
    echo json_encode($response);
}
?>