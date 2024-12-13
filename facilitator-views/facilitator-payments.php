<?php
session_start();
require_once '../classes/facilitator.class.php';

$paymentObj = new Facilitator;
$payment_org = $paymentObj->paymentHistory($_SESSION['user']['user_id']);
?> 

<section class="container-fluid w-100 h-100">
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
            <p class="text-secondary fs-5 m-0">Payment History/Overview</p>
            <h2 class="m-0">Payment History</h2>
        </div>
    </div>
    <div class="container-fluid h-80 w-100 py-5 px-5">
        <div class="h-100 w-100 shadow rounded-large overflow-scroll">
            <table class="max-h-100 w-100 table-hover">
                <tr class="bg-light-crimson">
                    <th class="fs-4 text-white p-2">No.</th>
                    <th class="fs-4 text-white p-2">Student</th>
                    <th class="fs-4 text-white p-2">Issued by</th>
                    <th class="fs-4 text-white p-2">Amount Paid</th>
                    <th class="fs-4 text-white p-2">Date Paid</th>
                </tr>
                <?php if (empty($payment_org)) { ?>
                    <tr>
                        <td colspan="4" class="text-center fw-bold fs-5 py-2">No Payments Found.</td>
                    </tr>
                <?php } else {
                    $counter = 1;
                    foreach ($payment_org as $ph): ?>
                        <tr>
                            <td class="p-3"><?= $counter; ?></td>
                            <td class="p-3"><?= $ph['last_name'] . ', ' . $ph['first_name'] . ' ' . $ph['middle_name']; ?></td>
                            <td class="p-3"><?= $ph['facilitator_id']; ?></td>
                            <td class="p-3"><?= $ph['amount_paid']; ?></td>
                            <td class="p-3"><?= $ph['date_issued']; ?></td>
                        </tr>
                <?php 
                    $counter++;
                    endforeach; 
                } ?>
            </table>
        </div>
    </div>
</section>
