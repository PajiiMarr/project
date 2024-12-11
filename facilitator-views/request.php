<section class="container-fluid w-100 h-100">
    <?php 
    session_start();
    require_once '../classes/facilitator.class.php';

    $objFaci = new Facilitator;

    $requests = $objFaci->all_fees($_SESSION['user']['user_id']);
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
                    
                    <li><a class="dropdown-item" href="<?= isset($_SESSION['user']['is_facilitator']) || isset($_SESSION['user']['is_facilitator']) ? '../log_out.php' : '../admin/admin_logout.php'; ?>">Sign out</a></li>
                </ul>
            </div>
        </div>
        <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
            <p class="text-secondary fs-5 m-0">Request/Overview</p>
            <h2 class="m-0">Request</h2>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container-fluid h-80 w-100 py-5 px-5">
        <div class="h-100 w-100 shadow rounded-large overflow-scroll">
            <div class="p-3 w-18 d-flex align-items-center justify-content-around">
                <label for="search">
                    <i class="fa-solid fa-magnifying-glass fs-4"></i>
                </label>
                <input class="p-2 w-75" type="text" name="bsearch" id="search" placeholder="Search...">
            </div>
            <table class="max-h-100 w-100 table-hover" id="table-request">
                <thead>
                    <tr class="bg-light-crimson">
                        <th class="fs-4 text-white p-2 text-start ">No.</th>
                        <th class="fs-4 text-white p-2 text-start ">Amount</th>
                        <th class="fs-4 text-white p-2 text-start ">Purpose</th>
                        <th class="fs-4 text-white p-2 text-start ">Collection Start Date</th>
                        <th class="fs-4 text-white p-2 text-start ">Collection Date Due</th>
                        <th class="fs-4 text-white p-2 text-start ">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)) { ?>
                        <tr>
                            <td colspan="5" class="text-center fw-bold fs-5 py-2">No Requested Payments Found.</td>
                        </tr>
                    <?php } else {
                        $counter = 1;
                        foreach ($requests as $req): ?>
                            <tr class="border-bottom">
                                <td class="p-3 text-start "><?= $counter; ?></td>
                                <td class="p-3 text-start "><?= $req['amount'] ?></td>
                                <td class="p-3 text-start "><?= $req['purpose']; ?></td>
                                <td class="p-3 text-start "><?= $req['start_date'] == '0000-00-00' ? 'None' : $req['start_date'] ; ?></td>
                                <td class="p-3 text-start "><?= empty($req['date_due']) ? 'TBA' : $req['date_due'] ; ?></td>
                                <td
                                class="p-3 text-start <?php
                                if($req['request_status'] == 'Approved'){
                                    echo 'text-success';
                                } else if  ($req['request_status'] == 'Pending'){
                                    echo 'text-warning';
                                } else {
                                    echo 'text-danger';
                                }
                                ?>"
                                
                                ><?= $req['request_status']; ?></td>
                            </tr>
                    <?php 
                        $counter++;
                        endforeach; 
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
