<?php 
session_start();
if(empty($_SESSION['admin_id'])) header('Location: login_admin.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Home</title>
    <?php require_once '../utilities/__link.php'; ?>
    <link rel="stylesheet" href="../allcss/admin_home.css">
</head>
<body>
    <header class="container-fluid">
        <div class="container_fluid d-flex align-items-center h-100 w-50 px-2">
            <h1>CCS Organizational Payment Management System</h1>
        </div>
        
    </header>
    <main>
        <section>
            <div class="s-child one">
                
            </div>
            <div class="s-child two">

            </div>
        </section>
    </main>
    <?php require_once '../utilities/__scripts.php'; ?>
</body>
</html>