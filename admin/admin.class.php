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

            header('Location: dashboard.php');
            exit;
        } else {
            $_SESSION['incorrect_credentials'] = 'Incorrect Credentials';
        }
    }

    function orgDetails($organization_id){
        $sql = 'SELECT * FROM organization WHERE organization_id = :organization_id;';
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        if($query->execute()){
            $data = $query->fetch();
        } else {
            return false;
        }
        return $data;
    }

    function viewStudents($course_id, $organization_id ='', $student_search = '', $student_filter = '') {
        $sql = 'SELECT student.*, organization.org_name, payment.*
                FROM payment 
                JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id 
                JOIN student ON student_organization.student_id = student.student_id 
                JOIN organization ON student_organization.organization_id = organization.organization_id
                WHERE student.course_id = :course_id AND organization.organization_id = :organization_id';
    
        if (!empty($student_search)) {
            $sql .= ' AND (student.first_name LIKE :search OR student.last_name LIKE :search)';
        }
    
        if (!empty($student_filter)) {
            $validFilters = ['org_name', 'status'];
            if (in_array($student_filter, $validFilters)) {
                $sql .= " ORDER BY $student_filter ASC";
            }
        } else {
            $sql .= " ORDER BY last_name ASC";
        }
    
        $query = $this->conn->prepare($sql);
        $query->bindParam(':course_id', $course_id);
        $query->bindParam(':organization_id', $organization_id);
        
        if (!empty($student_search)) {
            $searchTerm = "%$student_search%";
            $query->bindParam(':search', $searchTerm);
        }
        if ($query->execute()) {
            $students = $query->fetchAll();
            return $students;
        } else {
            $errorInfo = $query->errorInfo();
            echo "Query failed: " . $errorInfo[2];
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

    function paymentHistory($organization_id, $from_date = '', $to_date = '') {
        $sql = "SELECT payment.*, organization.org_name, student.*, facilitator.*
                FROM payment
                JOIN facilitator ON payment.facilitator_id = facilitator.facilitator_id
                JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id
                JOIN organization ON student_organization.organization_id = organization.organization_id
                JOIN student ON student_organization.student_id = student.student_id
                WHERE organization.organization_id = :organization_id
                AND payment.payment_status = 'Paid'";
    
        if (!empty($from_date) && !empty($to_date)) {
            $sql .= " AND payment.date_of_payment BETWEEN :from_date AND :to_date";
        }
    
        $query = $this->conn->prepare($sql);
        $query->bindParam(':organization_id', $organization_id);
    
        if (!empty($from_date) && !empty($to_date)) {
            $query->bindParam(':from_date', $from_date);
            $query->bindParam(':to_date', $to_date);
        }
    
        if ($query->execute()) {
            $data = $query->fetchAll();
            return $data;
        } else {
            return null;
        }
    }
    
    

    function reports(){
        $sql = "SELECT organization.COUNT(*) as total_organization, organization.SUM(total_collected) payments_collected, student.COUNT(*) as students_enrolled
                FROM student_organization
                JOIN organization ON student_organization.organization_id = organization.organization_id
                JOIN student ON student_organization.student_id = student.organization_id
                ";

        $query = $this->conn->prepare($sql);
        if($query->execute()){
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    // function allStudents(){
    //     $sql = 'SELECT * FROM students';
    //     $query = $this->conn->prepare($sql);
    //     if($query->execute()){
    //         return $query->fetchAll();
    //     } else {
    //         return null;
    //     }
    // }

    function addOrganization($org_name, $org_description, $required_fee){
        $sql = "INSERT INTO organization(org_name, org_description, created_date, required_fee)
                VALUES(:org_name, :org_description, NOW(), :required_fee);";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':org_name', $org_name);
        $query->bindParam(':org_description', $org_description);
        $query->bindParam(':required_fee', $required_fee);



        if($query->execute()){
            return true;
            $organization_id = $this->conn->lastInsertId();

            $sql_add_stud_org = "INSERT INTO student_organization (student_id, organization_id)
                                SELECT student_id, :organization_id 
                                FROM student 
                                WHERE status = 'Active'";
            $query_add_stud_org = $this->conn->prepare($sql_add_stud_org);
            $query_add_stud_org->bindParam(':organization_id', $organization_id);
        } else {
            return false;
        }


    }

    function allOrgs(){
        $sql = 'SELECT * FROM organization';
        $query = $this->conn->prepare($sql);
        if($query->execute()){
            return $query->fetchAll();
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