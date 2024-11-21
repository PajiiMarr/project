<?php
session_start();
require_once 'utilities/signup.class.php';
require_once 'utilities/clean.php';

$objProfile = new Signup;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? clean_input($_POST['email']) : '';
    $password = isset($_POST['password']) ? clean_input($_POST['password']) : '';

    // $user_id = $_SESSION['user_id'];
    $last_name = isset($_POST['last_name']) ? clean_input($_POST['last_name']) : '';
    $first_name = isset($_POST['first_name']) ? clean_input($_POST['first_name']) : '';
    $middle_name = isset($_POST['middle_name']) ? clean_input($_POST['middle_name']) : '';
    $phone_number = isset($_POST['phone_number']) ? clean_input($_POST['phone_number']) : '';
    $course_id = isset($_POST['course_id']) ? clean_input($_POST['course_id']) : '';
    $course_year = isset($_POST['course_year']) ? clean_input($_POST['course_year']) : '';
    $course_section = isset($_POST['course_section']) ? clean_input($_POST['course_section']) : '';
    $dob = isset($_POST['dob']) ? clean_input($_POST['dob']) : '';
    $age = isset($_POST['age']) ? clean_input($_POST['age']) : '';
    $organization_id = isset($_POST['organization_id']) ? clean_input($_POST['organization_id']) : '';

    $errors = [];

    if (empty($email)) {
        $errors['email'] = 'Email is required!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format!';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required!';
    }
    
    if (empty($last_name)) {
        $errors['last_name'] = 'Last Name is required!';
    }
    if (empty($first_name)) {
        $errors['first_name'] = 'First Name is required!';
    }
    if (empty($course_id)) {
        $errors['course_id'] = 'Please select course enrolled in.';
    }
    if (empty($course_year)) {
        $errors['course_year'] = 'Please select course year.';
    }
    if (empty($phone_number)) {
        $errors['phone_number'] = 'Phone number is required!';
    }
    if (($course_id == 1 || $course_id == 2) && empty($course_section)) {
        $errors['course_section'] = 'Please select your section.';
    }
    if (empty($dob)) {
        $errors['dob'] = 'Date of Birth is required!';
    }
    if (empty($age)) {
        $errors['age'] = 'Age is required!';
    } else if (!is_numeric($age)) {
        $errors['age'] = 'Age must be a number!';
    } else if ($age < 15) {
        $errors['age'] = 'You should be at least 15 years old!';
    }

    if (!empty($errors)) {
        echo json_encode([
            "status" => "error",
            "errors" => $errors
        ]);
        exit;
    } else {

        $isCourseIdSpecial = ($course_id == 1 || $course_id == 2);
        $profileFields = [
            'course_id' => $course_id,
            'course_year' => $course_year,
            'last_name' => $last_name,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'phone_number' => $phone_number,
            'dob' => $dob,
            'age' => $age,
            'course_section' => $isCourseIdSpecial ? $course_section : null
        ];

        $result = $objProfile->sign_up_and_set_profile(
            $email,
            $password,
            $profileFields['course_id'],
            $profileFields['course_year'],
            $profileFields['last_name'],
            $profileFields['first_name'],
            $profileFields['middle_name'],
            $profileFields['phone_number'],
            $profileFields['dob'],
            $profileFields['age'],
            $profileFields['course_section']
        );
        if (isset($result['error'])) {
            echo json_encode([
                "status" => "error",
                "message" => $result['error']
            ]);
            exit;
        } else {
            echo json_encode(["status" => "success"]);
            exit;
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set up Profile</title>
    <link rel="stylesheet" href="allcss/profiling.css">
    <style>
        .setup_two {
            width: 50%;
            height: 70%;
        }
    </style>
    
</head>
<body>
    <section>

        <div class="setup_two">
            <form method="post">
                <a href="back_profiling.php">Back</a>
                <h1>Setup your profile as a: </h1>
                <div class="profile">
                    <h1>Student</h1>
                    <div>
                        Last Name <span class="required">* <?= $last_nameErr; ?></span><br>
                        <input type="text" name="last_name" id="last_name" value="<?= $last_name;?>">
                    </div>
                    <div>
                        First Name <span class="required">* <?= $first_nameErr;?></span><br>
                        <input type="text" name="first_name" id="middle_name" value="<?= $first_name; ?>">
                    </div>
                    <div>
                        Middle Name<br>
                        <input type="text" name="middle_name" id="middle_name" value="<?= $middle_name?>">
                    </div>
                    <div>
                        Phone number <span class="required">* <?= $phone_numberErr ?></span><br>
                        <input type="number" name="phone_number" id="phone_number" value="<?= $phone_number ?>">
                    </div>
                    <div class="data_row">
                        <div>
                            Course <span class="required">* <?= $course_idErr; ?></span><br>
                            <select name="course_id" id="course_id">
                                <option value="" selected disabled>--Select Course--</option>
                                <?php
                                    foreach($getCourse as $course): extract($course);
                                ?>
                                <option value="<?= $course_id; ?>"><?= $course_code ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </div>
                        <div>
                            Course Year <span class="required">* <?= $course_yearErr; ?></span><br>
                            <select name="course_year" id="course_year">
                                <option value="" selected disabled>--Select Year--</option>
                                <option value="First Year">First year</option>
                                <option value="Second Year">Second year</option>
                                <option value="Third Year" class="upper-year" style="display: none;">Third year</option>
                                <option value="Fourth Year" class="upper-year" style="display: none;">Fourth year</option>
                            </select>
                        </div>
                    </div>
                    <div class="data_row section">
                        <div>
                            Section <span class="required">* <?= $course_sectionErr ?></span><br>
                            <select name="course_section" id="course_section">
                                <option value="" selected disabled>--Select Section--</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="data_row">
                        <div>
                            Date of Birth <span class="required">* <?= $dobErr; ?></span>
                            <input type="date" name="dob" id="dob" value="<?= $dob; ?>"> 
                        </div>
                        <div>
                            Age <span class="required">* <?= $ageErr; ?></span>
                            <input type="number" name="" id="age" value="<?= $age; ?>" disabled>
                            <input type="hidden" name="age" id="hidden_age" value="<?= $age; ?>">
                        </div>
                    </div>
                    </div>
                    <button type="submit" name="get_started">
                        <span>Get Started</span>
                    </button>
            </form>
        </div>
    </section>
    <script src="scripts/profiling.js"></script>
</body>
</html>
