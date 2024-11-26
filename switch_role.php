<?php
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_facilitator']) {
    // Redirect if not a facilitator
    header('Location: login.php');
    exit;
}

// Handle role selection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['role'])) {
        if ($_POST['role'] === 'facilitator') {
            header('Location: facilitator/dashboard.php');
        } elseif ($_POST['role'] === 'student') {
            header('Location: student/student.php');
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Switch Role</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="allcss/login.css">
</head>
<body>
    <section>
        <form action="" method="post">
            <h1>Login as:</h1>
            <div>
                <button type="submit" name="role" value="facilitator">Facilitator</button>
            </div>
            <div>
                <button type="submit" name="role" value="student">Student</button>
            </div>
        </form>
    </section>
</body>
</html>
