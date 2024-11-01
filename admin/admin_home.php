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
    <link rel="stylesheet" href="../allcss/admin_home.css">
</head>
<body>
    <header>
        <h1>CCS Organizational Payment Management System</h1>
    </header>
    <main>
        <section>
            <div class="s-child one">
                
            </div>
            <div class="s-child two">

            </div>
        </section>
    </main>
</body>
</html>