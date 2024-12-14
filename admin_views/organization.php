<?php
require_once '../classes/admin.class.php';
require_once '../tools/clean.php';
session_start();
$orgObj = new Admin;
$allOrganizations = $orgObj->allOrgs();

?>
<div class="modal-container"></div>
<section class="container-fluid w-100 h-100">
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
    <div class="container-fluid h-80 w-100 py-5 px-5">
        <div class="h-100 w-100 shadow rounded-large overflow-scroll">
            <div class="w-100 d-flex justify-content-between p-2">
                <form class="form-selector p-2 d-flex align-items-center justify-content-between w-100">
                    <div class="w-18 d-flex align-items-center justify-content-around">
                        <label for="search">
                            <i class="fa-solid fa-magnifying-glass fs-4"></i>
                        </label>
                        <input class="p-2 w-75" type="text" name="search" id="search" placeholder="Search...">
                    </div>
                </form>
            </div>
            <table id="table-organization" class="max-h-100 w-100 table-hover ">
                <thead>
                    <tr class="bg-light-crimson">
                        <th class="fs-4 text-white p-2 text-start">No.</th>
                        <th class="fs-4 text-white p-2">Organization</th>
                        <th class="fs-4 text-white p-2">Status</th>
                        <th class="fs-4 text-white p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $counter = 1;
                    foreach ($allOrganizations as $allorgs) {
                    ?>
                        <tr class="border-bottom shadow-hover">
                            <td class="p-2 text-center"><?= $counter; ?></td>
                            <td class="p-2"><?= $allorgs['org_name']; ?></td>
                            <td class="p-2"><?= $allorgs['org_status']; ?></td>
                            <td class="p-2 text-black">
                                <a class="text-decoration-none btn btn-primary view" data-id="<?= $allorgs['organization_id'] ?>">View</a>
                                <?php if($allorgs['org_status'] == 'Active') { ?>
                                    <a class="text-decoration-none btn btn-danger remove" data-id="<?= $allorgs['organization_id'] ?>">Remove</a>
                                <?php } else {?>
                                    <a class="btn btn-success activate" data-id="<?= $allorgs['organization_id'] ?>">Activate</a>
                                <?php }?>
                            </td>
                        </tr>
                        <?php
                        $counter++;
                    }
                ?>
                </tbody>
                <a id="add-organization" class="position-absolute d-flex align-items-center justify-content-between bg-crimson p-4 rounded-4 add-div text-decoration-none"
                    style=" bottom:10%; right:5%;">
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-plus fs-4 add"></i>
                    </div>
                    <div class="text-white fs-4 enroll">
                        Add Organization
                    </div>
                </a>
            </table>
        </div>
    </div>
</section>