<?php
require_once '../classes/admin.class.php';
require_once '../tools/clean.php';

$objOrgHead = new Admin;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = isset($_POST['student_id']) ? clean_input($_POST['student_id']) : '';
    $organization_id = isset($_POST['organization_id']) ? clean_input($_POST['organization_id']) : '';

    if (empty($organization_id)) {
        $organization_idErr = 'Please select an organization.';
        echo json_encode([
            "status" => "error",
            "errors" => $organization_idErr // Ensure this matches the JS check
        ]);
        exit;
    }

    $objOrgHead->assign_head($student_id, $organization_id);
    echo json_encode([
        "status" => "success"
    ]);
}

?>