<?php
require_once '../admin/admin.class.php';
require_once '../utilities/clean.php';

$objRemove = new Admin;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = isset($_POST['student_id']) ? clean_input($_POST['student_id']) : '';

    $objRemove->enrollUndefinedStudent($student_id);
    
    echo json_encode([
        "status" => "success"
    ]);
}
?>