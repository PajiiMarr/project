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
} else if(empty($_SESSION['user_id']) && (!isset($_SESSION['step']) || $_SESSION['step'] != 1)){
?>
    <section>
        <h1>You should sign up first!</h1>
        <p>Redirecting you to sign up page</p>
    </section>
    <?php
    header('refresh: 2; url=signup.php');
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="allcss/profiling.css">
</head>
<body>
        <?php
        require_once 'utilities/signup.class.php';
        require_once 'utilities/clean.php';
        

        $roleObj = new Signup;

        $choiceErr = '';
        $choiceField = true;

            

        $is_student = $is_facilitator = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $is_student = isset($_POST['is_student']) ? clean_input($_POST['is_student']) : 0 ;
            $is_facilitator = isset($_POST['is_facilitator']) ? clean_input($_POST['is_facilitator']) : 0;

            $_SESSION['user_type'] = [
                'is_student' => $is_student,
                'is_facilitator' => $is_facilitator
            ];

            $_SESSION['step'] = 2;

            var_dump($_SESSION['user_type']);
            if(empty($is_student) && empty($is_facilitator)){
                $choiceErr = 'Choose at least one!';
                $choiceField = false;
            }
            
            if($choiceField){
                $roleObj->update_user_type($is_student, $is_facilitator, $_SESSION['user_id']);
                header('Location: profiling_two.php');
                exit();
            }
        }
        ?>



    
    <section>
        <div class="setup">
            <form method="POST">
                <h1>What type of user are you?</h1>
                <div class="option">
                    <div class="input" onclick="toggleCheckbox(this)">
                        <input type="checkbox" name="is_student" value="1" id="studentCheckbox">
                        <label for="studentCheckbox">Student</label>
                    </div>

                    <div class="input" onclick="toggleCheckbox(this)">
                        <input type="checkbox" name="is_facilitator" value="1" id="facilitatorCheckbox">
                        <label for="facilitatorCheckbox">Facilitator</label>
                    </div>
                </div>
                <span class="error"><?= $choiceErr; ?></span>
                <p class="note">Note: The Student will automatically selected if you are a Facilitator (You will not be able to unselect the Student unless you will unselect the Facilitator first). </p>
                <button type="submit" name="next">
                    <span>Next</span>
                </button>
            </form>
            
        </div>
    </section>
    <script src='scripts/profiling.js'></script>
</body>
</html>
