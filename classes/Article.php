<?php
require_once 'Database.php';

class Article {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addArticle($title, $content) {
        $created_at = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO articles (title, content, created_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $created_at);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getArticleById($id) {
        $sql = "SELECT * FROM articles WHERE id = $id";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>