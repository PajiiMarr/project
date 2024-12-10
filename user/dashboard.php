<?php
$page_title = "Dashboard";
session_start(); 

if(empty($_SESSION['user'])){
    header('location: ../login.php');
}
?>
<?php require_once '../utilities/__head.php'; ?>
<body>
    <header>
        <?php require_once '../utilities/__sidebar.php' ?>
    </header>
    <main class="content-page">

    </main>

    <?php require_once '../utilities/__scripts.php'; ?>
</body>
</html>