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
$emailErr = $passwordErr = "";
$allinputsfield = true;

$email = $password = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = isset($_POST['email']) ? clean_input($_POST['email']) : "" ;
    $password = isset($_POST['password']) ? clean_input($_POST['password']) : "" ;

    if(empty($email)){
        $emailErr = " Email is required!";
    }
    if(empty($password)){
        $passwordErr = " Password is required!";
    }
    
    if($allinputsfield){
        $objLogin->login($email, $password);
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
                Email <span class="required">* <?php  ?></span><br>
                <input type="email" name="email" id="">
            </div>
            <div>
                Password <span class="required">* <?php ?></span><br>
                <input type="password" name="password" id="password">
            </div>
            <a href="signup.php">Don't have an account?</a>
            <button type="submit">Submit</button>
        </form>
    </section>
</body>
</html>