<?php
    require_once 'database.class.php';

    class Signup {
        private $conn;

        function __construct (){
            $db = new Database;
            $this->conn = $db->connect();
        }

        function sign_up($email, $password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(email, password, date_created) VALUES (:email, :password, NOW());";
            $query = $this->conn->prepare($sql);

            $query->bindParam(":email",$email);
            $query->bindParam(":password",$hashed_password);

            if($query->execute()){
                return true;
            } else {
                return false;
            }
        }

        function set_profile($user_type, $user_id, $course_id, $course_year, $last_name, $first_name, $middle_name, $phone_number, $dob, $age){
            $sql_type = "UPDATE user SET user_type = :user_type WHERE user_id = :user_id;";
            $query_type = $this->conn->prepare($sql_type);

            $query_type->bindParam(":user_type",$user_type);
            $query_type->bindParam(":user_id",$user_id);

            $query_type->execute();

            $sql_stud = "INSERT INTO student(student_id, course_id, last_name, first_name, middle_name, phone_number, dob, age, course_year)
                         VALUES (:user_id, :course_id, :last_name, :first_name, :middle_name, :phone_number, :dob, :age, :course_year);";
            $query_stud = $this->conn->prepare($sql_stud);

            if ($this->duplicate_record_exists('student', [
                'student_id' => $user_id,
                'course_id' => $course_id,
                'last_name' => $last_name,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'phone_number' => $phone_number,
                'dob' => $dob,
                'age' => $age,
                'course_year' => $course_year
            ])) {
                return false;
            }

            $query_stud->bindParam(":user_id", $user_id);
            $query_stud->bindParam(":course_id", $course_id);
            $query_stud->bindParam(":last_name", $last_name);
            $query_stud->bindParam(":first_name", $first_name);
            $query_stud->bindParam(":middle_name", $middle_name);
            $query_stud->bindParam(":phone_number", $phone_number);
            $query_stud->bindParam(":dob", $dob);
            $query_stud->bindParam(":age", $age);
            $query_stud->bindParam(":course_year", $course_year);
            
            $query_stud->execute();

            $this->insert_student_organization($user_id);
        }

        private function insert_student_organization($user_id){
            $sql_stud_org1 = "INSERT INTO student_organization(student_id, organization_id) VALUES(:user_id, 1);";
            $sql_stud_org2 = "INSERT INTO student_organization(student_id, organization_id) VALUES(:user_id, 2);";

            $query_stud_org1 = $this->conn->prepare($sql_stud_org1);
            $query_stud_org2 = $this->conn->prepare($sql_stud_org2);

            $query_stud_org1->bindParam(":user_id", $user_id);
            $query_stud_org2->bindParam(":user_id", $user_id);

            $query_stud_org1->execute();
            $query_stud_org2->execute();
        }

        function duplicate_record_exists($table, $data) {
            $sql = "SELECT COUNT(*) FROM $table WHERE ";
            $conditions = [];
            foreach ($data as $column => $value) {
                $conditions[] = "$column = :$column";
            }
            $sql .= implode(' AND ', $conditions) . " LIMIT 1;";
            $query = $this->conn->prepare($sql);
            foreach ($data as $column => $value) {
                $query->bindParam(":$column", $value);
            }
            $query->execute();
            $count = $query->fetchColumn();
            return $count > 0;
        }
        

        function set_facilitator($user_id, $organization_id, $last_name, $first_name, $middle_name, $phone_number, $dob, $age, $course_year){
            $sql = "INSERT INTO facilitator VALUES (:user_id, :organization_id, :last_name, :first_name, :middle_name, :phone_number, :dob, :age, :course_year);";
            $query = $this->conn->prepare($sql);

            if($this->duplicate_record_exists('facilitator', [
                'user_id' => $user_id,
                'organization_id' => $organization_id,
                'course_year' => $course_year,
                'last_name' => $last_name,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'phone_number' => $phone_number,
                'dob' => $dob,
                'age' => $age
            ])){
                return false; // Duplicate record found
            }

            $query->bindParam(":user_id", $user_id);
            $query->bindParam(":organization_id", $organization_id);
            $query->bindParam(":last_name", $last_name);
            $query->bindParam(":first_name", $first_name);
            $query->bindParam(":middle_name", $middle_name);
            $query->bindParam(":phone_number", $phone_number);
            $query->bindParam(":dob", $dob);
            $query->bindParam(":age", $age);
            $query->bindParam(":course_year", $course_year);
            $query->execute();

        }

        function getCourse(){
            $sql = "SELECT * FROM course;";
            $query = $this->conn->prepare($sql);

            if($query->execute()){
                return true;
            } else {
                return false;
            }
        }

        function getOrganization() {
            $sql = "SELECT * FROM organization;";
            $query = $this->conn->prepare($sql);

            if($query->execute()){
                return true;
            } else {
                return false;
            }
        }
    }
?>