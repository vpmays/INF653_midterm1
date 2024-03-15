<?php 
    class Quotes {
        //DB stuff
        private $conn;
        private $table = 'quotes';

        //Quote Properties
        public $id;
        public $quote;
        public $author_id;
        public $author_name;
        public $author_exists;
        public $category_id;
        public $category_name;
        public $category_exists;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get Posts
        public function read() {
            
            if (($this->author_id) && ($this->category_id)) {
            //Create query
                $query = 'SELECT a.author AS author_name, c.category AS category_name, q.id, q.quote 
                FROM ' . $this->table . ' q LEFT JOIN authors a ON q.author_id=a.id LEFT JOIN categories c ON q.category_id=c.id WHERE q.author_id = ? AND q.category_id = ? ORDER BY q.id ASC';
                //$query = 'SELECT id, quote FROM ' . $this->table;
            } else if ($this->author_id) {
                //Create query
                $query = 'SELECT a.author AS author_name, c.category AS category_name, q.id, q.quote 
                FROM ' . $this->table . ' q LEFT JOIN authors a ON q.author_id=a.id LEFT JOIN categories c ON q.category_id=c.id WHERE q.author_id = ? ORDER BY q.id ASC';
                //$query = 'SELECT id, quote FROM ' . $this->table;
            } else if ($this->category_id) {
                //Create query
                $query = 'SELECT a.author AS author_name, c.category AS category_name, q.id, q.quote 
                FROM ' . $this->table . ' q LEFT JOIN authors a ON q.author_id=a.id LEFT JOIN categories c ON q.category_id=c.id WHERE q.category_id = ? ORDER BY q.id ASC';
                //$query = 'SELECT id, quote FROM ' . $this->table;
            } else if ($this->id) {
                //Create query
                $query = 'SELECT a.author AS author_name, c.category AS category_name, q.id, q.quote 
                FROM ' . $this->table . ' q LEFT JOIN authors a ON q.author_id=a.id LEFT JOIN categories c ON q.category_id=c.id WHERE q.id = ?';
                //$query = 'SELECT id, quote FROM ' . $this->table;
            } else {
                $query = 'SELECT a.author AS author_name, c.category AS category_name, q.id, q.quote 
                FROM ' . $this->table . ' q LEFT JOIN authors a ON q.author_id=a.id LEFT JOIN categories c ON q.category_id=c.id ORDER BY q.id ASC';
            }

            //Prepared Statement
            $stmt = $this->conn->prepare($query);
            
            if (($this->author_id) && ($this->category_id)) {
                $stmt->bindParam(1, $this->author_id);
                $stmt->bindParam(2, $this->category_id);
            } else if ($this->author_id) {
                $stmt->bindParam(1, $this->author_id);
            } else if ($this->category_id) {
                $stmt->bindParam(1, $this->category_id);
            } else if ($this->id) {
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
            $query = 'INSERT INTO ' . $this->table . ' 
            SET 
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id';
            */
            
            $query2 = 'SELECT COUNT(*) FROM authors WHERE id = :author_id2';

            $stmt2 = $this->conn->prepare($query2);
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $stmt2->bindParam(':author_id2', $this->author_id);
            $stmt2->execute();
            $this->author_exists = $stmt2->fetchcolumn();
            if ($this->author_exists == 0) {
                return true;
            } else {
                $query3 = 'SELECT COUNT(*) FROM categories WHERE id = :category_id2';

                $stmt3 = $this->conn->prepare($query3);
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $stmt3->bindParam(':category_id2', $this->category_id);
                $stmt3->execute();
                $this->category_exists = $stmt3->fetchcolumn();
                if ($this->category_exists == 0) {
                    return true;
                } else {
                
                    //create query 
                    $query = 'INSERT INTO ' . $this->table . '(quote, author_id, category_id) OVERRIDING SYSTEM VALUE 
                    Values(:quote, :author_id, :category_id)';

                    //Prepare Statement
                    $stmt = $this->conn->prepare($query);

                    //Clean Data
                    $this->quote = htmlspecialchars(strip_tags($this->quote));
                    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                    $this->category_id = htmlspecialchars(strip_tags($this->category_id));

                    //Bind data
                    $stmt->bindParam(':quote', $this->quote);
                    $stmt->bindParam(':author_id', $this->author_id);
                    $stmt->bindParam(':category_id', $this->category_id);

                    //Exicute query
                    if($stmt->execute()) {
                        $this->id = $this->conn->lastInsertId();
                        return true;
                    } 
                }
            }
            //Print Error if something goes wrong
            printf("Error: %s./n", $stmt->error);
            
            return false;
        }

        //Update post
        public function update() {

            $query2 = 'SELECT COUNT(*) FROM authors WHERE id = :author_id2';

            $stmt2 = $this->conn->prepare($query2);
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $stmt2->bindParam(':author_id2', $this->author_id);
            $stmt2->execute();
            $this->author_exists = $stmt2->fetchcolumn();
            if ($this->author_exists == 0) {
                return true;
            } else {
                $query3 = 'SELECT COUNT(*) FROM categories WHERE id = :category_id2';

                $stmt3 = $this->conn->prepare($query3);
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $stmt3->bindParam(':category_id2', $this->category_id);
                $stmt3->execute();
                $this->category_exists = $stmt3->fetchcolumn();
                if ($this->category_exists == 0) {
                    return true;
                } else {
                    //create query 
                    $query = 'UPDATE ' . $this->table . ' 
                    SET 
                        quote = :quote,
                        author_id = :author_id,
                        category_id = :category_id
                    WHERE 
                        id= :id';

                    //Prepare Statement
                    $stmt = $this->conn->prepare($query);

                    //Clean Data
                    $this->quote = htmlspecialchars(strip_tags($this->quote));
                    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                    $this->id = htmlspecialchars(strip_tags($this->id));

                    //Bind data
                    $stmt->bindParam(':quote', $this->quote);
                    $stmt->bindParam(':author_id', $this->author_id);
                    $stmt->bindParam(':category_id', $this->category_id);
                    $stmt->bindParam(':id', $this->id);

                    //Exicute query
                    if($stmt->execute()) {
                        return $stmt;
                    }
                }
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