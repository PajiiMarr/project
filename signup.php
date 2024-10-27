<?php
    session_start();
    if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['facilitator_id'] == 1) {
            header('Location: facilitator.php');
        } else {
            header('Location: student.php');
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="allcss/signup.css">
</head>
<body>
    <main class="container">
        <section>
            <?php
                require_once 'utilities/signup.class.php';
                require_once 'utilities/clean.php';

                $signupObj = new Signup;

                $email = $password = $confirm = "";
                $emailErr = $passwordErr = $confirmErr = $overallErr = "";
                $allinputsfield = true;
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $email = clean_input($_POST['email']);
                    $password = clean_input($_POST['password']);
                    $confirm = clean_input($_POST['confirm']);
                    
                    $_SESSION['step'] = 1;

                    if(empty($email)){
                        $emailErr = ' Email is required!';
                        $allinputsfield = false;
                    }

                    if(empty($password)){
                        $passwordErr = ' Password is required!';
                        $allinputsfield = false;
                    }

                    if(empty($confirm)){
                        $confirmErr = ' Confirm Password is required!';
                        $allinputsfield = false;
                    } else if ($confirm != $password){
                        $confirmErr = ' Password does not match!';
                        $allinputsfield = false;
                    }

                    if($allinputsfield){
                        if($signupObj->sign_up($email, $password) == false){
                            $overallErr = ' Email exist!';
                        } else {
                            $signupObj->sign_up($email, $password);
                        }
                    }
                }
            ?>
            <div class="setup">
                <form method="post">
                    <h1>Create Account</h1>
                    <span><?= $overallErr ?></span>
                    <input type="email" name="email" id="email" placeholder="Email" value="<?= $email ?>">
                    <span class="error"> <?= $emailErr; ?></span>
                    <input type="password" name="password" id="password" placeholder="Password" value="<?= $password ?>">
                    <span class="error"> <?= $passwordErr; ?></span>
                    <input type="password" name="confirm" id="confirm" placeholder="Confirm Password" value="<?= $confirm ?>">
                    <span class="error"> <?= $confirmErr; ?></span>
                    <a href="login.php">Already have an account?</a>
                    <button type="submit" name="submit">
                        <span>
                            Next
                        </span>
                    </button>
                </form>
            </div>
        </section>  
    </main>
    <script src="sripts/signup.js"></script>
</body>
</html>