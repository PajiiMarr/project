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
    function facilitatorList($organization_id){
        $sql = 'SELECT * FROM facilitator WHERE organization_id = :organization_id;';
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        if($query->execute()){
            $data = $query->fetch();
        } else {
            return false;
        }
        return $data;
    }

    function viewStudents($course_id, $organization_id ='') {
        $sql = "SELECT student.*, organization.org_name, payment.*
                FROM payment 
                JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id 
                JOIN student ON student_organization.student_id = student.student_id 
                JOIN organization ON student_organization.organization_id = organization.organization_id
                WHERE student.course_id = :course_id AND organization.organization_id = :organization_id AND semester = 'First Semester'";
    
        $query = $this->conn->prepare($sql);
        $query->bindParam(':course_id', $course_id);
        $query->bindParam(':organization_id', $organization_id);
        
        if ($query->execute()) {
            $students = $query->fetchAll();
            return $students;
        } else {
            $errorInfo = $query->errorInfo();
            echo "Query failed: " . $errorInfo[2];
        }
        
    }

    function paymentModal($payment_id) {
        $sql = "SELECT student.*, organization.*, course.course_code, payment.amount_to_pay
            FROM payment
            INNER JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id
            INNER JOIN organization ON student_organization.organization_id = organization.organization_id
            INNER JOIN student ON student_organization.student_id = student.student_id
            INNER JOIN course on student.course_id = course.course_id
            WHERE payment.payment_id = :payment_id";
        $query = $this->conn->prepare($sql);       
        $query->bindParam(":payment_id", $payment_id);
        if($query->execute()){
            return $query->fetch();
        }
    }
    

    function updatePayment($payment_id, $amount_to_pay){
        $payment_atp = $this->paymentModal($payment_id);

        $sql = "UPDATE payment SET date_of_payment = NOW(), admin_id = 1, amount_to_pay = amount_to_pay - :amount_to_pay";

        if($amount_to_pay == $payment_atp['amount_to_pay']){
            $sql .= ", payment_status = 'Paid'";
        }

        $sql .= " WHERE payment_id = :payment_id";
        $query = $this->conn->prepare($sql);      
        $query->bindParam(':payment_id', $payment_id);
        $query->bindParam(':amount_to_pay', $amount_to_pay);
        $query->execute();

        $this->updatePendingBalance($payment_id, $amount_to_pay);
        $this->addPaymentHistory($payment_id, $amount_to_pay);
        
        return true;
    }

    function updatePendingBalance($payment_id, $amount_to_pay){
        $sql = "SELECT organization.organization_id FROM payment
        INNER JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id
        INNER JOIN organization ON student_organization.organization_id = organization.organization_id
        WHERE payment_id = :payment_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":payment_id", $payment_id);
        $query->execute();
        
        $organization_id = $query->fetchColumn();

        var_dump($organization_id);

        $sql_pending_balance = "UPDATE organization SET pending_balance = pending_balance - :amount_to_pay, total_collected = total_collected + :amount_to_add WHERE organization_id = :organization_id";
        $query_pending_balance = $this->conn->prepare($sql_pending_balance);
        $query_pending_balance->bindParam(":amount_to_pay", $amount_to_pay);
        $query_pending_balance->bindParam(":amount_to_add", $amount_to_pay);
        $query_pending_balance->bindParam(":organization_id", $organization_id);

        $query_pending_balance->execute();

        return true;
    }

    

    function addPaymentHistory($payment_id, $amount_to_pay) {
        $sql = "INSERT INTO payment_history(payment_id, issued_by, amount_paid) VALUES(:payment_id, 'Admin', :amount_to_pay)";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":payment_id", $payment_id);
        $query->bindParam(":amount_to_pay", $amount_to_pay);

        $query->execute();
        return true;
    }

    function paymentHistory(){
        $sql = "SELECT student.last_name, student.first_name, student.middle_name, organization.org_name, course.course_code,
        payment.amount_to_pay, payment_history.amount_paid, payment_history.date_issued, payment_history.issued_by
        FROM payment_history 
        INNER JOIN payment ON payment_history.payment_id = payment.payment_id
        INNER JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id
        INNER JOIN organization ON student_organization.organization_id = organization.organization_id
        INNER JOIN student ON student_organization.student_id = student.student_id
        INNER JOIN course ON student.course_id = course.course_id";
        $query = $this->conn->prepare($sql);

        if($query->execute()){
            return $query->fetchAll();
        } else{
            return null;
        }

    }
    
    

    function reports() {
        $sql = "SELECT COUNT(DISTINCT organization.organization_id) AS organization_count, 
                       COUNT(DISTINCT student.student_id) AS students_enrolled, 
                       SUM(DISTINCT organization.total_collected) AS fees_collected 
                FROM organization 
                INNER JOIN student_organization ON organization.organization_id = student_organization.organization_id 
                INNER JOIN student ON student_organization.student_id = student.student_id;";
    
        $query = $this->conn->prepare($sql);
        $reportData = [];
        
        if ($query->execute()) {
            $reportData = $query->fetch();
        }
    
        $sql_facilitator = "SELECT COUNT(facilitator_id) AS facilitators_count FROM facilitator;";
        $query_facilitator = $this->conn->prepare($sql_facilitator);
        
        if ($query_facilitator->execute()) {
            $reportData['facilitators_count'] = $query_facilitator->fetchColumn();
        }
    
        return $reportData;
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

    function addOrganization($org_name, $org_description, $contact_email, $required_fee){
        $sql = "INSERT INTO organization (org_name, contact_email, org_description, created_date, required_fee)
        VALUES (:org_name, :contact_email, :org_description, NOW(), :required_fee)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':org_name', $org_name);
        $query->bindParam(':org_description', $org_description);
        $query->bindParam(':required_fee', $required_fee);
        $query->bindParam(':contact_email', $contact_email);
        $query->execute();

        $organization_id = $this->conn->lastInsertId();

        $this->insertStudOrg($organization_id, $required_fee);

        $sql_update_balance = "UPDATE organization SET pending_balance = (
            SELECT SUM(o.required_fee)
            FROM student_organization so
            INNER JOIN payment ON so.stud_org_id = payment.student_org_id
            INNER JOIN organization o ON o.organization_id = so.organization_id
            WHERE o.organization_id = :organization_id
              AND payment.payment_status = 'Unpaid'
              AND payment.semester = 'First Semester'
        ) 
        WHERE organization_id = :organization_id";

        $query_update_balance = $this->conn->prepare($sql_update_balance);
        $query_update_balance->bindParam(":organization_id", $organization_id);
        $query_update_balance->execute();

        return true;
    }

    function insertStudOrg($organization_id, $required_fee){
        $sql_add_stud_org = "INSERT INTO student_organization (student_id, organization_id)
        SELECT student_id, :organization_id 
        FROM student 
        WHERE status = 'Active'";
        $query_add_stud_org = $this->conn->prepare($sql_add_stud_org);
        $query_add_stud_org->bindParam(':organization_id', $organization_id);
        $query_add_stud_org->execute();
        
        $this->insertPayment($organization_id, $required_fee);
    }

    function insertPayment($organization_id, $required_fee){
        $sql = "SELECT * FROM student_organization WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();

        $stud_org_id = $query->fetchAll();

        foreach($stud_org_id as $soi){
            $sql_first_sem = "INSERT INTO payment (student_org_id, semester, amount_to_pay) VALUES(:stud_org_id, 'First Semester', :amount_to_pay)";
            $query_first_sem = $this->conn->prepare($sql_first_sem);
            $query_first_sem->bindParam(':stud_org_id', $soi['stud_org_id']);
            $query_first_sem->bindParam(':amount_to_pay', $required_fee);
            $query_first_sem->execute();
    
            $sql_second_sem = "INSERT INTO payment (student_org_id, semester, amount_to_pay) VALUES(:stud_org_id, 'Second Semester', :amount_to_pay)";
            $query_second_sem = $this->conn->prepare($sql_second_sem);
            $query_second_sem->bindParam(':stud_org_id', $soi['stud_org_id']);
            $query_second_sem->bindParam(':amount_to_pay', $required_fee);
            $query_second_sem->execute();
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