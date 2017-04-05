<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 11/12/2015
 * Time: 10:49 AM
 */

require_once '../ConnectionManager.php';

$db = ConnectionManager::getInstance();

$response  = array();

if(!empty($_GET["facultyid"]) || !empty($_GET["facultyName"])) {

    if(!empty($_GET["facultyid"])){

        $fid = trim($_GET["facultyid"]);

       // echo strlen($fid);
      //  echo strstr($fid);
//        $fid = strstr($fid,'A');
//        echo strlen($fid);
        $pos = strpos($fid,'All');
        if($pos == true) {
            $result = mysql_query("select * from faculty");
            if (mysql_num_rows($result) > 0) {
                $response['faculty'] = array();

                while ($row = mysql_fetch_array($result)) {
                    $faculty = array();
                    $faculty["facultyId"] = $row["facultyId"];
                    $faculty["firstName"] = $row["firstName"];
                    $faculty["lastName"] = $row["lastName"];
                    $faculty["department"] = $row["department"];
                    array_push($response["faculty"], $faculty);
                }
                $response["success"] = 1;
                echo json_encode($response);
            }else{
                $response["success"] = 0;
                $response["message"] = "No Faculty is Found";
                echo json_encode($response);
            }
        }else{
            $result = mysql_query("select * from faculty WHERE facultyId = '$fid'");
            if (mysql_num_rows($result) > 0) {
                $faculty = array();
                while ($row = mysql_fetch_array($result)) {
                    $faculty["facultyId"] = $row["facultyId"];
                    $faculty["facultyName"] = $row["facultyName"];
                    $faculty["department"] = $row["department"];
                    array_push($response["faculty"], $faculty);
                }
                $response["success"] = 1;
                echo json_encode($response);
            }else{
                $response["success"] = 0;
                $response["message"] = "No Faculty is Found";
                echo json_encode($response);
            }
        }
    }
   if(!empty($_GET["facultyName"])){
        $fname = $_GET["facultyName"];
       $result = mysql_query("select * from faculty WHERE facultyName = '$fname'");
       if (mysql_num_rows($result) > 0) {
           $faculty = array();
           while ($row = mysql_fetch_array($result)) {
               $faculty["facultyId"] = $row["facultyId"];
               $faculty["facultyName"] = $row["facultyName"];
               $faculty["department"] = $row["department"];
               array_push($response["faculty"], $faculty);
           }
           $response["success"] = 1;
           echo json_encode($response);
       }else{
           $response["success"] = 0;
           $response["message"] = "No Faculty is Found";
           echo json_encode($response);
       }
    }

}

else {
    $response["success"] = 0;
    $response["message"] = "No Faculty is Found";
    echo json_encode($response);
}
?>