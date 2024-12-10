<?php 
session_start();
require_once '../classes/admin.class.php';
require_once '../tools/clean.php';

$paymentObj = new Admin;

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $payment_id = isset($_GET['payment_id']) ? clean_input($_GET['payment_id']) : '' ;

    $payments_details = $paymentObj->paymentModal($payment_id);
}

?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create Payment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 
        <form action="" method="POST" id="form-create-payment">
            <div class="modal-body">
                <div class="mb-2 d-flex justify-content-around">
                    <div class="mx-2 text-black w-25">
                        <h6 class="form-label" style="margin: 0;">Student Name </h6>
                        <p>
                        <?= $payments_details['last_name'] . ', ' . $payments_details['first_name'] . ' ' . $payments_details['middle_name']?>
                        </p>
                    </div>
                    <div class="mx-2 text-black  w-25">
                        <h6 class="form-label" style="margin: 0;">Course</h6>
                        <p>
                            <?= $payments_details['course_code'];?>
                        </p>
                    </div>
                    <div class="mx-2 text-black w-25">
                        <h6 class="form-label" style="margin: 0;">Year</h6> 
                        <p>
                            
                            <?= $payments_details['course_year'];?>
                        </p>
                    </div>
                </div>

                <div class="mb-2 d-flex justify-content-around">
                    <div class="mx-2 text-black w-25">
                        <h6 class="form-label" style="margin: 0;">Organization</h6>
                        <p>
                            
                            <?= $payments_details['org_name'];?>
                        </p>
                    </div>
                    <div class="mx-2 text-black w-25">
                        <h6 class="form-label" style="margin: 0;">Required Fee</h6>
                        <p>
                            <?= $payments_details['required_fee'];?>

                        </p>
                    </div>
                    <div class="mx-2 text-black w-25">
                        <h6 class="form-label" style="margin: 0;">Fee to pay</h6>
                        <p>
                            <?= $payments_details['amount_to_pay'];?>

                        </p>
                    </div>
                </div>

                <div class="mb-2">
                    <input type="hidden" name="payment_id" id="payment_id" hidden value="<?= $payment_id ?>">
                    <label for="code" class="form-label">Amount </label>
                    <input type="number" class="form-control" id="amount_to_pay" name="amount_to_pay">
                    <div class="invalid-feedback"></div>
                </div>
            

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary brand-bg-color">Done</button>
            </div>
        </form>
      </div>
    </div>
  </div>