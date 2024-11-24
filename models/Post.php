<?php
    class Post {
        private $conn;
        private $table = 'posts';

        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $sql = '
                SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM 
                    ' . $this->table . ' p
                LEFT JOIN 
                    categories c ON p.category_id = c.id
                ORDER BY 
                    p.created_at DESC
            ';

            $statement = $this->conn->prepare($sql);

            $statement->execute();
            
            return $statement;
        }

        public function read_single() {
            $sql = '
                SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM 
                    ' . $this->table . ' p
                LEFT JOIN 
                    categories c ON p.category_id = c.id
                WHERE
                    p.id = ?
            ';

            $statement = $this->conn->prepare($sql);

            $statement->bindParam(1, $this->id);

            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];


        }

        public function create() {
            $sql = '
                INSERT INTO '.$this->table.'
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
            ';

            $statement = $this->conn->prepare($sql);

            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            $statement->bindParam(':title', $this->title);
            $statement->bindParam(':body', $this->body);
            $statement->bindParam(':author', $this->author);
            $statement->bindParam(':category_id', $this->category_id);

            if ($statement->execute()) {
                return true;
            }

            printf('Error: %s', $statement->error);

            return false;

        }

        public function update() {
            $sql = '
            UPDATE '.$this->table.'
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE 
                id = :id
            ';

            $statement = $this->conn->prepare($sql);

            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $statement->bindParam(":id", $this->id);
            $statement->bindParam(':title', $this->title);
            $statement->bindParam(':body', $this->body); 
            $statement->bindParam(':author', $this->author); 
            $statement->bindParam(':category_id', $this->category_id); 

            if ($statement->execute()) {
                return true;
            } else {
                printf('Error: %s', $statement->error);
                return false;
            }

        }

        public function delete() {
            $sql = '
            DELETE FROM '.$this->table.'
            WHERE 
                id = :id
            ';

            $statement = $this->conn->prepare($sql);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $statement->bindParam(':id', $this->id);

            if ($statement->execute()) {
                return true;
            } else {
                printf('Error: %s', $statement->error);
                return false;
            }
        }
    }

?>