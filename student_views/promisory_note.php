<?php
session_start();
require_once '../classes/student.class.php';
require_once '../tools/clean.php';
$objOrg = new Student;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $payment_id = $_SESSION['payment_id'];
    $note = isset($_POST['note']) ? clean_input($_POST['note']) : '';

    if(empty($note)){
        $noteErr = 'Note is required!';
    }

    if(!empty($noteErr)){
        echo json_encode([
            'status' => 'error',
            'errors' => $noteErr
        ]);
        exit;
    }



    $objOrg->insert_promisory_note($_SESSION['payment_id'], $_POST['note']);
    $_SESSION['payment_id'] = '';
    echo json_encode([
        'status' => 'success'
    ]);
}

?>