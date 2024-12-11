<?php
require_once '../classes/admin.class.php';
require_once '../tools/clean.php';

if (isset($_GET['organization_id'])) {
    $objAdmin = new Admin;
    $organization_details = $objAdmin->orgDetails($_GET['organization_id']);
    $facilitator_list = $objAdmin->facilitatorList($_GET['organization_id']);
    $collection_fees = $objAdmin->collection_fees($_GET['organization_id']);
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
        }



        #approveFee.modal,
        #declineFee.modal {
            z-index: 1060; /* Higher than default modal z-index */
        }

        #approveFee .modal-backdrop,
        #declineFee .modal-backdrop {
            z-index: 1055; /* Keep backdrop below the modal */
        }


        </style>
        <div class="request-container"></div>
        <div class="modal fade bd-example-modal-lg" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-side-right modal-lg h-100">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-4" id="staticBackdropLabel"><?= htmlspecialchars($organization_details['org_name']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="lh-sm text-black border-bottom">
                            <p class="fs-5 fw-5 ">Description:</p>
                            <p><?= empty($organization_details['org_description']) ? "Not available."  :  clean_input($organization_details['org_description']);?></p>
                        </div>
                        <div class="lh-sm text-black border-bottom mt-2 pb-2">
                            <p class="fs-5 fw-5 ">Email:</p>
                            <p><?= empty($organization_details['contact_email']) ? "Not available."  :  clean_input($organization_details['contact_email']);?></p>
                        </div>

                        <div class="lh-sm text-black border-bottom mt-2 pb-2">
                            <p class="fs-5">Status:</p>
                            <p><?= clean_input($organization_details['status']) ?></p>
                        </div>

                        <div class="lh-sm text-black border-bottom mt-2 pb-2">
                            <h5>Collection Fees</h5>
                            <table class="w-100 pb-3">
                                <thead>
                                    <tr class="border-bottom">
                                        <th class="p-1 fs-6 fw-6" style="width: 15%;">Amount</th>
                                        <th class="p-1 fs-6 fw-6" style="width: 15%">Purpose</th>
                                        <th class="p-1 fs-6 fw-6" style="width: 15%;">Status</th>
                                        <th class="p-1 fs-6 fw-6" style="width: 15%;">Start Date</th>
                                        <th class="p-1 fs-6 fw-6" style="width: 15%;">End Date</th>
                                        <th class="p-1 fs-6 fw-6" style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($collection_fees as $cof){ ?>
                                        <tr>
                                            <td class="p-1 fs-6 fw-6"><?= $cof['amount'] ?></td>
                                            <td class="p-1 fs-6 fw-6 text-nowrap w-25">
                                                <?= $cof['purpose'] ?>
                                                
                                            </td>
                                            <td class="p-1 fs-6 fw-6"><?= $cof['request_status'] ?></td>
                                            <td class="p-1 fs-6 fw-6"><?= $cof['start_date'] ?></td>
                                            <td class="p-1 fs-6 fw-6"><?= empty($cof['date_due']) ? 'TBA' : $cof['date_due'] ; ?></td>
                                            <td class="p-1 fs-6 fw-6 text-nowrap">
                                                <?php if($cof['request_status'] == 'Pending'){  ?>
                                                    <a href="" data-id="<?= $cof['collection_id'] ?>" class="btn btn-success ms-3 approve-request">Approve</a>
                                                    <a href="" data-id="<?= $cof['collection_id'] ?>" class="btn btn-danger decline-request">Decline</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="lh-sm text-black mt-2">
                            <div class="lh-sm text-black d-flex  justify-content-between w-50">
                                <p class="fs-5">Officers: </p>
                            </div>
                            <div>
                                <table class="w-50">
                                    <thead>
                                        <tr>
                                            <th class="fs-6 fw-6">Name</th>
                                            <th class="fs-6 fw-6">Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(empty($facilitator_list)){ ?>
                                        <tr>
                                           <td class="p-1" colspan="2">
                                                No Officers assigned.
                                           </td> 
                                        </tr>
                                    <?php } else {
                                        foreach($facilitator_list as $fl):
                                        ?>
                                        <tr>
                                            <td class="p-1 "><?= $fl['last_name'] . ', ' . $fl['first_name'] . ' ' . $fl['middle_name'] ?></td>
                                            <td class="p-1 ">
                                                <?php
                                                    if(!empty('is_head')){
                                                        echo 'Head';
                                                    } else if (!empty('is_assistant_head')) {
                                                        echo 'Assistant Head';
                                                    } else if (!empty('is_collector')) {
                                                        echo 'Fee Collector';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        endforeach;
                                        } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>


                        <!-- Add more organization details here -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary brand-bg-color">Edit Organization</button>
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
