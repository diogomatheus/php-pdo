<?php
include_once('model/Post.php');

class PostDAO {

    private $conn;

    public function __construct() {
        $registry = Registry::getInstance();
        $this->conn = $registry->get('Connection');
    }

    public function insert(Post $post) {
        $this->conn->beginTransaction();

        try {
            $stmt = $this->conn->prepare(
                'INSERT INTO posts (title, content) VALUES (:title, :content)'
            );

            $stmt->bindValue(':title', $post->getTitle());
            $stmt->bindValue(':content', $post->getContent());
            $stmt->execute();

            $this->conn->commit();
        }
        catch(Exception $e) {
            $this->conn->rollback();
        }
    }

    public function getAll() {
        $statement = $this->conn->query(
            'SELECT * FROM posts'
        );

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if($statement) {
            while($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $post = new Post();

                $post->setId($row->post_id);
                $post->setTitle($row->title);
                $post->setContent($row->content);

                $results[] = $post;
            }
        }

        return $results;
    }

}

