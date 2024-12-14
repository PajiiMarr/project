<?php 
session_start();

require_once '../classes/facilitator.class.php';

$objFaci = new Facilitator;

$promisory_note = $objFaci->see_promisory($_GET['payment_id']);
?>
<div class="modal fade" id="seeMore" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Promisorry Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-note-view">
            <div class="modal-body">


                <div class="mb-2">
                    Note: <br>
                    <?= $promisory_note['note']; ?>
                </div>
                
                <div class="mb-2">
                    <label for="text" class="form-label">Note</label>
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