<?php
session_start();

require_once '../classes/student.class.php';

$studentObj = new Student;

$paymentHist = $studentObj->payment_history($_SESSION['user']['user_id']);

?>

<section class="container-fluid w-100 h-100">
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
                    <div class="w-100 p-2">
                        <form method="post" action="" class="form-selector p-1 d-flex w-100">
                            <div class="w-18 d-flex align-items-center justify-content-around">
                                <label for="search">
                                    <i class="fa-solid fa-magnifying-glass fs-4"></i>
                                </label>
                                <input class="p-2 w-75" type="text" name="search" id="search" placeholder="Search...">
                            </div>
                            <!-- <div class="d-flex">
                                <label for="from_date" class="mx-2">From:</label>
                                <input type="date" id="from_date" name="from_date" value="//htmlspecialchars($from_date);">
                                
                                <label for="to_date" class="mx-2">To:</label>
                                <input type="date" id="to_date" name="to_date" class="me-2" value="//($to_date);">
                            </div> -->
                        </form>
                    </div>
                    
                    <table class="max-h-100 w-100 table-hover" id="table-payment-history">
                        <thead>
                            <tr class="bg-light-crimson">
                                <th class="fs-4 text-white p-2 text-start">No.</th>
                                <th class="fs-4 text-white p-2">Issued by</th>
                                <th class="fs-4 text-white p-2">Organization</th>
                                <th class="fs-4 text-white p-2 text-start">Amount Paid</th>
                                <th class="fs-4 text-white p-2">Date Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(empty($paymentHist)){ ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    No History Found.
                                </td>
                            </tr>
                        <?php exit; } ?>
                        <?php
                            $counter = 1;
                            foreach($paymentHist as $ph):
                                $timestamp = $ph['date_issued'];
                                $date = new DateTime($timestamp);
                        ?>
                                <tr>
                                    <td><?= $counter; ?></td>
                                    <td><?= $ph['last_name'] . ', ' . $ph['first_name'] . ' ' . $ph['middle_name']; ?></td>
                                    <td><?= $ph['org_name']?></td>
                                    <td class="text-start"><?= $ph['amount_paid']?></td>
                                    <td><?= $date->format('d F Y H:i:s')?></td>
                                </tr>
                        <?php
                        $counter++; endforeach;
                         ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>