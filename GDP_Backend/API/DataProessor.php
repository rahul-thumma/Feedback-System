<?php
/**
 * Created by PhpStorm.
 * User: sahitya_pasnoor
 * Date: 11/5/15
 * Time: 10:07 AM
 */

$post_data = array(
    "Message" => "Student performance over the semester",
    'Axis' => array(
        "date" => "string",
        "rating" => "number"),
    "Data" => array(

        array("date" => "9/2/2015", "rate" => 1),
        array("date" => "10/3/2015", "rate" => 2.1),
        array("date" => "10/19/2015", "rate" => 4.1),
        array("date" => "11/22/2015", "rate" => 2.8),
        array("date" => "9/17/2015", "rate" => 3.2))

);

echo json_encode($post_data, JSON_UNESCAPED_SLASHES);
?>