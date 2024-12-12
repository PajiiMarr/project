<?php require_once '../classes/facilitator.class.php';
if($_SESSION['user']['is_facilitator'] == 1){
$objFaci = new Facilitator;
$facilitator = $objFaci->facilitator_details($_SESSION['user']['user_id']); 
var_dump($_GET['request_uri']);
} ?>
<script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../node_modules/jquery-3.7.1/jquery-3.7.1.min.js"></script>
<script src="../node_modules/datatables/js/dataTables.min.js"></script>
<script src="../scripts/request_uri.js"></script>
<?php if($_SESSION['user']['is_admin'] == 1){ ?>
<script src="../scripts/admin.js"></script>
<?php } ?>
<?php if($_SESSION['user']['is_facilitator'] == 1 && $facilitator['org_status'] == 'Active'){ ?>
<script src="../scripts/facilitator.js"></script>
<?php } ?>
<?php if(($_SESSION['user']['is_facilitator'] == 1 && $facilitator['org_status'] == 'Active') || $_SESSION['user']['is_student'] == 1){ ?>
<script src="../scripts/student.js"></script>
<?php } ?>