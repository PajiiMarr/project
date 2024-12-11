<?php
session_start();
require_once '../classes/facilitator.class.php';

$orgObj = new Facilitator;

$organization_details = $orgObj->get_org($_GET['organization_id']);
?>
<div class="modal fade" id="editOrganization" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Organization</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post" id="form-edit-organization">
            <div class="modal-body">
                <div class=" mb-2">
                    <label for="org_name">Organization Name:</label><br>
                    <input type="text" name="org_name" id="org_name" class="form-control" value="<?= $organization_details['org_name']?>">
                    <div class="invalid-feedback"></div>
                </div>

                <div class=" mb-2">
                    <label for="description">Description:</label><br>
                    <input type="text" name="org_description" id="org_description" class="form-control" value="<?= $organization_details['org_description']?>">
                    <div class="invalid-feedback"></div>
                </div>
                
                <div class=" mb-2">
                    <label for="contact_email">Email:</label><br>
                    <input type="text" name="contact_email" id="contact_email" class="form-control" value="<?= $organization_details['contact_email']?>">
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