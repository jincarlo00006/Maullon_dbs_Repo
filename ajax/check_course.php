<?php
 
require_once('../classes/database.php');
$con = new database();
 
if (isset($_POST['course_name'])) {
    $course_name = $_POST['course_name'];
   
    if ($con->isCourseExist($course_name)) {
 
        echo json_encode(['exists' => true]);
 
    } else {
        echo json_encode(['exists' => false]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}