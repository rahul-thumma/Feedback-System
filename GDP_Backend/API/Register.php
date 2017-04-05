<?php
/**
 * Created by PhpStorm.
 * User: S522626
 * Date: 11/12/2015
 * Time: 10:49 AM
 */

require_once '../ConnectionManager.php';


$return_arr = array();

$fetch = mysql_query("SELECT * FROM student");

while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
    $row_array['StudentID'] = $row['StudentID'];
    $row_array['col1'] = $row['col1'];
    $row_array['col2'] = $row['col2'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);


?>