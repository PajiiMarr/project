<?php
session_start();

require_once '../admin/admin.class.php';

$reportObj = new Admin;

$reports = $reportObj->reports();
$total_collected = $reportObj->all_orgs_total_collected();

?>
<section class="container-fluid w-100 h-100">
    <!-- Header Section -->
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
        <div class="h-100 w-100 shadow rounded-large overflow-scroll">
            <!-- Reports Section -->
            <div class="h-50 w-100 border-bottom d-flex justify-content-around align-items-center">
                <div class="reports shadow rounded h-50 w-18 p-3 position-relative d-flex flex-column align-items-center">
                    <i class="fa-solid fa-building fs-1 text-crimson"></i>
                    <p class="fs-5 text-center mt-2">Organizations Active</p>
                    <h4 class="text-crimson"><?= $reports['organization_count'] ?? '0'; ?></h4>
                </div>

                <div class="reports shadow rounded h-50 w-18 p-3 position-relative d-flex flex-column align-items-center">
                    <i class="fa-solid fa-money-check-dollar fs-1 text-crimson"></i>
                    <p class="fs-5 text-center mt-2">Fees Collected</p>
                    <h4 class="text-crimson"><?= $reports['fees_collected'] ?? '0'; ?></h4>
                </div>

                <div class="reports shadow rounded h-50 w-18 p-3 position-relative d-flex flex-column align-items-center">
                    <i class="fa-solid fa-user-tie fs-1 text-crimson"></i>
                    <p class="fs-5 text-center mt-2">Facilitators Assigned</p>
                    <h4 class="text-crimson"><?= $reports['facilitators_count'] ?? '0'; ?></h4>
                </div>

                <div class="reports shadow rounded h-50 w-18 p-3 position-relative d-flex flex-column align-items-center">
                    <i class="fa-solid fa-user-graduate fs-1 text-crimson"></i>
                    <p class="fs-5 text-center mt-2">Students Enrolled</p>
                    <h4 class="text-crimson"><?= $reports['students_enrolled'] ?? '0'; ?></h4>
                </div>
            </div>
            <div class="h-50 w-100">
                <h5 class="p-3">Organizations</h5>
                <table class="w-100">
                    <thead>
                        <tr class="border-top border-bottom">
                            <th class="p-3 w-50">Organization</th>
                            <th class="p-3 w-50">Total Collected</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($total_collected as $total){ ?>
                            <tr class="border-bottom">
                                <td class="p-3"><?= $total['org_name'] ?></td>
                                <td class="p-3"><?= $total['all_collected'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
