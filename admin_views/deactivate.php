<?php
session_start();
require_once '../classes/admin.class.php';
require_once '../tools/clean.php';

$objOrg = new Admin;

$objOrg->deactivateOrg($_SESSION['organization_id']);
$_SESSION['organization_id'] = '';
?>