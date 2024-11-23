<?php
session_start();

require_once '../admin/admin.class.php';
require_once '../utilities/clean.php';

$objAdmin = new Admin;

// Initialize the course_id, organization_id, student_search, and student_filter based on session or defaults
$course_id = isset($_SESSION['course_id']) ? clean_input($_SESSION['course_id']) : 1;
$organization_id = isset($_SESSION['organization_id']) ? clean_input($_SESSION['organization_id']) : 1;

// Handle form submission to update session values
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['course_id'])) {
        $_SESSION['course_id'] = clean_input($_POST['course_id']);
        $course_id = $_SESSION['course_id'];
    }
    if (isset($_POST['organization_id'])) {
        $_SESSION['organization_id'] = clean_input($_POST['organization_id']);
        $organization_id = $_SESSION['organization_id'];
    }
    $students = $objAdmin->viewStudents($course_id, $organization_id);
} else {
    $students = $objAdmin->viewStudents($course_id, $organization_id);
}

$allOrgs = $objAdmin->allOrgs();

?>