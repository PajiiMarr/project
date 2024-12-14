<?php
session_start();
require_once '../classes/admin.class.php';

$orgObj = new Admin;


$get_org = $orgObj->get_org($_GET['payment_id']);

$_SESSION['payment_id'] = $_GET['payment_id'];
?>
<div class="modal fade bd-example-modal-lg" id="promisoryNote" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add promisory note</h5>
            <button type="button" class="btn-close button-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" id="form-promi`sory-note">
            <div class="modal-body d-flex justify-content-center align-items-center">
            <div class="mb-2">
                    <label for="code" class="form-label">Note</label>
                    <textarea type="text" class="form-control w-100" id="note" name="note"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary button-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success brand-bg-color" name="assign">Add</button>
            </div>
        </form>
      </div>
    </div>
  </div>