<?php
session_start();
$_SESSION['step'] = 1;
header('Location: profiling.php');
exit;
?>