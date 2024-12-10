<?php
require_once '../classes/admin.class.php';

$studentObj = new Admin;


$student = $studentObj->fetch_student_details($_GET['student-id']);

?>
<div class="modal fade bd-example-modal-lg" id="enrollUndefinedStudent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Enroll Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-enroll-undefined-student">
            <div class="modal-body d-flex flex-column align-items-center justify-content-center">
                <input type="hidden" name="student_id" value="<?= $_GET['student-id'] ?>">
                <p class="fs-5 mt-2 text-black text-center">
                    Enroll <?= $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name']?>?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary brand-bg-color" name="assign">Enroll</button>
            </div>
        </form>
      </div>
    </div>
  </div>