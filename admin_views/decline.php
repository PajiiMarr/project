<?php
session_start();
require_once '../classes/admin.class.php';
require_once '../tools/clean.php';

$objAdmin = new Admin;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $collection_id = isset($_POST['collection_id']) ? clean_input($_POST['collection_id']) : '' ;
    
    $objAdmin->decline_request($collection_id);
    echo json_encode([
        'status' => 'success'
    ]);
}
?>