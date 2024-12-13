<?php
session_start();
require_once '../classes/admin.class.php';

$orgObj = new Admin;

$sy_sem = $orgObj->get_sy_sem();
?>
<div class="modal fade bd-example-modal-lg" id="endSemester" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">End Semester</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-end-semester">
            <div class="modal-body d-flex justify-content-center align-items-center">
                <p class="fs-5 mt-2 text-black">
                    Are you sure you want to end School Year <?= $sy_sem ?>?
                </p>
            </div>

            <div class="mx-4 mb-2">
                <label for="org_name">Next School Year/Semester:</label><br>
                <input type="text" name="sy_sem" id="sy_sem" class="form-control" placeholder="e.g., 2024-2025 Second Semester">
                <input type="hidden" name="previous_semester" value="<?= $sy_sem ?>">
                <div class="invalid-feedback"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger brand-bg-color" name="assign">End</button>
            </div>
        </form>
      </div>
    </div>
  </div>