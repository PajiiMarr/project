<?php
$page_title = "Organization";
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
    <script>
        function selectOrganization(orgId) {
            document.getElementById('hidden-org-id').value = orgId;
            document.getElementById('org-form').submit();
        }
    </script>
    <?php require_once '../utilities/__scripts.php'; ?> 
</body>
</html>