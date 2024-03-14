<?php
    class Database {
        //DB params
        
        private $host;
        private $port;
        private $db_name;
        private $username;
        private $password;
        private $conn;
        
        //
        public function __construct() {
            $this->username = trim(getenv('USERNAME'), '"');
            $this->password = trim(getenv('PASSWORD'), '"');
            $this->db_name = trim(getenv('DBNAME'), '"');
            $this->host = trim(getenv('HOST'), '"');
            $this->port = trim(getenv('PORT'), '"');
        }

        // DB connectg
        public function connect() {
            if ($this->conn) {
                return $this->conn;
            } else {

                $dsn = 'pgsql:host=' . $this->host . ';port=5432;dbname=' . $this->db_name . '';

                try {
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                } catch(PDOException $e) {
                    echo 'Connection Error: ' . $e->getMessage();
                }
            }
        }
    }
?>