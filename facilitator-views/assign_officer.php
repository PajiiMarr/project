<?php
require_once '../classes/facilitator.class.php';
require_once '../tools/clean.php';

$faciObj = new Facilitator;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = isset($_POST['student_id']) ? clean_input($_POST['student_id']) : '' ;
    $organization_id = isset($_POST['organization_id']) ? clean_input($_POST['organization_id']) : '' ;
    $position = isset($_POST['position']) ? clean_input($_POST['position']) : '' ;

    $student = $faciObj->fetch_student_details($student_id);


    $error = [];

    if(empty($position)){
        $error['position'] = 'Please select a position.';
        echo json_encode([
            'status' => 'error',
            'error' => $error
        ]);
        exit;
    }

    echo json_encode([
        'status' => 'success'
    ]);
    $faciObj->assign_officer($student_id,$organization_id,$position);
}

?>