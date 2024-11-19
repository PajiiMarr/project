<?php 
session_start();

if(empty($_SESSION['admin_id'])) header('Location: login_admin.php');
else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['facilitator_id'] == 1) {
        header('Location: ../facilitator/facilitator.php');
    } else {
        header('Location: ../student/student.php');
    }
    session_write_close();
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students | Admin
    </title>
    <?php require_once '../utilities/__link.php'; ?>
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../node_modules/datatables/css/dataTables.min.css">

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

        .add-div {
            position: absolute;
            bottom: 10%;
            right: 5%;
            border-radius: 1rem;
            cursor: pointer;
            transition: 0.1s ease-in-out;
            max-width: 50px; /* Default to small width */
        }

        .add-div:hover {
            max-width: 200px; /* Expand smoothly */
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
        }

        .add-div .enroll {
            display: none;
        }

        .add-div:hover .enroll {
            display: inline-block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</head>
<body>
    <header>
        <?php require_once '../utilities/__sidebar.php' ?>
    </header>
    <main class="container-page">
    </main>
    <?php require_once '../utilities/__scripts.php'; ?>
</body>
</html>