<?php
require_once '../utilities/clean.php';
require_once '../admin/admin.class.php';

$viewOrgs = new Admin;

$viewOrgs = new Admin;

$course_id = isset($_GET['course_id']) ? clean_input($_GET['course_id']) : 1;
$organization_id = isset($_GET['organization_id']) ? clean_input($_GET['organization_id']) : 1;

// Handle form submission to update session values
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['course_id'])) {
        $_SESSION['course_id'] = clean_input($_GET['course_id']);
        $course_id = $_SESSION['course_id'];
    }
    if (isset($_GET['organization_id'])) {
        $_SESSION['organization_id'] = clean_input($_GET['organization_id']);
        $organization_id = $_SESSION['organization_id'];
    }
    $students = $viewOrgs->viewStudents($course_id, $organization_id);
} else {
    $students = $viewOrgs->viewStudents($course_id, $organization_id);
}


$allOrgs = $viewOrgs->allOrgs();
?>

<section class="container-fluid w-100 h-100">
    <div class="modal-container"></div>
    <div class="h-18 w-100 border-bottom">
        <div class="h-50 w-100 custom-border-bottom d-flex align-items-center justify-content-center">
            <h1 class="ccs-green">College of Computing Studies</h1>
        </div>
        <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
            <p class="text-secondary fs-5 m-0">Student/Overview</p>
            <h2 class="m-0">Student</h2>
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
            <form class="form-selector d-flex w-50 pb-2">
                <?php foreach ($allOrgs as $orgs): ?>
                    <label class="radio-label rounded-3 p-2 ms-2 <?= ($organization_id == $orgs['organization_id']) ? 'selected' : '' ?>">
                        <input type="radio" name="organization_id" value="<?= $orgs['organization_id'] ?>" <?= ($organization_id == $orgs['organization_id']) ? 'checked' : '' ?> style="display:none;">
                        <?= $orgs['org_name'] ?>
                    </label>
                <?php endforeach; ?>
            </form>

            <table id="table-student" class="max-h-100 w-100 table-hover position-relative">
                <thead>
                    <tr class="bg-light-crimson">
                        <th class="fs-4 text-white p-2">No.</th>
                        <th class="fs-4 text-white p-2">Student</th>
                        <th class="fs-4 text-white p-2">Organization</th>
                        <th class="fs-4 text-white p-2">Status</th>
                        <th class="fs-4 text-white p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-2 fw-bold fs-5">No students found.</td>
                        </tr>
                    <?php else: ?>
                        <?php $counter = 1; ?>
                        <?php foreach ($students as $student): ?>
                            <tr class="border-bottom shadow-hover">
                                <td class="p-2"><?= $counter; ?></td>
                                <td class="p-2">
                                    <?= clean_input($student['last_name']) . ', ' . clean_input($student['first_name']) . ' ' . clean_input($student['middle_name']); ?>
                                </td>
                                <td class="p-2"><?= clean_input($student['org_name']); ?></td>
                                <td class="p-2"><?= clean_input($student['payment_status']); ?></td>
                                <td class="p-2">
                                    <a href="#">hello</a>
                                </td>
                            </tr>
                            <?php $counter++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <a id="enroll-student" class="position-absolute d-flex align-items-center justify-content-between bg-crimson p-4 rounded-4 add-div text-decoration-none" style="bottom:10%; right:5%;">
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-plus fs-4 add"></i>
                </div>
                <div class="text-white fs-4 enroll">
                    Enroll Students
                </div>
            </a>
        </div>
    </div>
</section>