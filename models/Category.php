<?php
    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $name;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $sql = 'SELECT * FROM ' . $this->table;

            $statement = $this->conn->prepare($sql);

            $statement->execute();

            return $statement;
        }

        public function read_single() {
            $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

            $statement = $this->conn->prepare($sql);
            $statement->bindParam(1, $this->id);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $this->name = $row['name'];
        }

        public function create() {
            $sql = 'INSERT INTO ' . $this->table . ' SET name = :name';
        
            $statement = $this->conn->prepare($sql);

            $this->name = htmlspecialchars(strip_tags($this->name));

            $statement->bindParam(':name', $this->name);

            if ($statement->execute()) {
                return true;
            } else {
                printf('Error: %s', $statement->error);
                return false;
            }
        }

        public function update() {
            $sql = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';
            $statement = $this->conn->prepare($sql);
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->id = htmlspecialchars(strip_tags($this->id));
            $statement->bindParam(':name', $this->name);
            $statement->bindParam(':id', $this->id);
            if ($statement->execute()) {
                return true;
            } else {
                printf('Error: %s', $statement->error);
                return false;
            }
        }

        public function delete() {
            $sql = 'DELETE FROM '.$this->table.' WHERE id = :id';

            $statement = $this->conn->prepare($sql);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $statement->bindParam(":id", $this->id);

            if ($statement->execute()) {
                return true;
            } else {
                printf('Error: %s', $statement->error);
                return false;
            }
        }
    }

?>