<?php
session_start();
require_once '../classes/admin.class.php';

$orgObj = new Admin;


$get_org = $orgObj->get_org($_GET['organization_id']);
$_SESSION['organization_id'] = $_GET['organization_id'];
?>
<div class="modal fade bd-example-modal-lg" id="deactivateOrg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Deactivate Organization</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-deactivate-org">
            <div class="modal-body d-flex justify-content-center align-items-center">
                <p class="fs-5 mt-2 text-black">
                    Deactivate <?= $get_org['org_name']?>?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger brand-bg-color" name="assign">Deactivate</button>
            </div>
        </form>
      </div>
    </div>
  </div>