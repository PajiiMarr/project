<?php
require_once '../admin/admin.class.php';

$studentObj = new Admin;


$organizations = $studentObj->allOrgsHeadAssigned();
$student = $studentObj->fetch_student_details($_GET['student-id']);

?>
<div class="modal fade bd-example-modal-lg" id="assignHead" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Assign Organization Head</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-assign-head">
            <div class="modal-body d-flex justify-content-center align-items-center">
                <p class="fs-5 mt-2 text-black">
                    Assign <?= $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name']?> as an Organization Head of:
                </p>
                <div class="mb-2 ms-2">
                    <input type="hidden" name="student_id" id="student_id" value="<?= $_GET['student-id'] ?>">
                    <select name="organization_id" id="organization_id" class="p-2 border rounded-3 p-2 fs-5">
                        <option value="" selected disabled>Choose</option>
                        <?php 
                        foreach($organizations as $orgs):
                            if(empty($orgs['is_head'])){
                        ?>
                        <option value="<?= $orgs['organization_id'] ?>"><?= $orgs['org_name'] ?></option>
                        <?php
                            }
                        endforeach;
                        ?>
                    </select>
                    <div class="invalid-feedback fs-5"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary brand-bg-color" name="assign">Assign</button>
            </div>
        </form>
      </div>
    </div>
  </div>