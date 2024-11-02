<?php
session_start();
require_once 'admin.class.php'; 
$adminobj = new Admin;

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['facilitator_id'] == 1) {
        header('Location: ../facilitator.php');
    } else {
        header('Location: ../student.php');
    }
    session_write_close();
    exit;
}

if(isset($_SESSION['admin_id'])){
    header('Location: admin_home.php');
}

$admin_username = $admin_password = '';
$admin_usernameErr = $admin_passwordErr = $overallErr = '';
$allinputsfield = true;


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $admin_username = isset($_POST['admin_username']) ? $_POST['admin_username'] : '' ;
    $admin_password = isset($_POST['admin_password']) ? $_POST['admin_password'] : '' ;

    if(empty($admin_username)){
        $admin_usernameErr = ' Username is required!';
        $allinputsfield = false;
    }

    if(empty($admin_password)){
        $admin_passwordErr = ' Password is required!';
        $allinputsfield = false;
    }

    if($allinputsfield){
        $adminobj->login($admin_username, $admin_password);
        $overallErr = $_SESSION['incorrect_credentials'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Login</title>
    <link rel="stylesheet" href="../allcss/admin_login.css">
</head>
<body>
    <section>
        <div class='child'>
            <form action="" method="post">
                <h1>Admin Login</h1>
                <div class="input">
                    Username <span class="required">* <?= $admin_usernameErr; ?></span><br>
                    <input type="text" name="admin_username" id="admin_username" value="<?= $admin_username ?>">
                </div>
                <div class="input">
                    Password <span class="required">* <?= $admin_passwordErr; ?></span><br>
                    <input type="password" name="admin_password" id="admin_password" value="<?= $admin_password  ?>">
                </div>
                <span class="required"><?= $overallErr; ?></span>
                <input type="submit" value="Log in">
            </form>
        </div>
    </section>
</body>
</html>