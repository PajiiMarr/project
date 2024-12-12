<?php
require_once 'database.class.php';

class Facilitator {
    private $conn;

    function __construct() {
        $db = new Database;
        $this->conn = $db->connect();
    }

    // Fetch dashboard data for the facilitator
    function getDashboardData($organization_id) {
        $sql = "SELECT organization.org_name , COUNT(payment_history.payment_history_id) AS payments_issued FROM payment_history
                INNER JOIN payment ON payment_history.payment_id = payment.payment_id
                INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
                INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
                WHERE organization.organization_id = :organization_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
        return $query->fetch();
    }

    function students_enrolled(){
        $sql = "SELECT COUNT(student.student_id) AS students_enrolled FROM student WHERE status = 'Enrolled';";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function total_collection($organization_id){
        $sql = "SELECT SUM(total_collected) AS total_collected FROM collection_fees WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
        return $query->fetch();
    }

    function recentPayments($organization_id){
        $sql = "SELECT payment_history.*, payment.payment_status, student.* FROM payment_history 
                INNER JOIN payment ON payment_history.payment_id = payment.payment_id
                INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
                INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
                INNER JOIN student ON payment.student_id = student.student_id
                WHERE organization.organization_id = :organization_id
                ORDER BY payment_history.date_issued DESC
                LIMIT 10";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
        return $query->fetchAll();
    }

    function facilitator_details($facilitator_id){
        $sql = "SELECT organization.org_status, facilitator.* FROM facilitator
        INNER JOIN organization ON organization.organization_id = facilitator.organization_id
        WHERE facilitator_id = :facilitator_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":facilitator_id", $facilitator_id);
        $query->execute();
        return $query->fetch();
    }

    function viewStudents($organization_id) {
        $sql = "SELECT student.*, course.course_code, payment.*, collection_fees.purpose ,organization.organization_id, organization.org_name, collection_fees.start_date, collection_fees.date_due FROM payment
                INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
                INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
                INNER JOIN student ON payment.student_id = student.student_id
                INNER JOIN course ON student.course_id = course.course_id
                WHERE organization.organization_id = :organization_id
                AND student.status = 'Enrolled'
                AND collection_fees.start_date <= CURDATE()
                ORDER BY student.last_name ASC";
    
        
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();

        $students = $query->fetchAll();
        return $students;
    }

    function viewCourse(){
        $sql = "SELECT * FROM course;";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function paymentModal($payment_id) {
        $sql = "SELECT student.*, organization.org_name, collection_fees.amount, collection_fees.purpose, course.course_code, payment.amount_to_pay, payment.balance
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

    function updatePayment($payment_id, $amount_to_pay, $facilitator_id){
        $payment_atp = $this->paymentModal($payment_id);

        $sql = "UPDATE payment SET date_of_payment = NOW(), balance = balance - :balance";

        if($amount_to_pay == $payment_atp['balance']){
            $sql .= ", payment_status = 'Paid'";
        }

        $sql .= " WHERE payment_id = :payment_id";
        $query = $this->conn->prepare($sql);      
        $query->bindParam(':payment_id', $payment_id);
        $query->bindParam(':balance', $amount_to_pay);
        $query->execute();

        $this->updatePendingBalance($payment_id, $amount_to_pay);
        $this->addPaymentHistory($payment_id, $amount_to_pay, $facilitator_id);
        
        return true;
    }

    function payment_student($payment_id){
        $sql = "SELECT student.student_id FROM payment
        INNER JOIN student ON payment.student_id = student.student_id
        WHERE payment_id = :payment_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":payment_id", $payment_id);

        $query->execute();

        $student_id = $query->fetchColumn();

        $enroll_payment = $this->enroll_payment($student_id);
        $all_paid = true;
        foreach($enroll_payment as $ep){
            if($ep['payment_status'] == 'Unpaid'){
                $all_paid = false;
                break;
            }
        }

        if($all_paid){
            $this->set_enroll($student_id);
        }
    }

    function set_enroll($student_id){
        $sql = "UPDATE student SET status = 'Enrolled' WHERE student_id = :student_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":student_id", $student_id);

        $query->execute();
    }

    function enroll_payment($student_id){
        $sql = "SELECT collection_fees.label, payment.payment_status, student.student_id FROM payment
        INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
        INNER JOIN student ON payment.student_id = student.student_id
        WHERE student_id = :student_id
        AND label = 'Required'";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":student_id",$student_id);
        return $query->fetchAll();
    }



    function updatePendingBalance($payment_id, $amount_to_pay){
        $sql = "SELECT organization.organization_id FROM payment
        INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
        INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
        WHERE payment_id = :payment_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":payment_id", $payment_id);
        $query->execute();
        
        $organization_id = $query->fetchColumn();

        $sql_pending_balance = "UPDATE collection_fees SET pending_balance = pending_balance - :amount_to_pay, total_collected = total_collected + :amount_to_add
                                WHERE organization_id = :organization_id";
        $query_pending_balance = $this->conn->prepare($sql_pending_balance);
        $query_pending_balance->bindParam(":amount_to_pay", $amount_to_pay);
        $query_pending_balance->bindParam(":amount_to_add", $amount_to_pay);
        $query_pending_balance->bindParam(":organization_id", $organization_id);

        $query_pending_balance->execute();

        return true;
    }

    function addPaymentHistory($payment_id, $amount_to_pay, $facilitator_id) {
        $sql = "INSERT INTO payment_history(payment_id, facilitator_id, amount_paid) VALUES(:payment_id, :facilitator_id, :amount_to_pay)";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":payment_id", $payment_id);
        $query->bindParam(":facilitator_id", $facilitator_id);
        $query->bindParam(":amount_to_pay", $amount_to_pay);

        $query->execute();
        return true;
    }

    function paymentHistory($user_id){
        $facilitator_organization = $this->facilitator_details($user_id);
        $sql = "SELECT payment_history.*, student.* FROM payment_history 
                INNER JOIN payment ON payment_history.payment_id = payment.payment_id
                INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
                INNER JOIN student ON payment.student_id = student.student_id
                INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
                WHERE organization.organization_id = :organization_id
                ORDER BY date_issued DESC";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $facilitator_organization['organization_id']);
        $query->execute();
        return $query->fetchAll();
    }

    function assignStudent() {
        $sql = "SELECT student.*, course.course_code, facilitator.is_head, facilitator.organization_id, organization.org_name, facilitator.is_assistant_head, facilitator.is_collector
                FROM student 
                INNER JOIN course ON student.course_id = course.course_id
                INNER JOIN user ON student.student_id = user.user_id
                LEFT JOIN facilitator ON user.user_id = facilitator.facilitator_id
                LEFT JOIN organization ON facilitator.organization_id = organization.organization_id
                WHERE student.status = 'Enrolled'
                GROUP BY student.status, course.course_code
                ORDER BY student.status, student.last_name, student.course_section, student.course_section ASC
                ";


        $query = $this->conn->prepare($sql);
        
        $query->execute();

        $students = $query->fetchAll();
        return $students;
    }

    function fetch_student_details($user_id){
        $sql = "SELECT * FROM student WHERE student_id = :user_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":user_id", $user_id);
        $query->execute();
        return $query->fetch();
    }

    function count_officer($organization_id){
        $sql = "SELECT f.is_assistant_head, f.is_collector, o.org_name FROM organization o
        LEFT JOIN facilitator f ON o.organization_id = f.organization_id
        WHERE o.organization_id = :organization_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
        return $query->fetch();
    }

    function assign_officer($user_id, $organization_id, $position){
        $sql = "UPDATE user SET is_facilitator = 1 WHERE user_id = :user_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":user_id", $user_id);
        $query->execute();

        $student_details = $this->fetch_student_details($user_id);
        $this->set_facilitator($student_details['student_id'], $organization_id, $student_details['course_id'], $student_details['last_name'], $student_details['first_name'], $student_details['middle_name'], $student_details['phone_number'], $student_details['dob'], $student_details['age'], $student_details['course_year'], $student_details['course_section'], $position);
    }

    function get_officers($organization_id){
        $sql = "SELECT * FROM facilitator WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
        return $query->fetchAll();
    }

    function set_facilitator($user_id, $organization_id, $course_id, $last_name, $first_name, $middle_name, $phone_number, $dob, $age, $course_year, $course_section, $position){
        if($position == 'assistant_head'){
            $sql = "INSERT INTO facilitator (facilitator_id, organization_id, course_id, last_name, first_name, middle_name, phone_number, dob, age, course_year, course_section, is_assistant_head) VALUES (:user_id, :organization_id, :course_id, :last_name, :first_name, :middle_name, :phone_number, :dob, :age, :course_year, :course_section, 1);";
        } else {
            $sql = "INSERT INTO facilitator (facilitator_id, organization_id, course_id, last_name, first_name, middle_name, phone_number, dob, age, course_year, course_section, is_collector) VALUES (:user_id, :organization_id, :course_id, :last_name, :first_name, :middle_name, :phone_number, :dob, :age, :course_year, :course_section, 1);";
        }
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

    function get_org($organization_id){
        $sql = "SELECT * FROM organization WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":organization_id", $organization_id);
        $query->execute();
        return $query->fetch();
    }

    function request_fee($organization_id, $amount, $purpose, $description, $start_date, $date_due, $label){
        $sql_add_stud_org = "INSERT INTO collection_fees(organization_id,amount, purpose, description, start_date, date_due, label)
                             VALUES (:organization_id, :clearance_fee, :purpose, :description, :start_date, :date_due, :label)";
        $query_add_stud_org = $this->conn->prepare($sql_add_stud_org);
        $query_add_stud_org->bindParam(':organization_id', $organization_id);
        $query_add_stud_org->bindParam(':clearance_fee', $amount);
        $query_add_stud_org->bindParam(':purpose', $purpose);
        $query_add_stud_org->bindParam(':description', $description);
        $query_add_stud_org->bindParam(':start_date', $start_date);
        $query_add_stud_org->bindParam(':date_due', $date_due);
        $query_add_stud_org->bindParam(':label', $label);
        
        $query_add_stud_org->execute();
    }

    function all_fees($user_id){
        $facilitator_details = $this->facilitator_details($user_id);
        $sql = "SELECT * FROM collection_fees WHERE organization_id = :organization_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":organization_id", $facilitator_details['organization_id']);

        $query->execute();
        return $query->fetchAll();
    }

    function org_all_fees($organization_id){
        $sql = "SELECT * FROM collection_fees WHERE organization_id = :organization_id LIMIT 5";
        $query = $this->conn->prepare($sql);
        
        $query->bindParam(":organization_id", $organization_id);

        $query->execute();
        return $query->fetchAll();
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
}
