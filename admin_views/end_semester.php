<?php
session_start();
require_once '../classes/admin.class.php';
require_once '../tools/clean.php';

$objOrg = new Admin;


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sy_sem = isset($_POST['sy_sem']) ? clean_input($_POST['sy_sem']) : '' ;
    $previous_sem = $_POST['previous_semester'];
    if(empty($sy_sem)){
        $sy_semErr = 'Next School Year and Semester is required.';
    }

    if(!empty($sy_semErr)){
        echo json_encode([
            'status' => 'error',
            'errors' => $sy_semErr
        ]);
        exit;
    }

    $objOrg->end_sy_semester($sy_sem, $previous_sem);
    echo json_encode([
        'status' => 'success'
    ]);

}
?>