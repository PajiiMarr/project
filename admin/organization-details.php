<?php
require_once 'admin.class.php';
require_once '../utilities/clean.php';

if (isset($_GET['organization_id'])) {
    $objAdmin = new Admin;
    $organization_details = $objAdmin->orgDetails($_GET['organization_id']);

    if ($organization_details) {
        ?>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><?= htmlspecialchars($organization_details['org_name']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Status: <?= htmlspecialchars($organization_details['status']) ?></p>
                        <!-- Add more organization details here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary brand-bg-color">Save Organization</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<p>Organization details not found.</p>";
    }
}
?>
