<?php
session_start();
require_once '../classes/admin.class.php';
$objAdmin = new Admin;

if($_SERVER['REQUEST_METHOD'])
?>