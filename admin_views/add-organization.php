<?php
session_start();

require_once '../admin/admin.class.php';
require_once '../utilities/clean.php';

$objOrg = new Admin;

$org_name = $org_description = $required_fee = '';
$org_nameErr = $required_feeErr = '';
$allinputsfield = true;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $org_name = isset($_POST['org_name']) ? clean_input($_POST['org_name']) : '';
    $org_description = isset($_POST['org_description']) ? clean_input($_POST['org_description']) : '';
    $required_fee = isset($_POST['required_fee']) ? clean_input($_POST['required_fee']) : '';

    if(empty($org_name)){
        $org_nameErr = 'Organization Name is required.';
        $allinputsfield = false;
    }
    if(empty($required_fee)){
        $required_feeErr = 'Required fee is required.';
        $allinputsfield = false;
    } else if(!is_numeric($required_fee)){
        $required_feeErr = 'Required fee must be a number.';
        $allinputsfield = false;
    }

    if(!($allinputsfield)){
        echo json_encode([
            "status" => "error",
            "org_nameErr" => $org_nameErr,
            "required_feeErr" => $required_feeErr
        ]);}

    if($allinputsfield) {
        if($objOrg->addOrganization($org_name, $org_description, $required_fee)){
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

    
}

?>