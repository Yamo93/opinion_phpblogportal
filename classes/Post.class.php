<?php

class Post {
    private $db;
    private $posts = [];

    function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD,DB_NAME);

        // Error case
        if ($this->db->connect_errno)
        {
        printf("Fel vid anslutning", $mysqli->connect_error);
        exit();
        }
    }

    function addPost($title, $desc, $content, $userid, $categoryid = 1) {
        $categoryid = intval($categoryid);
        $stmt = $this->db->prepare("INSERT INTO posts(title, description, content, user_id, category_id) VALUES(?, ?, ?, ?, ?)");

        $stmt->bind_param("sssdd", $title, $desc, $content, $userid, $categoryid);

        $result = $stmt->execute();
        if($stmt->error) { echo $stmt->error; }

        return $result;
    }

    function getPosts($limit = 99) {
        $sql = "SELECT * FROM posts ORDER BY created_date DESC LIMIT $limit";

        if(!$result = $this->db->query($sql)){
            die('Fel vid SQL-fråga [' . $this->db->error . ']');
        }

        while($row = $result->fetch_assoc()) {
            $this->posts[] = $row;
        }

        return $this->posts;
    }

    function getPost($id) {
        $sql = "SELECT * FROM posts WHERE id = $id";

        if(!$result = $this->db->query($sql)){
            die('Fel vid SQL-fråga [' . $this->db->error . ']');
        }

        $result = $result->fetch_assoc();

        return $result;
    }

    function editPost($id, $title, $desc, $content, $categoryid) {
        $categoryid = intval($categoryid);
        $id = intval($id);

        $stmt = $this->db->prepare("UPDATE posts SET title=?,description=?, content=?,category_id=? WHERE id = ?;");
        $stmt->bind_param("sssdd", $title, $desc, $content, $categoryid, $id);

        $result = $stmt->execute();
        if($stmt->error) { echo $stmt->error; }

        return $result;
    }

    function deletePost($id) {
        $id = intval($id);

        $sql = "DELETE FROM posts WHERE id = $id;";

        $result = $this->db->query($sql);

        return $result;
    }

    function getCategoryName($categoryid) {
        $categoryid = intval($categoryid);
        $sql = "SELECT name FROM categories WHERE id = $categoryid;";

        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();

        return $row['name'];
    }
}

?>