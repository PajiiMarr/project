<?php 
require_once 'admin.class.php';
require_once '../utilities/clean.php';

session_start();
if(empty($_SESSION['admin_id'])) header('Location: login_admin.php');
else if(empty($_SESSION['organization_id'])) header('location: admin_home.php');

$objAdmin = new Admin;

$organization_details = $objAdmin->orgDetails($_SESSION['organization_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $organization_details['org_name'];  ?> | Admin</title>
    <?php require_once '../utilities/__link.php'; ?>
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../allcss/admin_home.css">
    <style>
        .li-student {
            position: relative;
        }

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
        .li-student:hover .subheader-list {
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
    <main>
        <section class="container-fluid w-100 h-100">
            <div class="h-18 w-100 border-bottom">
                <div class="h-50 w-100 custom-border-bottom d-flex align-items-center justify-content-center">
                    <h1 class="ccs-green">College of Computing Studies</h1>
                </div>
                <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
                    <p class="text-secondary fs-5 m-0">Organization/Details</p>
                    <h2 class="m-0">Organization</h2>
                </div>
            </div>
            <div class="container-fluid h-80 w-100 py-5 px-5">
                <div class="h-100 w-100 shadow rounded-large overflow-scroll">
                    <div class="w-100 p-3 d-flex border-bottom align-items-center fs-4x">
                        <a href="admin_organization_overview.php" class="text-black me-3">
                            <i class="fa-solid fa-arrow-left fs-4"></i>
                        </a>
                        <?= $organization_details['org_name'] ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        function selectOrganization(orgId) {
            document.getElementById('hidden-org-id').value = orgId;
            document.getElementById('org-form').submit();
        }
    </script>
    <?php require_once '../utilities/__scripts.php'; ?>
</body>
</html>