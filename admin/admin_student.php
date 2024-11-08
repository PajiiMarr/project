<?php 
session_start();

require_once 'admin.class.php';
require_once '../utilities/clean.php';

if(empty($_SESSION['admin_id'])) header('Location: login_admin.php');

$objAdmin = new Admin;

$course_id = '';
$students = [];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
    $course_id = clean_input($_POST['course_id']);
    $students = $objAdmin->viewStudents($course_id);
}

$student_search = $student_filter = '';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Home</title>
    <?php require_once '../utilities/__link.php'; ?>
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../allcss/admin_home.css">
    <style>
        .subheader-list {
            display: block;
            opacity: 0;
            visibility: hidden;
            top: 0; /* Aligns to the right of the "Students" */
            left: 100%; /* Positioning list to the right side */
            z-index: 1;
            transition: 0.1s ease-in-out;
            background: white; /* Add background to separate it visually */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }

        /* Show subheader list on hover */
        li:hover .subheader-list {
            visibility: visible;
            opacity: 1;
        }

        /* Optional: Styling for subheaders */
        .subheader-list button {
            padding: 10px;
            font-size: 1rem;
            background-color: #DC143C; /* crimson */
            color: white;
            transition: 0.15s ease-in-out;

        }

        .subheader-list button:hover {
            background-color: #C00; /* Darker crimson on hover */
        }

        button {
            border: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="admin-icon  d-flex flex-column justify-content-center align-items-center">
            <i class="fa-regular fa-circle-user icon-size crimson py-3"></i>
            <h2>Admin</h2>
        </div>
        <div class="admin-nav d-flex flex-column justify-content-between">
            <div class="an-child h-35 w-100 d-flex flex-column">
                <nav class="h-100 w-100">
                    <ul class="list-unstyled h-100 w-100 d-flex flex-column justify-content-center align-items-center">
                        <li class="w-100 h-25 li-unselected px-2">
                            <a href="admin_home.php" class="d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                                <i class="fa-solid fa-people-group w-25 fs-4"></i>
                                <p class="w-75 fs-5 pt-3">Organizations</p>
                            </a>
                        </li>
                        <li class="w-100 h-25 px-2 bg-crimson position-relative">
                            <a href="" class="d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none text-white px-3">
                                <i class="fa-regular fa-user w-25 mt-1 fs-4"></i>
                                <p class="w-75 fs-5 pt-3">Students</p>
                            </a>
                            <!-- Submenu for subheaders -->
                            <form class="subheader-list list-unstyled position-absolute w-100 text-center" method="POST">
                            <button type="submit" name="course_id" value="1" class="text-white text-decoration-none d-block p-2 w-100 border-none">BSIT</button>
                                <button type="submit" name="course_id" value="2" class="text-white text-decoration-none d-block p-2 w-100 border-none">BSCS</button>
                                <button type="submit" name="course_id" value="3" class="text-white text-decoration-none d-block p-2 w-100 border-none">ACT AD</button>
                                <button type="submit" name="course_id" value="4" class="text-white text-decoration-none d-block p-2 w-100 border-none">ACT NT</button>
                            </form>
                        </li>
                        <li class="w-100 h-25 li-unselected px-2">
                            <a href="#" class="d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                                <i class="fa-solid fa-people-group w-25 fs-4"></i>
                                <p class="w-75 fs-5 pt-3">Payment History</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="an-child h-25 w-100 p-2 d-flex flex-column justify-content-center align-items-center">
                <a href="" class="btn w-100 h-20 my-2 py-4 bg-crimson d-flex">
                    <div class="w-25 h-100 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-money-bill fs-4"></i>
                    </div>
                    <div class="w-75 h-100 d-flex align-items-center justify-content-start">
                        <p class="fs-5 mb-0">Create Payment</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="sign-out d-flex justify-content-end align-items-center">
            <a href="admin_logout.php" class="w-50 crimson text-decoration-none d-flex">
                <i class="fa-solid fa-arrow-right-from-bracket w-25 fs-5 mt-1"></i>
                <div class="w-75 h-100 d-flex align-items-center">
                    <p class="fs-5">Sign Out</p>
                </div>
                
            </a>
        </div>
    </header>
    <main>
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
                                <input class="p-2 w-75" type="text" name="search" id="search" placeholder="Search..." value="<?= $student_search ?>">
                            </div>
                         
                            <div class="w-25 d-flex align-items-center justify-content-around">
                                <label for="student_filter">
                                    <i class="fa-solid fa-filter fs-5"></i>
                                </label>
                                <select name="student_filter" id="student_filter" class="p-2">
                                    <option value="" disabled>Filter</option>
                                    <option value="last_name" <?= $student_filter === 'last_name' ? 'selected' : '' ?>>By Student Name</option>
                                    <option value="org_name" <?= $student_filter === 'org_name' ? 'selected' : '' ?>>By Organization</option>
                                    <option value="status" <?= $student_filter === 'status' ? 'selected' : '' ?>>By Status</option>
                                </select>
                                <button type="submit" class="btn">Apply Filter</button>
                            </div>
                            
                        </form>
                    </div>

                    <table class="max-h-100 w-100 table-hover">
                        <tr class="bg-light-crimson">
                            <th class="fs-4 text-white p-2">Student</th>
                            <th class="fs-4 text-white p-2">Organization</th>
                            <th class="fs-4 text-white p-2">Status</th>
                            <th class="fs-4 text-white p-2">Action</th>
                        </tr>
                        <?php
                            if(empty($students)){
                        ?>
                            <td colspan="4" class="text-center">
                                No students found!
                            </td>
                        <?php
                            } else {
                                $counter = 1;
                                foreach($students as $student){
                        ?>
                                    <tr class="border-bottom shadow-hover">
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
                    </table>
                </div>
            </div>
        </section>
    </main>
    <?php require_once '../utilities/__scripts.php'; ?>
</body>
</html>