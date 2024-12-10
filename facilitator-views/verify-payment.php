<?php
require_once '../classes/facilitator.class.php';
require_once '../tools/clean.php';
session_start();

$paymentObj = new Facilitator;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $payment_id = clean_input($_POST['payment_id']);
    $amount_to_pay = clean_input(($_POST['amount_to_pay']));
    $facilitator_id = $_SESSION['user']['user_id'];

    $payment_atp = $paymentObj->paymentModal($payment_id);
    $errors = [];
    if(empty($amount_to_pay)){
        $errors['amount_to_pay'] = 'Amount to pay is required.';
    } else if ($amount_to_pay <= 0){
        $errors['amount_to_pay'] = 'Invalid amount.';
    } else if ($amount_to_pay > $payment_atp['amount']){
        $errors['amount_to_pay'] = 'Amount is greater than the pending balance: ' . $payment_atp['amount'];
    }

    if(!empty($errors)){
        echo json_encode([
            "status" => "error",
            "errors" => $errors
        ]);
        exit;
    }

    $paymentObj->updatePayment($payment_id, $amount_to_pay, $facilitator_id);
    echo json_encode([
        "status" => "success"
    ]);
}
?>