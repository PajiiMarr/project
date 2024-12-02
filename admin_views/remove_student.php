<?php
require_once '../admin/admin.class.php';
require_once '../utilities/clean.php';

$objRemove = new Admin;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = isset($_POST['student_id']) ? clean_input($_POST['student_id']) : '';
    $reason = isset($_POST['reason']) ? clean_input($_POST['reason']) : '';

    if (empty($reason)) {
        $reasonErr = 'Reason is required.';
        echo json_encode([
            "status" => "error",
            "errors" => $reasonErr // Ensure this matches the JS check
        ]);
        exit;
    }

    $objRemove->remove($student_id, $reason);
    
    echo json_encode([
        "status" => "success"
    ]);
}
?>