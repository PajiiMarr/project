<?php
session_start();

require_once '../classes/facilitator.class.php';
require_once '../tools/clean.php';

$objFaci = new Facilitator;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $facilitator_details = $objFaci->facilitator_details($_SESSION['user']['user_id']);

    $purpose = isset($_POST['purpose']) ? clean_input($_POST['purpose']) : '' ;
    $description = isset($_POST['description']) ? clean_input($_POST['description']) : '' ;
    $amount = isset($_POST['amount']) ? clean_input($_POST['amount']) : '' ;
    $start_date = isset($_POST['start_date']) ? clean_input($_POST['start_date']) : '' ;
    $date_due = isset($_POST['date_due']) ? clean_input($_POST['date_due']) : '' ;
    $label = isset($_POST['label']) ? clean_input($_POST['label']) : '' ;

    $organization_id = clean_input($facilitator_details['organization_id']);

    $errors = [];
    
    if(empty($purpose)){
        $errors['purpose'] = "Purpose is required!";
    }

    if(empty($description)){
        $errors['description'] = "Description is required!";
    }

    if(empty($amount)){
        $errors['amount'] = "Amount is required!";
    }

    if(empty($start_date)){
        $errors['start_date'] = "Start Date is required!";
    }
    
    if(empty($date_due)){
        $date_due = null;
    }
    
    if(empty($label)){
        $errors['label'] = "Label is required!";
    }



    if(!empty($errors)){
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
        exit;
    }

    $objFaci->request_fee($organization_id, $amount, $purpose, $description, $start_date, $date_due, $label);
    echo json_encode([
        'status' => 'success'
    ]);
}
?>