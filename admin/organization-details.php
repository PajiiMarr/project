<?php
require_once 'admin.class.php';
require_once '../utilities/clean.php';

if (isset($_GET['organization_id'])) {
    $objAdmin = new Admin;
    $organization_details = $objAdmin->orgDetails($_GET['organization_id']);

    if ($organization_details) {
        ?>
        <style>
        .modal.fade .modal-dialog {
            transform: translateX(100%);
            transition: transform 0.2s ease-in-out;
        }

        /* Apply the sliding-in effect when the modal is shown */
        .modal.fade.show .modal-dialog {
            transform: translateX(0); /* Modal moves to the center */
        }
        .modal-side-right {
                position: fixed;
                right: 0;
                margin: 0;
                width: 100vw; /* Adjust width as needed */
                height: 100vh; /* Full viewport height */
        }</style>
        <div class="modal fade bd-example-modal-lg" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-side-right modal-lg h-100">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-4" id="staticBackdropLabel"><?= htmlspecialchars($organization_details['org_name']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="lh-sm">
                            <p class="fs-5 fw-5">Description:</p>
                            <p><?= empty($organization_details['org_description']) ? "Not available."  :  clean_input($organization_details['org_description']);?></p>
                        </div>

                        <div class="lh-sm">
                            <p class="fs-5">Status:</p>
                            <p><?= clean_input($organization_details['status']) ?></p>
                        </div>

                        <div class="lh-sm">
                            
                        </div>


                        <!-- Add more organization details here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary brand-bg-color">Save Organization</button>
                    </div>
                </div>
            </div>
        </div>
        >
        <?php
    } else {
        echo "<p>Organization details not found.</p>";
    }
}
?>
