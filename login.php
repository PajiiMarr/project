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
}

if(isset($_SESSION['admin_id'])){
    header('location: admin/admin_home.php');
}


$objLogin = new Signup;

$email = $password = "";
$emailErr = $passwordErr = $incorrect_credentials = $show_ic = "";
$allinputsfield = true;

$email = $password = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = isset($_POST['email']) ? clean_input($_POST['email']) : "" ;
    $password = isset($_POST['password']) ? clean_input($_POST['password']) : "" ;

    if(empty($email)){
        $emailErr = " Email is required!";
        $allinputsfield = false;
    }
    if(empty($password)){
        $passwordErr = " Password is required!";
        $allinputsfield = false;
    }
    
    if($allinputsfield){
        $objLogin->login($email, $password);
        $incorrect_credentials = $_SESSION['incorrect_credentials'];
        $show_ic = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="allcss/login.css">
</head>
<body>
    <section>
        <form action="" method="post">
            <h1>Log in</h1>
            <div>
                Email <span class="required">* <?= $emailErr  ?></span><br>
                <input type="email" name="email" id="" value="<?= $email ?>">
            </div>
            <div>
                Password <span class="required">* <?= $passwordErr; ?></span><br>
                <div style="position: relative;">
                    <input type="password" name="password" id="admin_password" value="<?= $password ?>" style="width: 100%; padding-right: 30px;">
                    <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
            </div>
            <?php
            if($show_ic){
            ?>
            <span class="required"><?= $incorrect_credentials; ?></span>
            <?php
            }
            ?>
            <button type="submit">Submit</button>
        </form>
    </section>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('admin_password');
            const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', passwordFieldType);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>