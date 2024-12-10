<?php
require_once '../classes/admin.class.php';

$objCollection = new Admin;

$collection_fee = $objCollection->collection_fee_details($_GET['collection_id']);

?>
<div class="modal fade bd-example-modal-lg" id="approveFee" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Approve Collection Fee</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-approve-request">
             <div class="modal-body d-flex flex-column align-items-center justify-content-center">
                <input type="hidden" name="collection_id" value="<?= $_GET['collection_id']?>">
                <p class="fs-5 text-black text-center">
                    Approve <?= $collection_fee['purpose'] ?>, <?= $collection_fee['amount'] ?> of <?= $collection_fee['org_name'] ?>?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary brand-bg-color" name="approve">Approve</button>
            </div>
        </form>
      </div>
    </div>
  </div>