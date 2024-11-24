<?php
session_start();

require_once '../admin/admin.class.php';

$reportObj = new Admin;

$reports = $reportObj->reports();


?>
<section class="container-fluid w-100 h-100">
    <div class="h-18 w-100 border-bottom">
        <div class="h-50 w-100 custom-border-bottom d-flex align-items-center justify-content-center">
            <h1 class="ccs-green">College of Computing Studies</h1>
        </div>
        <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
            <p class="text-secondary fs-5 m-0">Dashboard/Overview</p>
            <h2 class="m-0">Dashboard</h2>
        </div>
    </div>
    <div class="container-fluid h-80 w-100 py-5 px-5">
        <div class="h-100 w-100 shadow rounded-large overflow-scroll">
            <div class="h-50 w-100 border-bottom d-flex justify-content-around align-items-center">
                <div class="reports shadow rounded h-50 w-18 p-3 position-relative">
                    <p class="fs-5">Organizations Active</p>
                    <h4><?= $reports['organization_count']  ?></h4>
                </div>

                <div class="reports shadow rounded h-50 w-18 p-3 position-relative">
                    <p class="fs-5">Fees Collected</p >
                    <h4><?= $reports['fees_collected']  ?></h4>
                </div>

                <div class="reports shadow rounded h-50 w-18 p-3 position-relative">
                    <p class="fs-5">Facilitators Assigned</p >
                    <h4><?= $reports['facilitators_count']  ?></h4>

                </div>

                <div class="reports shadow rounded h-50 w-18 p-3 position-relative">
                    <p class="fs-5">Students Enrolled</p >
                    <h4><?= $reports['organization_count']  ?></h4>
                </div>

            </div>
        </div>
    </div>
</section>