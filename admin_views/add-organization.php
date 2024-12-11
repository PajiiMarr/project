<?php
session_start();

require_once '../classes/admin.class.php';
require_once '../tools/clean.php';

$objOrg = new Admin;

$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $org_name = isset($_POST['org_name']) ? clean_input($_POST['org_name']) : '';
    $org_description = isset($_POST['org_description']) ? clean_input($_POST['org_description']) : '';

    if(empty($org_name)){
        $errors["org_name"] = 'Organization Name is required.';
    }

    if (count(array_keys($errors))) {
        echo json_encode([
            "status" => "error",
            "errors" => $errors
        ]);
        exit;
    }


    if ($objOrg->addOrganization($org_name, $org_description)) {
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