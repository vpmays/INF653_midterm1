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
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->db_name = getenv('DBNAME');
            $this->host = getenv('HOST');
            $this->port = getenv('PORT');
        }

        // DB connectg
        public function connect() {
            if ($this->conn) {
                return $this->conn;
            } else {

                $dsn = 'pgsql:host=XoaGKShplIxXAFGEeCffI8mrgbKkeUuA;port=5432;dbname=postgres1_0aq4';

                try {
                    $this->conn = new PDO($dsn, "vmays", "XoaGKShplIxXAFGEeCffI8mrgbKkeUuA");
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                } catch(PDOException $e) {
                    echo 'Connection Error: ' . $e->getMessage();
                }
            }
        }
    }
?>