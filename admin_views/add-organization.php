<?php
session_start();

require_once '../admin/admin.class.php';
require_once '../utilities/clean.php';

$objOrg = new Admin;

$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $org_name = isset($_POST['org_name']) ? clean_input($_POST['org_name']) : '';
    $org_description = isset($_POST['org_description']) ? clean_input($_POST['org_description']) : '';
    $contact_email = isset($_POST['contact_email']) ? clean_input($_POST['contact_email']) : '';
    $required_fee = isset($_POST['required_fee']) ? clean_input($_POST['required_fee']) : '';

    if(empty($org_name)){
        $errors["org_name"] = 'Organization Name is required.';
    }

    if(empty($contact_email)){
        $errors["contact_email"] = 'Email is required.';
    }
    
    if(empty($required_fee)){
        $errors["required_fee"] = 'Fee is required.';
    } else if(!is_numeric($required_fee)){
        $errors["required_fee"] = 'Fee must be a number';
    }

    if (count(array_keys($errors))) {
        echo json_encode([
            "status" => "error",
            "errors" => $errors
        ]);
        exit;
    }


    if ($objOrg->addOrganization($org_name, $org_description, $contact_email, $required_fee)) {
        echo json_encode([
            "status" => "success"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Something went wrong when adding an organization."
        ]);
    }
}

?>