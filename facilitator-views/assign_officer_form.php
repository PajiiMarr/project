<?php
session_start();
require_once '../classes/facilitator.class.php';

$studentObj = new Facilitator;

$facilitator_details = $studentObj->facilitator_details($_SESSION['user']['user_id']);
$organization = $studentObj->count_officer($facilitator_details['organization_id']);
$student = $studentObj->fetch_student_details($_GET['student_id']);

$assistant_head_count = $collector_count = 0;
$assistant_head_count += $organization['is_assistant_head'] != null || $organization['is_assistant_head'] != 0 ? 0 : 1 ;
$collector_count += $organization['is_collector'] != null || $organization['is_collector'] != 0 ? 0  : 1 ;

?>
<div class="modal fade bd-example-modal-lg" id="assignOfficer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Assign Organization Head</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-assign-officer">
            <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                <p class="fs-5 mt-2 text-black d-flex">
                    <?php

                    ?>
                    Assign <?= $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name']?> as an officer of <?= $organization['org_name'] ?>?
                </p>
                <div class="mb-2 ms-2">
                    <input type="hidden" name="student_id" id="student_id" value="<?= $_GET['student_id'] ?>">
                    <input type="hidden" name="organization_id" id="organization_id" value="<?= $facilitator_details['organization_id'] ?>">
                    </div>
                <div class="mx-3 mb-2">
                    <select name="position" id="position" class="p-2 rounded-3 fs-5">
                        <option value="">Position</option>
                        <option value="assistant_head">Assistant Head | Assigned: <?= $assistant_head_count ?></option>
                        <option value="collector">Fee Collector | Assigned: <?= $collector_count ?></option>
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