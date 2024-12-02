<?php
session_start();
require_once '../utilities/signup.class.php';
require_once '../utilities/clean.php';

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
    }

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
            'course_section' => $isCourseIdSpecial ? $course_section : 'None'
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
        }
        echo json_encode(["status" => "success"]);
}
?>