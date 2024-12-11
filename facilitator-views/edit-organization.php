<?php
session_start();

require_once '../classes/facilitator.class.php';
require_once '../tools/clean.php';

$objFaci = new Facilitator;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $facilitator_details = $objFaci->facilitator_details($_SESSION['user']['user_id']);

    $org_name = isset($_POST['org_name']) ? clean_input($_POST['org_name']) : '' ;
    $org_description = isset($_POST['org_description']) ? clean_input($_POST['org_description']) : '' ;
    $contact_email = isset($_POST['contact_email']) ? clean_input($_POST['contact_email']) : '' ;

    $organization_id = clean_input($facilitator_details['organization_id']);

    $errors = [];
    
    if(empty($org_name)){
        $errors['org_name'] = "Organization Name is required!";
    }

    if(empty($org_description)){
        $errors['org_description'] = " Description is required!";
    }

    if(empty($contact_email)){
        $errors['contact_email'] = "Email is required!";
    }

    if(!empty($errors)){
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
        exit;
    }

    $objFaci->editOrganization($organization_id, $org_name, $org_description, $contact_email);
    echo json_encode([
        'status' => 'success'
    ]);
}
?>