<?php
session_start();

require_once '../classes/facilitator.class.php';
require_once '../tools/clean.php';

$objFaci = new Facilitator;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $facilitator_details = $objFaci->facilitator_details($_SESSION['user']['user_id']);

    $amount = isset($_POST['amount']) ? clean_input($_POST['amount']) : '' ;
    $purpose = isset($_POST['purpose']) ? clean_input($_POST['purpose']) : '' ;
    $organization_id = clean_input($facilitator_details['organization_id']);

    $errors = [];

    if(empty($amount)){
        $errors['amount'] = "Amount is required!";
    }

    if(empty($purpose)){
        $errors['purpose'] = "Purpose is required!";
    }

    if(!empty($errors)){
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
        exit;
    }

    $objFaci->request_fee($organization_id, $amount, $purpose);
    echo json_encode([
        'status' => 'success'
    ]);
}
?>