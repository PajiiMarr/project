<?php 
session_start();

?>
<div class="modal fade" id="add-payment-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Request Payment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post" id="form-request-payment">
            <div class="modal-body">
                <div class="mb-2">
                    <label for="fee" class="form-label">Amount</label>
                    <input type="number" class="form-control" name="amount" id="amount">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="text" class="form-label">Purpose</label>
                    <input type="text" class="form-control" id="purpose" name="purpose">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary brand-bg-color">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>