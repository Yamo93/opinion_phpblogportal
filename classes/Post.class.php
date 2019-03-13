<?php

class Post {
    private $db;

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
        $stmt = $this->db->prepare("INSERT INTO posts(title, description, content, user_id, category_id) VALUES(?, ?, ?, ?, ?)");

        $stmt->bind_param("sssdd", $title, $desc, $content, $userid, $categoryid);

        $result = $stmt->execute();
        if($stmt->error) { echo $stmt->error; }

        return $result;
    }
}

?>