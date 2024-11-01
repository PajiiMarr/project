<?php
    require_once 'database.class.php';

    class Signup {
        private $conn;
        
        function __construct (){
            $db = new Database;
            $this->conn = $db->connect();
        }

        function login($email, $password) {
            $sql = "SELECT user_id, password, is_facilitator, is_student FROM user WHERE email = :email LIMIT 1;";
            $query = $this->conn->prepare($sql);
            $query->bindParam(':email', $email);
            $query->execute();
            
            $user = $query->fetch();
    
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'is_facilitator' => $user['is_facilitator'],
                    'is_student' => $user['is_student']
                ];
                $date = date('Y-m-d H:i:s');
                $sql_update = "UPDATE user SET date_updated = :date_updated WHERE user_id = :user_id;";
                $query_update = $this->conn->prepare($sql_update);
                $query_update->bindParam(':user_id', $_SESSION['user']['user_id']);
                $query_update->bindParam(':date_updated', $date);
                $query_update->execute();
                
                if ($user['is_facilitator'] == 1) {
                    header('Location: facilitator.php');
                } else {
                    header('Location: student.php');
                }
                session_write_close();
                exit;
            } else {
                echo "Incorrect credentials!";
                return false;
            }
        }

        function sign_up($email, $password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(email, password, date_created) VALUES (:email, :password, NOW());";
            $query = $this->conn->prepare($sql);

            if($this->duplicate_record_exists('user', [
                'email' => $email
            ])){
                return false;
            }
            
            $query->bindParam(":email",$email);
            $query->bindParam(":password",$hashed_password);
            
            if($query->execute()){
                $user_id = $this->conn->lastInsertId();
                $_SESSION['user_id'] = $user_id;
                session_write_close();
                header('Location: profiling.php');
                return true;
            } else {
                return false;
            }
        }

        function update_user_type($is_student, $is_facilitator, $user_id){
            $sql_type = "UPDATE user SET is_student = :is_student, is_facilitator = :is_facilitator WHERE user_id = :user_id;";
            $query_type = $this->conn->prepare($sql_type);

            $query_type->bindParam(":is_student",$is_student);
            $query_type->bindParam(":is_facilitator",$is_facilitator);
            $query_type->bindParam(":user_id",$user_id);

            $query_type->execute();
        }

        function set_profile($user_id, $course_id, $course_year, $last_name, $first_name, $middle_name, $phone_number, $dob, $age, $course_section){
            $sql_stud = "INSERT INTO student(student_id, course_id, last_name, first_name, middle_name, phone_number, dob, age, course_year, course_section)
                         VALUES (:user_id, :course_id, :last_name, :first_name, :middle_name, :phone_number, :dob, :age, :course_year, :course_section);";
            $query_stud = $this->conn->prepare($sql_stud);

            $_SESSION['user'] = [
                'user_id' => $_SESSION['user_id'],
                'is_facilitator' => $_SESSION['user_type']['is_facilitator'],
                'is_student' => $_SESSION['user_type']['is_student']
            ];

            $query_stud->bindParam(":user_id", $user_id);
            $query_stud->bindParam(":course_id", $course_id);
            $query_stud->bindParam(":last_name", $last_name);
            $query_stud->bindParam(":first_name", $first_name);
            $query_stud->bindParam(":middle_name", $middle_name);
            $query_stud->bindParam(":phone_number", $phone_number);
            $query_stud->bindParam(":dob", $dob);
            $query_stud->bindParam(":age", $age);
            $query_stud->bindParam(":course_year", $course_year);
            $query_stud->bindParam(":course_section", $course_section);

            $query_stud->execute();

            $sql_date_updated = "UPDATE user SET date_updated = :date_updated WHERE user_id = :user_id";
            $query_date_updated = $this->conn->prepare($sql_date_updated);

            $current_date = date('Y-m-d H:i:s');

            $query_date_updated->bindParam(':date_updated', $current_date);
            $query_date_updated->bindParam(':user_id', $user_id);

            $query_date_updated->execute();

            $organization = $this->getOrganization();
            
            foreach($organization as $org){
                extract($org);
                $sql_stud_org = "INSERT INTO student_organization(student_id, organization_id) VALUES(:user_id, :organization_id);";
                $query_stud_org = $this->conn->prepare($sql_stud_org);
                
                $query_stud_org->bindParam(':user_id', $user_id);
                $query_stud_org->bindParam(':organization_id', $organization_id);

                $query_stud_org->execute();

                $sql_stud_org_pmt = "SELECT * FROM student_organization WHERE student_id = :user_id AND organization_id = :organization_id;";
                $query_stud_org_pmt = $this->conn->prepare($sql_stud_org_pmt);
                $query_stud_org_pmt->bindParam(':user_id', $user_id);
                $query_stud_org_pmt->bindParam(':organization_id', $organization_id);
                $query_stud_org_pmt->execute();

                $payment = $query_stud_org_pmt->fetch();

                $sql_pmt_first_sem = "INSERT INTO payment(student_org_id, semester) VALUES(:stud_org_id, 'First Semester');";
                $query_pmt_first_sem = $this->conn->prepare($sql_pmt_first_sem);

                $query_pmt_first_sem->bindParam(':stud_org_id', $payment['stud_org_id']);

                $query_pmt_first_sem->execute();

                $sql_pmt_second_sem = "INSERT INTO payment(student_org_id, semester) VALUES(:stud_org_id, 'Second Semester');";
                $query_pmt_second_sem = $this->conn->prepare($sql_pmt_second_sem);

                $query_pmt_second_sem->bindParam(':stud_org_id', $payment['stud_org_id']);

                $query_pmt_second_sem->execute();
            }
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
        

        function set_facilitator($user_id, $organization_id, $course_id, $last_name, $first_name, $middle_name, $phone_number, $dob, $age, $course_year, $course_section){
            $sql = "INSERT INTO facilitator VALUES (:user_id, :organization_id, :course_id, :last_name, :first_name, :middle_name, :phone_number, :dob, :age, :course_year, :course_section);";
            $query = $this->conn->prepare($sql);

            // if($this->duplicate_record_exists('facilitator', [
            //     'facilitator_id' => $user_id,
            //     'organization_id' => $organization_id,
            //     'course_id' => $course_id,
            //     'course_year' => $course_year,
            //     'last_name' => $last_name,
            //     'first_name' => $first_name,
            //     'middle_name' => $middle_name,
            //     'phone_number' => $phone_number,
            //     'dob' => $dob,
            //     'age' => $age,
            //     'course_section' => $course_section
            // ])){
            //     return false; // Duplicate record found
            // }

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

        function getCourse(){
            $sql = "SELECT * FROM course;";
            $query = $this->conn->prepare($sql);

            if($query->execute()){
                return $query->fetchAll();
            } else {
                return false;
            }
        }

        function getOrganization() {
            $sql = "SELECT * FROM organization;";
            $query = $this->conn->prepare($sql);

            if($query->execute()){
                return $query->fetchAll();
            } else {
                return false;
            }
        }

        function getUser($user_id) {
            $sql = 'SELECT user_id, user_type FROM user WHERE user_id = :user_id';
            $query = $this->conn->prepare($sql);

            $query->bindParam(':user_id', $user_id);

            if($query->execute()){
                return $query->fetch();
            } else {
                return false;
            }
        }
    }
?>