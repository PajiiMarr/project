<?php
session_start();
require_once 'utilities/signup.class.php';
require_once 'utilities/clean.php';

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['facilitator_id'] == 1) {
        header('Location: facilitator.php');
    } else {
        header('Location: student.php');
    }
    session_write_close();
    exit;
} else if(empty($_SESSION['user_id']) && (!isset($_SESSION['step']) || $_SESSION['step'] != 2)){
?>
    <section>
        <h1>You should sign up first!</h1>
        <p>Redirecting you to sign up page</p>
    </section>
    <?php
    header('refresh: 2; url=signup.php');
} 

$objProfile = new Signup;
$getOrganization = $objProfile->getOrganization();
$getCourse = $objProfile->getCourse();

$last_name = $first_name = $middle_name = $course_id = $course_year = $course_section = $dob = $age = $organization_id = $phone_number = '';
$last_nameErr = $first_nameErr = $course_idErr = $course_yearErr = $course_sectionErr = $dobErr = $ageErr = $organization_idErr = $overallErr = $phone_numberErr = '';
$allinputsfield = true;


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id = $_SESSION['user_id'];
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

    if($_SESSION['user_type']['is_facilitator'] == 1) {
        $_SESSION['profile']['organization_id'] = $organization_id;
        if(empty($organization_id)){
            $organization_idErr = ' Please select organization you joined.';
            $allinputsfield = false;
        }
    }

    if(empty($last_name)){
        $last_nameErr = ' Last Name is required!';
        $allinputsfield = false;
    }
    if(empty($first_name)){
        $first_nameErr = ' First Name is required!';
        $allinputsfield = false;
    }
    if(empty($course_id)){
        $course_idErr = ' Please select course enrolled in.';
        $allinputsfield = false;
    }
    if(empty($course_year)){
        $course_yearErr = ' Please select course year.';
        $allinputsfield = false;
    }
    if(empty($phone_number)){
        $phone_numberErr = ' Phone number is required!';
        $allinputsfield = false;
    }
    if($course_id == 1 || $course_id == 2){
        if(empty($course_section)){
            $course_sectionErr = ' Please select your section.';
            $allinputsfield = false;
        }
    }
    if(empty($dob)){
        $dobErr = ' Date of Birth is required!';
        $allinputsfield = false;
    }
    if(empty($age)){
        $ageErr = ' Age is required!';
        $allinputsfield = false;
    } else if ($age < 15) {
        $ageErr = ' You should be at least 15 years old!';
        $allinputsfield = false;
    }

    if($allinputsfield){
        $isCourseIdSpecial = ($course_id == 1 || $course_id == 2);
        $profileFields = [
            'user_id' => $user_id,
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
    
        if($objProfile->duplicate_record_exists('student', ['student_id' => $user_id])){
            $overallErr = 'Duplicate profile exist';
        } else {
            $objProfile->set_profile(
                $profileFields['user_id'],
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
    
            if($_SESSION['user_type']['is_facilitator'] == 0){
                $_SESSION['step'] = 0;
                header('Location: student.php');
                exit();
            }
        }
        if($_SESSION['user_type']['is_facilitator'] == 1){
            if($objProfile->duplicate_record_exists('facilitator', ['facilitator_id' => $user_id])){
                $overallErr = 'Duplicate profile exist';
            } else {
                $objProfile->set_facilitator(
                    $profileFields['user_id'],
                    $organization_id,
                    $profileFields['course_id'],
                    $profileFields['last_name'],
                    $profileFields['first_name'],
                    $profileFields['middle_name'],
                    $profileFields['phone_number'],
                    $profileFields['dob'],
                    $profileFields['age'],
                    $profileFields['course_year'],
                    $isCourseIdSpecial ? $profileFields['course_section'] : null
                );
    
                $_SESSION['step'] = 0;
                header('Location: facilitator.php');
                exit();
            }
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
                    <?php if($_SESSION['user_type']['is_facilitator'] == 1){ ?>
                    <h1>Facilitator</h1>
                    <div>
                        Organization <span class="required">* <?= $organization_idErr; ?></span><br>
                        <select name="organization_id" id="organization_id">
                            <option value="" selected disabled></option>
                            <?php foreach($getOrganization as $org): extract($org); ?>
                                <option value="<?=$organization_id?>"><?= $org_name;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php }?>
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
