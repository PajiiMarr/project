<?php
    class Database {
        protected $connection;
        
        function connect() {
            try {
                $db = new PDO("mysql:host=localhost;dbname=opms;", "root", "");
                echo "Connection Success!";
            } catch (PDOException $e) {
                echo "Connection Failed! " . $e->getMessage();
            }
            return $this->connection;
        }
    }
?>

