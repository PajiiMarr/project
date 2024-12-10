<section class="container-fluid w-100 h-100">
    <?php 
    session_start();
    require_once '../classes/facilitator.class.php';

    $objFaci = new Facilitator;

    $faci_details = $objFaci->facilitator_details($_SESSION['user']['user_id']);
    $org_details = $objFaci->get_org($faci_details['organization_id']);
    $reports = $objFaci->getDashboardData($faci_details['organization_id']);
    $total_collected = $objFaci->total_collection($faci_details['organization_id']);
    $recent_payments = $objFaci->recentPayments($faci_details['organization_id']);
    $students_enrolled = $objFaci->students_enrolled();
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
                    <?php if(isset($_SESSION['user']['is_facilitator'])){ ?>
                    <li><a class="dropdown-item" href="#">Switch as Student</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php } ?>
                    <li><a class="dropdown-item" href="<?= isset($_SESSION['user']['is_facilitator']) || isset($_SESSION['user']['is_facilitator']) ? '../log_out.php' : '../admin/admin_logout.php'; ?>">Sign out</a></li>
                </ul>
            </div>
        </div>
        <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
            <p class="text-secondary fs-5 m-0">Dashboard/Overview</p>
            <h2 class="m-0">Dashboard</h2>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container-fluid h-80 w-100 py-5 px-5">
        <div class="h-100 w-100 shadow rounded-large overflow-scroll p-4">
            <h3><?= htmlspecialchars($org_details['org_name']) ?></h3>
            <div class="row g-3 mb-5 d-flex justify-content-center align-items-center">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="reports shadow rounded-large p-3 d-flex flex-column align-items-center bg-white">
                        <i class="fa-solid fa-money-check-dollar fs-1 text-crimson"></i>
                        <p class="fs-5 text-center mt-2">Fees Collected</p>
                        <h4 class="text-crimson"><?= $total_collected['total_collected'] ?></h4>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="reports shadow rounded-large p-3 d-flex flex-column align-items-center bg-white">
                        <i class="fa-solid fa-calendar-day fs-1 text-crimson"></i>
                        <p class="fs-5 text-center mt-2">Payments Collected</p>
                        <h4 class="text-crimson"><?= $reports['payments_issued'] ?></h4>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="reports shadow rounded-large p-3 d-flex flex-column align-items-center bg-white">
                        <i class="fa-solid fa-school fs-1 text-crimson"></i>
                        <p class="fs-5 text-center mt-2">Enrolled Students</p>
                        <h4 class="text-crimson"><?= $students_enrolled['students_enrolled'] ?></h4>
                    </div>
                </div>
            </div>
            <!-- Recent Payments Section -->
            <div class="mt-4">
                <h3 class="text-crimson mb-4">Recent Payments</h3>
                <table class="table table-striped rounded-large overflow-hidden">
                    <thead>
                        <tr class="bg-light-crimson">
                            <th class="fs-5 text-black p-3">#</th>
                            <th class="fs-5 text-black p-3">Student Name</th>
                            <th class="fs-5 text-black p-3">Amount</th>
                            <th class="fs-5 text-black p-3">Date Paid</th>
                            <th class="fs-5 text-black p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recent_payments)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3 fw-bold text-muted">No Recent Payments</td>
                            </tr>
                        <?php else: $index = 1; ?>
                            <?php foreach ($recent_payments as $rep): ?>
                                <tr>
                                    <td><?= $index; ?></td>
                                    <td><?= $rep['last_name'] . ', ' . $rep['first_name'] .  ' ' . $rep['middle_name'] ?></td>
                                    <td><?= $rep['amount_paid'] ?></td>
                                    <td><?= $rep['date_issued'] ?></td>
                                    <td><?= $rep['status']?></td>
                                </tr>
                            <?php $index++; endforeach; ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <a href="" id="see-more">See More</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
