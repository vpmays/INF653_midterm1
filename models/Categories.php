<?php 
    class Categories {
        //DB stuff
        private $conn;
        private $table = 'categories';

        //Post Properties
        public $id;
        public $category;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get Posts
        public function read() {
            if ($this->id) {
                //Create query
                $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id= ?';
            } else {
                //Create query
                $query = 'SELECT id, category FROM ' . $this->table . ' ORDER BY id ASC';
            }

            //Prepared Statement
            $stmt = $this->conn->prepare($query);

            if ($this->id) {
                $stmt->bindParam(1, $this->id);
            }

            //Execute the query
            $stmt->execute();

            return $stmt;
        }

        //Create post
        public function create() {
            /*
            //create query 
            $query = 'INSERT INTO ' . $this->table . '(category) OVERRIDING SYSTEM VALUE 
            Values(:category)';
            */
            //create query 
            $query = 'INSERT INTO ' . $this->table . ' 
            SET 
                category = :category';
            

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind data
            $stmt->bindParam(':category', $this->category);

            //Exicute query
            if($stmt->execute()) {
                return true;
            } 

            //Print Error if something goes wrong
            printf("Error: %s./n", $stmt->error);

            return false;
        }

        //Update post
        public function update() {

            //create query 
            $query = 'UPDATE ' . $this->table . ' 
            SET 
                category = :category
            WHERE 
                id= :id';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            //Exicute query
            if($stmt->execute()) {
                return $stmt;
            } 

            //Print Error if something goes wrong
            printf("Error: %s./n", $stmt->error);

            return false;
        }

        //Delete Post
        public function delete() {

            //Creagte query
            $query = 'DELETE FROM ' . $this->table . '
            WHERE id = :id';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':id', $this->id);

            //Exicute query
            if($stmt->execute()) {
                return $stmt;
            } 

            //Print Error if something goes wrong
            printf("Error: %s./n", $stmt->error);

            return false;
        }
    }
?>