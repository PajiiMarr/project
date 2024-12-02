<?php
require_once '../admin/admin.class.php';
$objForm = new Admin;
$edit_student = $objForm->view_edit_student($_GET['student-id']);
$getCourse = $objForm->viewCourse();
?>
<div class="modal fade" id="editStudent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 
        <form method="POST" id="form-edit-student">
            <div class="modal-body">
                <div class="mb-2">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $edit_student['last_name'] ?>">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $edit_student['first_name'] ?>">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" id="middle_name" value="<?= $edit_student['middle_name'] ?>">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="number" class="form-control" name="phone_number" id="phone_number" value="<?= $edit_student['phone_number'] ?>">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="course_id" class="form-label">Course</label>
                    <select class="form-select" name="course_id" id="course_id">
                        <option value="" selected disabled>--Select Course--</option>
                        <?php foreach ($getCourse as $course): extract($course); ?>
                            <option value="<?= $course_id; ?>" <?= $edit_student['course_id'] == $course_id ? 'selected' : '' ; ?>><?= $course_code; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="course_year" class="form-label">Course Year</label>
                    <select class="form-select" name="course_year" id="course_year">
                        <option value="" selected disabled>--Select Year--</option>
                        <option value="First Year" <?= $edit_student['course_year'] == "First Year" ? 'selected' : '' ; ?>>First Year</option>
                        <option value="Second Year" <?= $edit_student['course_year'] == "Second Year" ? 'selected' : '' ; ?>>Second Year</option>
                        <option value="Third Year" class="upper-year" style="display: none;" <?= $edit_student['course_year'] == "Third Year" ? 'selected' : '' ; ?>>Third Year</option>
                        <option value="Fourth Year" class="upper-year" style="display: none;" <?= $edit_student['course_year'] == "Fourth Year" ? 'selected' : '' ; ?>>Fourth Year</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="course_section" class="form-label">Section</label>
                    <select class="form-select" name="course_section" id="course_section">
                        <option value="" selected disabled>--Select Section--</option>
                        <option value="A" <?= $edit_student['course_section'] == "A" ? 'selected' : '' ; ?>>A</option>
                        <option value="B" <?= $edit_student['course_section'] == "B" ? 'selected' : '' ; ?>>B</option>
                        <option value="C" <?= $edit_student['course_section'] == "C" ? 'selected' : '' ; ?>>C</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" value="<?= $edit_student['dob'] ?>">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" value="<?= $edit_student['age'] ?>" disabled>
                    <input type="hidden" name="age" id="hidden_age">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary brand-bg-color">Enroll Student</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    let selectedCourseId = document.getElementById('course_id');
    let courseYear = document.getElementById('course_year');
    let upperYears = document.querySelectorAll('.upper-year');
    var section = document.getElementById('course_section');

    if (selectedCourseId) {
        courseYear.disabled = false;
    } else {
        courseYear.disabled = true;
    }

    if (selectedCourseId == 1 || selectedCourseId == 2) {
        upperYears.forEach(option => option.style.display = 'block');
        section.style.display = "block";
    } else {
        upperYears.forEach(option => option.style.display = 'none');
        courseYear.value = "";
        section.style.display = "none";
    }
  </script>
  <script src="../scripts/profiling.js"></script>