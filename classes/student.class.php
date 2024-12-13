<?php 
require_once 'database.class.php';

class Student {
    private $conn;

    function __construct(){
        $db = new Database;
        $this->conn = $db->connect();
    }

    function student_details($user_id){
        $sql = "SELECT * FROM student WHERE student_id = :student_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":student_id", $user_id);

        $query->execute();

        return $query->fetch();
    }

    function enrollment_status($user_id){
        $sql = "SELECT status FROM student WHERE student_id = :student_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":student_id", $user_id);

        $query->execute();
        return $query->fetchColumn();
    }

    function sy_semesters($sy_sem = null) {
        $sql = "SELECT DISTINCT sy_sem FROM payment ORDER BY collection_status ASC";
        if ($sy_sem) {
            $sql .= " WHERE sy_sem = :sy_sem";
        }
        $query = $this->conn->prepare($sql);
        
        if ($sy_sem) {
            $query->bindParam(":sy_sem", $sy_sem);
        }
    
        $query->execute();
        return $query->fetchAll();
    }

    function all_payments($user_id){
        $sql = "SELECT organization.*, payment.*, collection_fees.*, student.student_id FROM payment
        INNER JOIN collection_fees ON payment.collection_id = collection_fees.collection_id
        INNER JOIN organization ON collection_fees.organization_id = organization.organization_id
        INNER JOIN student ON payment.student_id = student.student_id
        WHERE student.student_id = :student_id";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":student_id", $user_id);

        $query->execute();
        return $query->fetchAll();
    }
    


    function amount_paid($user_id, $sy_sem){
        $sql = "SELECT SUM(payment_history.amount_paid) FROM payment
        INNER JOIN student ON payment.student_id = student.student_id
        INNER JOIN payment_history ON payment.payment_id = payment_history.payment_id
        WHERE student.student_id = :student_id AND payment.sy_sem = :sy_sem
        ";
        $query = $this->conn->prepare($sql);

        $query->bindParam(":user_id", $user_id);
        $query->bindParam(":sy_sem", $sy_sem);

        $query->execute();
        return $query->fetchColumn();
    }

    function payment_history($user_id){
        $sql = "SELECT payment_history.*, student.student_id, facilitator.* 
                FROM payment_history
                INNER JOIN facilitator ON payment_history.facilitator_id = facilitator.facilitator_id  -- Corrected JOIN syntax
                INNER JOIN payment ON payment_history.payment_id = payment.payment_id
                INNER JOIN student ON payment.student_id = student.student_id
                WHERE student.student_id = :student_id;";

        $query = $this->conn->prepare($sql);

        $query->bindParam(":student_id", $user_id);

        $query->execute();

        return $query->fetchAll();
    }

}

?> 