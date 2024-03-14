<?php
    class Database {
        //DB params
        private $host = 'localhost';
        private $db_name = 'quotesdb';
        //private $port = '5432';
        private $username = 'root';
        private $password = '';
        private $conn;

        public function connect() {
            $this->conn= null;
            $dsn = "mysql:host={$this->host};dbname={$this->db_name}";

            try {
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->conn;
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }
            return $this->conn;      
        }
    }
        /*
        // DB connectg
        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->conn;
        }
    }
    */
?>
