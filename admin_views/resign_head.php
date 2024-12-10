<?php
require_once '../classes/admin.class.php';
require_once '../tools/clean.php';

$objOrgHead = new Admin;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $facilitator_id = isset($_POST['facilitator_id']) ? clean_input($_POST['facilitator_id']) : '';
    $reason = isset($_POST['reason']) ? clean_input($_POST['reason']) : '';

    if (empty($reason)) {
        $reasonErr = 'Reason is required.';
        echo json_encode([
            "status" => "error",
            "errors" => $reasonErr // Ensure this matches the JS check
        ]);
        exit;
    }

    $objOrgHead->resign($facilitator_id, $reason);
    
    echo json_encode([
        "status" => "success"
    ]);
}

?>