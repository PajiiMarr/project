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
                Password <span class="required">* <?= $passwordErr ?></span><br>
                <input type="password" name="password" id="password" value="<?= $password ?>">
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
</body>
</html>