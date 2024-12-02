<?php
require_once '../utilities/clean.php';
require_once '../admin/admin.class.php';

$viewOrgs = new Admin();

$students = $viewOrgs->viewStudents();
$courses = $viewOrgs->viewCourse();
$organizations = $viewOrgs->allOrgsHeadAssigned();


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
                <div class="w-18 d-flex align-items-center justify-content-around">
                    <label for="search">
                        <i class="fa-solid fa-magnifying-glass fs-4"></i>
                    </label>
                    <input class="p-2 w-75" type="text" name="bsearch" id="search" placeholder="Search...">
                </div>
            </div>
            <div class="w-100 d-flex justify-content-between p-2">
                <select name="course" id="course" class="p-2 border rounded-3">
                    <option value="choose-course">Course</option>
                    <option value="">All</option>
                    <?php foreach($courses as $course):?>
                    <option value="<?= $course['course_code'] ?>"><?= $course['course_code'] ?></option>
                    <?php endforeach;?>
                </select>
            </div>




            <table id="table-student" class="max-h-100 w-100 table-hover position-relative">
                <thead>
                    <tr class="bg-light-crimson">
                        <th class="fs-4 text-white p-2 text-start" style="width: 5%;">No.</th>
                        <th class="fs-4 text-white p-2" style="width: 20%;">Student</th>
                        <th class="fs-4 text-white p-2" style="width: 8%;">Status</th>
                        <th class="fs-4 text-white p-2" style="width: 7%;">Course</th>
                        
                        <th class="fs-4 text-white p-2" style="width: 10%;">Section</th>
                        <th class="fs-4 text-white p-2" style="width: 15%;">Role</th>
                        <th class="fs-4 text-white p-2" style="width: 10%;">Year</th>
                        <th class="fs-4 text-white p-2" style="width: 45%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-2 fw-bold fs-5">No students found.</td>
                        </tr>
                    <?php else: ?>
                        <?php $counter = 1; ?>
                        <?php foreach ($students as $student): ?>
                            <?php
                            $has_no_heads = false;
                            foreach ($organizations as $org) {
                                if ($org['is_head'] == null) {
                                    $has_no_heads = true;
                                    break;
                                }
                            }

                            ?>
                            <tr class="border-bottom shadow-hover">
                                <td class="p-2 text-center"><?= $counter; ?></td>
                                <td class="p-2">
                                    <?= clean_input($student['last_name']) . ', ' . clean_input($student['first_name']) . ' ' . clean_input($student['middle_name']); ?>
                                </td>
                                <td class="p-2"><?= clean_input($student['status']); ?></td>
                                <td class="p-2"><?= clean_input($student['course_code']); ?></td>
                                <td class="p-2"><?= clean_input($student['course_section']); ?></td>
                                <td class="p-2">
                                    <?php 
                                    if(isset($student['is_head'])) {
                                        echo  "Head at " . $student['org_name']; 
                                    }
                                    else if(isset($student['is_assistant_head'])) {
                                        echo  "Assistant Head at " . $student['org_name']; 
                                    }
                                    else if(isset($student['is_collector'])) {
                                        echo  "Fee Collector Head at " . $student['org_name']; 
                                    } else {
                                        echo 'None';
                                    }
                                     ?>
                                </td>
                                <td class="p-2"><?= clean_input($student['course_year']); ?></td>
                                <td class="p-2 text-nowrap" style="height: 8vh;">
                                    <?php if($student['status'] == 'Enrolled'){ if (!empty($student['is_head'])){ ?>
                                        <a class="text-success text-decoration-none pt-3">Already Assigned</a>
                                        <a href="" data-id="<?= clean_input($student['student_id']); ?>" class="btn btn-warning resign-head" style="height: 3.6vh">Resign</a>
                                    <?php } else {?>
                                    <?php if ($has_no_heads){ ?>
                                        <a data-id="<?= $student['student_id'] ?>" class="btn btn-success assign-head">Assign as Head</a>
                                    <?php }} ?>
                                    <a data-id="<?= $student['student_id'] ?>" class="btn btn-primary edit-student">Edit</a>
                                    <a data-id="<?= $student['student_id'] ?>" class="btn btn-danger remove-student">Remove</a>
                                    <?php } else if ($student['status'] == 'Undefined') { ?>
                                        <a data-id="<?= $student['student_id'] ?>" class="btn btn-primary enroll-undefined-student">Enroll</a>
                                    <?php } else { ?>
                                    <p class="text-danger pt-3">Unable to do actions (<?= $student['status'] ?>). </p>
                                    <?php } ?> 
                                </td>
                            </tr>
                            <?php $counter++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>


        </div>
    </div>
</section>
