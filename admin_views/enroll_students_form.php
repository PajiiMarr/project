<?php
require_once '../utilities/signup.class.php';
$objForm = new Signup;

$getCourse = $objForm->getCourse();
$password = "temp_2020";

?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Enroll Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 
        <form action="" method="post" id="form-enroll-student">
            <div class="modal-body">
                <div class="mb-2">
                    <label for="code" class="form-label">email</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <div class="invalid-feedback"></div>
                </div>
            
                <div class="mb-2">
                    <label for="name" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" value="<?= $password ?>">
                    <div class="invalid-feedback"></div>
                </div>
            
                <div class="mb-2">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" id="middle_name">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="number" class="form-control" name="phone_number" id="phone_number">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="course_id" class="form-label">Course</label>
                    <select class="form-select" name="course_id" id="course_id">
                        <option value="" selected disabled>--Select Course--</option>
                        <?php foreach ($getCourse as $course): extract($course); ?>
                            <option value="<?= $course_id; ?>"><?= $course_code; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="course_year" class="form-label">Course Year</label>
                    <select class="form-select" name="course_year" id="course_year">
                        <option value="" selected disabled>--Select Year--</option>
                        <option value="First Year">First Year</option>
                        <option value="Second Year">Second Year</option>
                        <option value="Third Year" class="upper-year" style="display: none;">Third Year</option>
                        <option value="Fourth Year" class="upper-year" style="display: none;">Fourth Year</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="course_section" class="form-label">Section</label>
                    <select class="form-select" name="course_section" id="course_section">
                        <option value="" selected disabled>--Select Section--</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-2">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" value="" disabled>
                    <input type="hidden" name="age" id="hidden_age">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary brand-bg-color">Save Product</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <script src="../scripts/profiling.js"></script>