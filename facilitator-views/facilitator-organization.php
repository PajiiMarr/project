<section class="container-fluid w-100 h-100">
    <?php 
    session_start();
    require_once '../classes/facilitator.class.php';

    $objFaci = new Facilitator;

    $faci_details = $objFaci->facilitator_details($_SESSION['user']['user_id']);
    $org_details = $objFaci->get_org($faci_details['organization_id']);
    $org_all_fees = $objFaci->org_all_fees($faci_details['organization_id']);
    $officer_list = $objFaci->get_officers($faci_details['organization_id']);

    ?>
    <div class="modal-container"></div>
    <div class="h-18 w-100 border-bottom">
        <div class="h-50 w-100 position-relative custom-border-bottom d-flex align-items-center justify-content-center">
            <h1 class="ccs-green">College of Computing Studies</h1>
            <div class="dropdown text-end position-absolute" style="right: 5px;">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-circle-user fs-4 crimson"></i>
                </a>
                <ul class="dropdown-menu text-small">
                    <li><a class="dropdown-item" href="">Sign out</a></li>
                </ul>
            </div>
        </div>
        <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
            <p class="text-secondary fs-5 m-0">Organization/Overview</p>
            <h2 class="m-0">Organization</h2>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container-fluid h-80 w-100 py-5 px-5">
        <div class="h-100 w-100 shadow rounded-large overflow-scroll p-4">
            <div class="d-flex justify-content-between border-bottom">
                <h5 class="pb-3"><?= $org_details['org_name'] ?></h5>
                <?php if($faci_details['is_collector'] == 0){ ?>    
                    <a href="" id="edit-organization" data-id="<?= $faci_details['organization_id'] ?>" class="fs-5">
                        <i class="fa-solid fa-pen px-1"></i> 
                        Edit Organization
                    </a>
                <?php } ?>    
            </div>
            
            <div class="border-bottom py-3">
                Description: <br>
                <?= $org_details['org_description']; ?>
            </div>

            <div class="border-bottom py-3">
                Email: <br>
                <?= empty($org_details['contact_email']) ? 'Empty' : $org_details['contact_email'] ; ?>
            </div>

            <div class="border-bottom py-3">
                Collection Fees:
                <table>
                    <thead>
                        <tr>
                            <th class="text-black p-2 text-center" style="width: 33.33%;">Payment Name</th>
                            <th class="text-black p-2 text-center" style="width: 33.33%;">Amount</th>
                            <th class="text-black p-2 text-center" style="width: 33.33%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($org_all_fees)){ ?>
                            <tr>
                                <td colspan="3">No collection fees found.</td>
                            </tr>
                        <?php exit; } ?>
                            <?php foreach($org_all_fees as $oaf){ ?>
                                <tr>
                                    <td class="text-black p-2 w-25 text-center"><?= $oaf['purpose']?></td>
                                    <td class="text-black p-2 w-25 text-center"><?= $oaf['amount'] ?></td>
                                    <td 
                                    class=" text-center
                                    <?php
                                    if($oaf['request_status'] == 'Pending') echo 'text-warning';
                                    else if($oaf['request_status'] == 'Approved') echo 'text-success';
                                    else if($oaf['request_status'] == 'Declined') echo 'text-danger';
                                    ?>
                                    p-2 w-25 ">
                                    <?= $oaf['request_status']?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3" class="text-center">
                                    <a href="" id="see_more">See More</a>
                                </td>
                            </tr>
                    </tbody>
                </table>

            </div>

            <div class="py-3">
                Officers:
                <table class="">
                    <thead>
                        <tr>
                            <th class="text-black p-2 w-25">Facilitator Name</th>
                            <th class="text-black p-2 w-25">Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($org_all_fees)){ ?>
                            <tr>
                                <td colspan="2">No assigned officers.</td>
                            </tr>
                        <?php exit; } ?>
                            <?php foreach($officer_list as $ol){ ?>
                                <tr>
                                    <td class="p-2 w-25"><?= $ol['last_name'] . ', ' . $ol['first_name'] . ' ' . $ol['middle_name']?></td>
                                    <td class="p-2 w-25">
                                        <?php 
                                        if($ol['is_head'] == 1) echo 'Head';
                                        else if($ol['is_assistant_head'] == 1) echo 'Assistant Head';
                                        else if($ol['is_collector'] == 1) echo 'Fee Collector';
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>
</section>
