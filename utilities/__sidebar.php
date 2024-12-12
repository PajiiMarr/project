<?php
if($_SESSION['user']['is_admin'] == 1){
     ?>
<div class="admin-icon  d-flex flex-column justify-content-center align-items-center">
    <i class="fa-regular fa-circle-user icon-size crimson py-3"></i>
    <h2>Admin</h2>
</div>
<div class="modal-container">

</div>
<div class="admin-nav d-flex flex-column justify-content-between">
    <div class="an-child h-35 w-100 d-flex flex-column">
        <nav class="h-100 w-100">
            <ul class="list-unstyled h-100 w-100 d-flex flex-column justify-content-center align-items-center mt-2">
                <li class="header-list w-100 h-25 li-unselected px-2">
                    <a href="dashboard.php" id="dashboard-link" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                    <i class="fas fa-dashboard w-25 fs-4"></i>
                        <p class="w-75 fs-5 pt-3">Dashboard</p>
                    </a>
                </li>
                <li class="header-list w-100 h-25 li-unselected px-2">
                    <a href="organization.php" id="org-overview-link" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                        <i class="fa-solid fa-people-group w-25 fs-4"></i>
                        <p class="w-75 fs-5 pt-3">Organizations</p>
                    </a>
                </li>
                <li class="header-list w-100 h-25 px-2 li-unselected li-student">
                    <a href="student.php" id="student-link" class="anchor-tag student-anchor d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                        <i class="fa-regular fa-user w-25 mt-1 fs-4"></i>
                        <p class="w-75 fs-5 pt-3">Students</p>
                    </a>

                </li>
                <li class="header-list w-100 h-25 li-unselected px-2">
                    <a href="payments.php" id="payment-link" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                        <i class="fa-solid fa-people-group w-25 fs-4"></i>
                        <p class="w-75 fs-5 pt-3">Payment History</p>
                    </a>
                </li>
                    
            </ul>
        </nav>
    </div>

</div>
<div class=".enroll-student-button d-flex justify-content-end align-items-center">
<div class="an-child h-25 w-100 p-2 d-flex flex-column justify-content-center align-items-center">
        <a id="enroll-student" class="btn w-100 h-20 my-2 py-4 bg-crimson d-flex">
            <div class="w-25 h-100 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-plus fs-4"></i>
            </div>
            <div class="w-75 h-100 d-flex align-items-center justify-content-start">
                <p class="fs-5 mb-0">Enroll Students</p>
            </div>
        </a>
    </div>
</div>


<?php
} else if($_SESSION['user']['is_facilitator'] == 1){
    require_once '../classes/facilitator.class.php';
    $faci_details = new Facilitator;

    $facilitator = $faci_details->facilitator_details($_SESSION['user']['user_id']);
    if($facilitator['org_status'] == 'Active'){
    ?>
    <div class="facilitator-icon d-flex flex-column justify-content-center align-items-start pt-5 ps-3">
        <h2 class="text-black">Facilitator</h2>
    </div>
    <div class="facilitator-nav d-flex flex-column justify-content-between">
        <div class="an-child h-75 w-100 d-flex flex-column">
            <nav class="h-100 w-100">
                <ul class="list-unstyled h-100 w-100 d-flex flex-column justify-content-center align-items-center mt-2">
                    <li class="header-list w-100 h-25 li-unselected px-2">
                        <a href="dashboard.php" id="facilitator-dashboard-link" data-id="<?= $_SERVER['REQUEST_URI'] ?>" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fas fa-tachometer-alt w-25 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Dashboard</p>
                        </a>
                    </li>

                    <li class="header-list w-100 h-25 li-unselected px-2">
                        <a href="organization.php" id="facilitator-organization-link" data-id="<?= $_SERVER['REQUEST_URI'] ?>"  class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fa-solid fa-people-group w-25 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Organization</p>
                        </a>
                    </li>

                    <?php if($facilitator['is_collector'] == 0){ ?>
                    <li class="header-list w-100 h-25 px-2 li-unselected li-student">
                        <a href="assign.php" id="facilitator-assign-officer data-id="<?= $_SERVER['REQUEST_URI'] ?>"" class="anchor-tag student-anchor d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fas fa-user-tie w-25 mt-1 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Assign Officer</p>
                        </a>
                    </li>

                    <?php } ?>
                    <li class="header-list w-100 h-25 px-2 li-unselected li-student">
                        <a href="student.php" id="facilitator-student-link" data-id="<?= $_SERVER['REQUEST_URI'] ?>" class="anchor-tag student-anchor d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fa-solid fa-users w-25 mt-1 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Issue Payment</p>
                        </a>
                    </li>

                    <?php if($facilitator['is_collector'] == 0){ ?>
                    <li class="header-list w-100 h-25 li-unselected px-2">
                        <a href="request.php" id="facilitator-request-link" data-id="<?= $_SERVER['REQUEST_URI'] ?>" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fas fa-clipboard w-25 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Requests</p>
                        </a>
                    </li>
                    <?php } ?>

                    <li class="header-list w-100 h-25 li-unselected px-2">
                        <a href="payments.php" id="facilitator-payment-link" data-id="<?= $_SERVER['REQUEST_URI'] ?>"  class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fa-solid fa-money-check w-25 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Payments</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
    <?php if($facilitator['is_collector'] == 0){ ?>
    <div class="d-flex justify-content-center align-items-end w-100 pb-4" >
        <a class="btn bg-crimson fs-5 d-flex justify-content-center align-items-center w-75" id="request-payment"> <i class="fas fa-plus me-2 fs-5"></i> Propose Organization Fee</a>
    </div>

    <?php } 
}
} if ($_SESSION['user']['is_facilitator'] == 1 || $_SESSION['user']['is_student'] == 1){?>
    <div class="d-flex flex-column justify-content-start align-items-start pt-2 ps-3 border-top">
        <h2 class="text-black">Student</h2>
    </div>
    <div class="facilitator-nav d-flex flex-column justify-content-between">
        <div class="an-child h-75 w-100 d-flex flex-column">
            <nav class="h-100 w-100">
                <ul class="list-unstyled h-100 w-100 d-flex flex-column justify-content-center align-items-center mt-2">
                    <li class="header-list w-100 h-25 li-unselected px-2">
                        <a href="dashboard.php" id="student-dashboard-link" data-id="<?= $_SERVER['REQUEST_URI'] ?>" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fas fa-tachometer-alt w-25 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Dashboard</p>
                        </a>
                    </li>
                    <li class="header-list w-100 h-25 li-unselected px-2">
                        <a href="organization.php" id="student-organization-link" data-id="<?= $_SERVER['REQUEST_URI'] ?>" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fas fa-people-group w-25 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Organization</p>
                        </a>
                    </li>
                    <li class="header-list w-100 h-25 li-unselected px-2">
                        <a href="payments.php" id="student-payment-link" data-id="<?= $_SERVER['REQUEST_URI'] ?>" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                            <i class="fa-solid fa-money-check w-25 fs-4"></i>
                            <p class="w-75 fs-5 pt-3">Payments</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div><?php } ?>