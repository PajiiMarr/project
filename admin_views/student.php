<?php
session_start();

require_once '../admin/admin.class.php';
require_once '../utilities/clean.php';

$objAdmin = new Admin;

// Initialize the course_id, organization_id, student_search, and student_filter based on session or defaults
$course_id = isset($_SESSION['course_id']) ? clean_input($_SESSION['course_id']) : 1;
$organization_id = isset($_SESSION['organization_id']) ? clean_input($_SESSION['organization_id']) : 1;
$student_search = isset($_SESSION['student_search']) ? clean_input($_SESSION['student_search']) : '';
$student_filter = isset($_SESSION['student_filter']) ? clean_input($_SESSION['student_filter']) : '';

// Handle form submission to update session values
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['course_id'])) {
        $_SESSION['course_id'] = clean_input($_POST['course_id']);
        $course_id = $_SESSION['course_id'];
    }
    if (isset($_POST['organization_id'])) {
        $_SESSION['organization_id'] = clean_input($_POST['organization_id']);
        $organization_id = $_SESSION['organization_id'];
    }
    if (isset($_POST['student_search'])) {
        $_SESSION['student_search'] = clean_input($_POST['student_search']);
        $student_search = $_SESSION['student_search'];
    }
    if (isset($_POST['student_filter'])) {
        $_SESSION['student_filter'] = clean_input($_POST['student_filter']);
        $student_filter = $_SESSION['student_filter'];
    }

    $students = $objAdmin->viewStudents($course_id, $organization_id, $student_search, $student_filter);
} else {
    $students = $objAdmin->viewStudents($course_id, $organization_id);
}

$allOrgs = $objAdmin->allOrgs();
?>

<section class="container-fluid w-100 h-100">
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
                <form method="post" action="" class="p-2 d-flex align-items-center justify-content-between w-100">
                    <div class="w-18 d-flex align-items-center justify-content-around">
                        <label for="search">
                            <i class="fa-solid fa-magnifying-glass fs-4"></i>
                        </label>
                        <input class="p-2 w-75" type="text" name="student_search" id="search" placeholder="Search..." value="<?= $student_search ?>">
                    </div>

                    <div class="w-25 d-flex align-items-center justify-content-around">
                        <label for="student_filter">
                            <i class="fa-solid fa-filter fs-5"></i>
                        </label>
                        <select name="student_filter" id="student_filter" class="p-2">
                            <option value="" disabled <?= $student_filter == '' ? 'selected' : '' ?>>Default</option>
                            <option value="org_name" <?= $student_filter === 'org_name' ? 'selected' : '' ?>>By Organization</option>
                            <option value="status" <?= $student_filter === 'status' ? 'selected' : '' ?>>By Status</option>
                        </select>
                        <button type="submit" class="btn">Apply Filter</button>
                    </div>
                </form>
            </div>
            <form action="" method="post" class="d-flex w-50 pb-2">
                <?php
                    foreach($allOrgs as $orgs){
                        $buttonClass = ($organization_id == $orgs['organization_id']) ? 'bg-light-crimson text-white' : 'bg-transparent';
                ?>
                        <button type="submit" name="organization_id" value="<?= $orgs['organization_id']?>" class="rounded-3 p-2 ms-2 <?= $buttonClass ?>"><?= $orgs['org_name']?></button>
                <?php
                }
                ?>
            </form>
            <table class="max-h-100 w-100 table-hover position-relative">
                <tr class="bg-light-crimson">
                    <th class="fs-4 text-white p-2">No.</th>
                    <th class="fs-4 text-white p-2">Student</th>
                    <th class="fs-4 text-white p-2">Organization</th>
                    <th class="fs-4 text-white p-2">Status</th>
                    <th class="fs-4 text-white p-2">Action</th>
                </tr>
                <?php
                    if(empty($students)){
                ?>
                    <td colspan="5" class="text-center py-2 fw-bold fs-5">
                        No students found.
                    </td>
                <?php
                    } else {
                        $counter = 1;
                        foreach($students as $student){
                ?>
                            <tr class="border-bottom shadow-hover">
                                <td class="p-2"><?= $counter; ?></td>
                                <td class="p-2"><?= clean_input($student['last_name']) . ', ' . clean_input($student['first_name'])  . ' '. clean_input($student['middle_name']); ?></td>
                                <td class="p-2"><?= clean_input($student['org_name']);  ?></td>
                                <td class="p-2"><?= clean_input($student['status']); ?></td>
                                <td class="p-2"><?= clean_input($student['status']); ?></td>
                            </tr>
                <?php
                            $counter++;
                        }
                    }
                ?>
                <div class="position-absolute d-flex align-items-center justify-content-between bg-crimson p-4 rounded-4 add-div" style=" bottom:10%; right:5%;">
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-plus fs-4 add"></i>
                    </div>
                    <div class="text-white fs-4 enroll">
                        Enroll Students
                    </div>
                </div>
            </table>
        </div>
    </div>
</section>