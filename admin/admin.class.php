<?php
require_once '../utilities/database.class.php';
class Admin {
    private $conn;

    function __construct(){
        $db = new Database;
        $this->conn = $db->connect();
    }

    function login($username, $password){
        $sql = 'SELECT * FROM admin WHERE admin_username = :username';
        $query = $this->conn->prepare($sql);

        $query->bindparam(':username', $username);
        $query->execute();

        $admin = $query->fetch();

        if($admin && password_verify($password, $admin['admin_password'])){
            $_SESSION['admin_id'] = $admin['admin_id'];
            $sql_date_updated = 'UPDATE admin SET date_updated = CURRENT_TIMESTAMP';
            $query_date_updated = $this->conn->prepare($sql_date_updated);
            $query_date_updated->execute();

            header('Location: admin_home.php');
            exit;
        } else {
            $_SESSION['incorrect_credentials'] = 'Incorrect Credentials';
        }
    }

    function viewOrgs(){
        $sql = 'SELECT * FROM organization;';
        $query = $this->conn->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            return false;
        }
        return $data;
    }

    function orgDetails($organization_id){
        $sql = 'SELECT * FROM organization WHERE organization_id = :organization_id;';
        $query = $this->conn->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            return false;
        }
        return $data;
    }

    function viewStudents($organization_id, $payment_status){
        $sql = 'SELECT student.*, payment.payment_status, payment.semester, organization.org_name
                FROM payment 
                JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id
                JOIN student ON student_organization.student_id = student.student_id
                JOIN organization ON student_organization.organization_id = organization.organization_id
                WHERE organizaion.organization_id = :organization_id AND payment.payment_status = :payment_status
                ORDER BY student.last_name ASC;';
        $query = $this->conn->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll();
            return $data;
        } else {
            return null;
        }
    }

    function updatePayment($payment_id){
        $sql = "UPDATE payment SET payment_status = 'Paid', date_of_payment = NOW(), admin_id = 1 WHERE payment_id = :payment_id";
        $query = $this->conn->prepare($sql);      
        $query->bindParam(':payment_id', $payment_id);
        if($query->execute()){
            return true;
        } else{
            return false;
        }
    }

    function paymentHistory($from_date, $to_date, $organization_id, $status){
        $sql = "SELECT payment.*, organization.org_name, student.last_name, student.first_name
                FROM payment
                JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id
                JOIN organization ON student_organization.organization_id = organization.organization_id
                JOIN student ON student_organization.student_id = student.student_id
                WHERE payment.date_of_payment BETWEEN :from_date AND :to_date
                AND organization.organization_id = :organization_id
                AND payment.payment_status = :status;";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':from_date', $from_date);
        $query->bindParam(':to_date', $to_date);
        $query->bindParam(':organization_id', $organization_id);
        $query->bindParam(':status', $status);

        if($query->execute()){
            $data = $query->fetchAll();
            return $data;
        } else {
            return null;
        }
    }

    function reports(){
        $sql = "SELECT organization.org_name, COUNT(payment.payment_id) AS total_payments, SUM(CASE WHEN payment.payment_status = 'Paid' THEN 1 ELSE 0 END) AS paid_payments
                FROM organization
                JOIN student_organization ON organization.organization_id = student_organization.organization_id
                JOIN payment ON student_organization.stud_org_id = payment.student_org_id
                GROUP BY organization.org_name;";
        $query = $this->conn->prepare($sql);
        if($query->execute()){
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function allStudents(){
        $sql = 'SELECT * FROM students';
        $query = $this->conn->prepare($sql);
        if($query->execute()){
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function addOrganization($org_name, $org_description){
        $sql = "INSERT INTO organization(org_name, org_description, created_date)
                VALUES(:org_name, :org_description, NOW());";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':org_name', $org_name);
        $query->bindParam(':org_description', $org_description);

        $query->execute();
        $organization_id = $this->conn->lastInsertId();

        $allstudents = $this->allStudents();
        foreach($allstudents as $as){
            $sql_add_stud_org = "INSERT INTO student_organization(student_id, organization_id)
                                 VALUES(:student_id, :organization_id);";
            $query_add_stud_org = $this->conn->prepare($sql_add_stud_org);
            $query_add_stud_org->bindParam(':student_id', $as['student_id']);
            $query_add_stud_org->bindParam(':organization_id', $organization_id);
            $query_add_stud_org->execute();
        }
    }

    function removeOrganization($organization_id){
        $sql = "UPDATE organization
                SET status = 'Inactive'
                WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':organization_id', $organization_id);
        $query->execute();
    }
}
?>