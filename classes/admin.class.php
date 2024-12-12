<?php
require_once 'database.class.php';
class Admin {
    private $conn;

    function __construct(){
        $db = new Database;
        $this->conn = $db->connect();
    }

    // function login($username, $password){
    //     $sql = 'SELECT * FROM admin WHERE admin_username = :username';
    //     $query = $this->conn->prepare($sql);

    //     $query->bindparam(':username', $username);
    //     $query->execute();

    //     $admin = $query->fetch();

    //     if($admin && password_verify($password, $admin['admin_password'])){
    //         $_SESSION['admin_id'] = $admin['admin_id'];
    //         $sql_date_updated = 'UPDATE admin SET date_updated = CURRENT_TIMESTAMP';
    //         $query_date_updated = $this->conn->prepare($sql_date_updated);
    //         $query_date_updated->execute();

    //         header('Location: dashboard.php');
    //         exit;
    //     } else {
    //         $_SESSION['incorrect_credentials'] = 'Incorrect Credentials';
    //     }
    // }

    function orgDetails($organization_id){
        $sql = 'SELECT * FROM organization
        WHERE organization_id = :organization_id;';
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        if($query->execute()){
            $data = $query->fetch();
        } else {
            return false;
        }
        return $data;
    }

    function collection_fees($organization_id){
        $sql = "SELECT *, SUM(DISTINCT total_collected) AS total_collection FROM collection_fees WHERE organization_id = :organization_id
        GROUP BY collection_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":organization_id", $organization_id);
        
        $query->execute();
        return $query->fetchAll();
    }
    
    function facilitatorList($organization_id){
        $sql = 'SELECT * FROM facilitator WHERE organization_id = :organization_id';
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            return false;
        }
        return $data;
    }



    function viewStudents() {
        $sql = "SELECT student.*, course.course_code, facilitator.is_head, facilitator.organization_id, organization.org_name, facilitator.is_assistant_head, facilitator.is_collector
                FROM student 
                INNER JOIN course ON student.course_id = course.course_id
                INNER JOIN user ON student.student_id = user.user_id
                LEFT JOIN facilitator ON user.user_id = facilitator.facilitator_id
                LEFT JOIN organization ON facilitator.organization_id = organization.organization_id
                GROUP BY student.status, course.course_code
                ORDER BY student.status, student.last_name, student.course_section, student.course_section ASC
                ";


        $query = $this->conn->prepare($sql);
        
        $query->execute();

        $students = $query->fetchAll();
        return $students;
    }

    function view_edit_student($student_id){
        $sql = "SELECT * FROM student WHERE student_id = :student_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":student_id", $student_id);
        $query->execute();
        return $query->fetch();
    }

    function viewCourse(){
        $sql = "SELECT course_id, course_code FROM course";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // function head_count(){
    //     $sql = "SELECT 
    //             SUM(is_head = 1) AS head_count,
    //             organization_id 
    //         FROM facilitator 
    //         GROUP BY organization_id 
    //         ";
                
    //     $query = $this->conn->prepare($sql);

    //     $query->execute();

    //     return $query->fetchAll();
    // }



    function fetch_student_details($user_id){
        $sql = "SELECT * FROM student WHERE student_id = :user_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":user_id", $user_id);
        $query->execute();
        return $query->fetch();
    }

    function assign_head($user_id, $organization_id){
        $sql = "UPDATE user SET is_facilitator = 1 WHERE user_id = :user_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":user_id", $user_id);
        $query->execute();

        $student_details = $this->fetch_student_details($user_id);
        $this->set_facilitator($student_details['student_id'], $organization_id, $student_details['course_id'], $student_details['last_name'], $student_details['first_name'], $student_details['middle_name'], $student_details['phone_number'], $student_details['dob'], $student_details['age'], $student_details['course_year'], $student_details['course_section']);
    }

    function set_facilitator($user_id, $organization_id, $course_id, $last_name, $first_name, $middle_name, $phone_number, $dob, $age, $course_year, $course_section){
        $sql = "INSERT INTO facilitator (facilitator_id, organization_id, course_id, last_name, first_name, middle_name, phone_number, dob, age, course_year, course_section, is_head)
                VALUES (:user_id, :organization_id, :course_id, :last_name, :first_name, :middle_name, :phone_number, :dob, :age, :course_year, :course_section, 1);";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":user_id", $user_id);
        $query->bindParam(":organization_id", $organization_id);
        $query->bindParam(":course_id", $course_id);
        $query->bindParam(":last_name", $last_name);
        $query->bindParam(":first_name", $first_name);
        $query->bindParam(":middle_name", $middle_name);
        $query->bindParam(":phone_number", $phone_number);
        $query->bindParam(":dob", $dob);
        $query->bindParam(":age", $age);
        $query->bindParam(":course_year", $course_year);
        $query->bindParam(":course_section", $course_section);

        if($query->execute()){
            return true;
        } else {
            return false;
        }
    }

    function resign_head_modal($facilitator_id){
        $sql = "SELECT o.org_name, f.* FROM facilitator f
                LEFT JOIN organization o ON o.organization_id = f.organization_id
                WHERE f.facilitator_id = :facilitator_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":facilitator_id", $facilitator_id);
        $query->execute();
        return $query->fetch();
    }

    function resign($facilitator_id, $reason){
        $sql = "DELETE FROM facilitator WHERE facilitator_id = :facilitator_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":facilitator_id", $facilitator_id);
        $query->execute();
        
        $sql_remove_is_facilitator = "UPDATE user SET is_facilitator = 0 WHERE user_id = :facilitator_id";
        $query_remove_is_facilitator =$this->conn->prepare($sql_remove_is_facilitator);
        $query_remove_is_facilitator->bindParam(":facilitator_id", $facilitator_id);
        $query_remove_is_facilitator->execute();

        if($reason == "dropped"){
            $sql_set_status_dropped = "UPDATE student SET status = 'dropped' WHERE student_id = :facilitator_id";
            $query_set_status_dropped = $this->conn->prepare($sql_set_status_dropped);
            $query_set_status_dropped->bindParam(":facilitator_id", $facilitator_id);
            $query_set_status_dropped->execute();
        } else if($reason == 'graduated'){
            $sql_set_status_dropped = "UPDATE student SET status = 'graduated' WHERE student_id = :facilitator_id";
            $query_set_status_dropped = $this->conn->prepare($sql_set_status_dropped);
            $query_set_status_dropped->bindParam(":facilitator_id", $facilitator_id);
            $query_set_status_dropped->execute();
        } else if($reason == 'other'){
            $sql_set_status_dropped = "UPDATE student SET status = 'Undefined' WHERE student_id = :facilitator_id";
            $query_set_status_dropped = $this->conn->prepare($sql_set_status_dropped);
            $query_set_status_dropped->bindParam(":facilitator_id", $facilitator_id);
            $query_set_status_dropped->execute();
        }
    }

    function facilitator_details($facilitator_id){
        $sql = "SELECT * FROM facilitator WHERE facilitator_id = :facilitator_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":facilitator_id", $facilitator_id);
        $query->execute();
        return $query->fetch();
    }

    function editOrganization($organization_id, $org_name, $org_description, $contact_email){
        $sql = "UPDATE organization SET org_name = :org_name, org_description = :org_description, contact_email = :contact_email
        WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(':org_name', $org_name);
        $query->bindParam(':org_description', $org_description);
        $query->bindParam(':contact_email', $contact_email);
        $query->bindParam(':organization_id', $organization_id);

        $query->execute();
    }

    function remove($facilitator_id, $reason){
        if($reason == "dropped"){
            $sql_set_status_dropped = "UPDATE student SET status = 'dropped' WHERE student_id = :facilitator_id";
            $query_set_status_dropped = $this->conn->prepare($sql_set_status_dropped);
            $query_set_status_dropped->bindParam(":facilitator_id", $facilitator_id);
            $query_set_status_dropped->execute();
        } else if($reason == 'graduated'){
            $sql_set_status_dropped = "UPDATE student SET status = 'graduated' WHERE student_id = :facilitator_id";
            $query_set_status_dropped = $this->conn->prepare($sql_set_status_dropped);
            $query_set_status_dropped->bindParam(":facilitator_id", $facilitator_id);
            $query_set_status_dropped->execute();
        } else if($reason == 'other'){
            $sql_set_status_dropped = "UPDATE student SET status = 'Undefined' WHERE student_id = :facilitator_id";
            $query_set_status_dropped = $this->conn->prepare($sql_set_status_dropped);
            $query_set_status_dropped->bindParam(":facilitator_id", $facilitator_id);
            $query_set_status_dropped->execute();
        }
    }

    function enrollUndefinedStudent($student_id){
        $sql = "UPDATE student SET status = 'Enrolled' WHERE student_id = :student_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":student_id", $student_id);
        $query->execute();
    }

    function paymentModal($payment_id) {
        $sql = "SELECT student.*, organization.*, collection_fees.* ,course.course_code, payment.amount_to_pay
            FROM payment
            INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
            INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
            INNER JOIN student ON payment.student_id = student.student_id
            INNER JOIN course on student.course_id = course.course_id
            WHERE payment.payment_id = :payment_id";
        $query = $this->conn->prepare($sql);       
        $query->bindParam(":payment_id", $payment_id);
        if($query->execute()){
            return $query->fetch();
        }
    }
    

    // function updatePayment($payment_id, $amount_to_pay){
    //     $payment_atp = $this->paymentModal($payment_id);

    //     $sql = "UPDATE payment SET date_of_payment = NOW(),amount_to_pay = amount_to_pay - :amount_to_pay";

    //     if($amount_to_pay == $payment_atp['amount_to_pay']){
    //         $sql .= ", payment_status = 'Paid'";
    //     }

    //     $sql .= " WHERE payment_id = :payment_id";
    //     $query = $this->conn->prepare($sql);      
    //     $query->bindParam(':payment_id', $payment_id);
    //     $query->bindParam(':amount_to_pay', $amount_to_pay);
    //     $query->execute();

    //     $this->updatePendingBalance($payment_id, $amount_to_pay);
    //     $this->addPaymentHistory($payment_id, $amount_to_pay);
        
    //     return true;
    // }

    // function updatePendingBalance($payment_id, $amount_to_pay){
    //     $sql = "SELECT organization.organization_id FROM payment
    //     INNER JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id
    //     INNER JOIN organization ON student_organization.organization_id = organization.organization_id
    //     WHERE payment_id = :payment_id";
    //     $query = $this->conn->prepare($sql);

    //     $query->bindParam(":payment_id", $payment_id);
    //     $query->execute();
        
    //     $organization_id = $query->fetchColumn();

    //     var_dump($organization_id);

    //     $sql_pending_balance = "UPDATE organization SET pending_balance = pending_balance - :amount_to_pay, total_collected = total_collected + :amount_to_add WHERE organization_id = :organization_id";
    //     $query_pending_balance = $this->conn->prepare($sql_pending_balance);
    //     $query_pending_balance->bindParam(":amount_to_pay", $amount_to_pay);
    //     $query_pending_balance->bindParam(":amount_to_add", $amount_to_pay);
    //     $query_pending_balance->bindParam(":organization_id", $organization_id);

    //     $query_pending_balance->execute();

    //     return true;
    // }

    

    // function addPaymentHistory($payment_id, $amount_to_pay) {
    //     $sql = "INSERT INTO payment_history(payment_id, issued_by, amount_paid) VALUES(:payment_id, 'Admin', :amount_to_pay)";
    //     $query = $this->conn->prepare($sql);

    //     $query->bindParam(":payment_id", $payment_id);
    //     $query->bindParam(":amount_to_pay", $amount_to_pay);

    //     $query->execute();
    //     return true;
    // }

    function paymentHistory(){
        $sql = "SELECT student.last_name, student.first_name, student.middle_name, organization.org_name, course.course_code,
        payment.amount_to_pay, payment_history.amount_paid, payment_history.date_issued, payment_history.issued_by
        FROM payment_history 
        INNER JOIN payment ON payment_history.payment_id = payment.payment_id
        INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
        INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
        INNER JOIN student ON payment.student_id = student.student_id
        INNER JOIN course ON student.course_id = course.course_id
        ORDER BY payment_history.date_issued DESC";
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
                       SUM(collection_fees.total_collected) AS fees_collected
                FROM organization 
                INNER JOIN collection_fees ON collection_fees.organization_id = organization.organization_id 
                INNER JOIN payment ON collection_fees.collection_id = payment.collection_id
                INNER JOIN student ON payment.student_id = student.student_id;";
    
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

    function all_orgs_total_collected(){
        $sql = "SELECT organization.*, SUM(total_collected) AS all_collected FROM collection_fees
                INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
                GROUP BY collection_fees.organization_id";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    

    function allStudents(){
        $sql = 'SELECT student_id FROM student';
        $query = $this->conn->prepare($sql);
        if($query->execute()){
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function addOrganization($org_name, $org_description){
        $sql = "INSERT INTO organization (org_name, org_description, created_date)
        VALUES (:org_name, :org_description, NOW())";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':org_name', $org_name);
        $query->bindParam(':org_description', $org_description);
        $query->execute();


        return true;
    }

    function insert_clearance_fee($organization_id, $clearance_fee){
        $sql_add_stud_org = "INSERT INTO collection_fees(organization_id,amount)
                             VALUES (:organization_id, :clearance_fee)";
        $query_add_stud_org = $this->conn->prepare($sql_add_stud_org);
        $query_add_stud_org->bindParam(':organization_id', $organization_id);
        $query_add_stud_org->bindParam(':clearance_fee', $clearance_fee);
        $query_add_stud_org->execute();
    }

    function insertPayment($collection_id) {
        // Fetching collection fees related to the given organization
        $sql = "SELECT collection_fees.collection_id, collection_fees.organization_id, collection_fees.amount
                FROM collection_fees
                WHERE collection_fees.collection_id = :collection_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":collection_id", $collection_id);
        $query->execute();
    
        $collectionFees = $query->fetchAll();
        $students = $this->allStudents(); // Fetch all student IDs
    
        // Iterate over collection fees and insert payments
        foreach ($collectionFees as $fee) {
            foreach ($students as $student) {
                // Insert payment records
                $sql_insert_payment = "INSERT INTO payment (student_id, collection_id, amount_to_pay, balance)
                                       VALUES (:student_id, :collection_id, :amount_to_pay, :balance)";
                $query_insert_payment = $this->conn->prepare($sql_insert_payment);
                $query_insert_payment->bindParam(":student_id", $student['student_id']);
                $query_insert_payment->bindParam(":collection_id", $fee['collection_id']);
                $query_insert_payment->bindParam(":amount_to_pay", $fee['amount']);
                $query_insert_payment->bindParam(":balance", $fee['amount']);

                $query_insert_payment->execute();
            }
        }
    
        return true;
    }

    function deactivateOrg($organization_id){
        $sql = "UPDATE organization SET org_status = 'Deactivated' WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
    }

    function activateOrg($organization_id){
        $sql = "UPDATE organization SET org_status = 'Active' WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
    }


    function get_org($organization_id){
        $sql = "SELECT * FROM organization WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
        return $query->fetch();
    }
    

    

    function allOrgs(){
        $sql = 'SELECT * FROM organization';
        $query = $this->conn->prepare($sql);
        if($query->execute()){
            return $query->fetchAll();
        }
    }

    function allOrgsHeadAssigned(){
        $sql = "SELECT f.is_head, o.* FROM organization o 
        LEFT JOIN facilitator f ON o.organization_id = f.organization_id";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function collection_fee_details($collection_id){
        $sql = "SELECT collection_fees.*, organization.org_name FROM collection_fees
        INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
        WHERE collection_id = :collection_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":collection_id", $collection_id);

        $query->execute();
        return $query->fetch();
    }

    function approve_request($collection_id){
        $sql = "UPDATE collection_fees SET request_status = 'Approved' WHERE collection_id = :collection_id";
        $query = $this->conn->prepare($sql);
        
        $query->bindParam(':collection_id', $collection_id);

        $query->execute();

        $this->insertPayment($collection_id);
    }

    function decline_request($collection_id){
        $sql = "UPDATE collection_fees SET request_status = 'Declined' WHERE collection_id = :collection_id";
        $query = $this->conn->prepare($sql);
        
        $query->bindParam(':collection_id', $collection_id);

        $query->execute();
    }
    

}
?>