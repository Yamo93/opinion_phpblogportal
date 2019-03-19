<?php

class Post {
    private $db;
    private $posts = [];
    public $postID;
    public $reactionType;
    public $userID;
    public $numLikes;
    public $numDislikes;
    public $userHasReacted;
    public $numComments;


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

    function getPostsFromCategory($categoryid, $limit = 99) {
        $sql = "SELECT * FROM posts WHERE category_id = $categoryid ORDER BY created_date DESC LIMIT $limit";

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

    function getPostsFromUser($user_id) {
        $sql = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_date DESC";

        $result = $this->db->query($sql);

        if($result->num_rows > 1) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            
        return $rows;

        } elseif($result->num_rows == 1) {
            return $result;
        } else {
            return false;
        }
        
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

    function getCategories() {
        $sql = "SELECT * FROM categories";

        $result = $this->db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    function countPosts() {
        $sql = "SELECT count(id) as amountposts FROM posts";

        $result = $this->db->query($sql);

        $result = $result ->fetch_assoc();

        return $result;
    }

    function recordPostVisit($ip, $post_id) {
        // Kontrollerar om ip-adressen redan finns
        $sql = "SELECT * FROM visits WHERE visitor_ip_address = '$ip' AND post_id = $post_id";

        $result = $this->db->query($sql);

        if($result->num_rows > 0) {
            // Ip-adressen finns redan
            return false;
        } else {
            // Spara ip-adressen
            $sql = "INSERT INTO visits(post_id, visitor_ip_address) VALUES($post_id, '$ip')";

            $result = $this->db->query($sql);

            return $result;
        }
    }

    function countPostVisits($post_id) {
        $sql = "SELECT count(id) AS amountvisits FROM visits WHERE post_id = $post_id";
        $result = $this->db->query($sql);
        $result = $result->fetch_assoc();

        return $result;
    }

    function orderPopularTopics() {
        // Figure out a way to collect counts for one specific post, and then order them. Maybe with a mysql trigger... Can they store arrays?
        $sql = "SELECT
        category_id,
        COUNT(*) AS amountcategoryposts
    FROM
        posts
    GROUP BY
        category_id
    ORDER BY
        amountcategoryposts DESC LIMIT 3;"; // this calculates the three hottest topics on the site

        $result = $this->db->query($sql);
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    function orderPopularPosts() {
        $sql = "SELECT
        post_id,
        COUNT(*) AS popularposts
    FROM
        visits
    GROUP BY
        post_id
    ORDER BY
        popularposts DESC LIMIT 3"; // this (hopefully) calculates the hottest posts on the site

    }

    function loadReactionsAPI() {
        $sql = "SELECT 
        (SELECT count(*) FROM reactions WHERE type = 1 AND post_id = " . $this->postID . ") as likes,
        (SELECT count(*) FROM reactions WHERE type = 2 AND post_id = " . $this->postID . ")  as dislikes;";

        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();

        $this->numLikes = $row['likes'];
        $this->numDislikes = $row['dislikes'];

        //Kontrollera om användaren redan har reagerat tidigare
        $stmt = $this->db->prepare("SELECT * FROM reactions WHERE user_id = ? AND post_id = ?");
        $stmt->bind_param("dd", $this->userID, $this->postID);

        $stmt->execute();
        $stmt->store_result();
        // $stmt_result = $stmt->get_result() or trigger_error($stmt->error, E_USER_ERROR);

        if($stmt->num_rows>0) {
            $stmt->bind_result($id, $type, $user_id, $post_id);
            $stmt->fetch();
            $this->userHasReacted = [
                'id' => $id,
                'type' => $type,
                'user_id' => $user_id,
                'post_id' => $post_id
            ];
            
            return false;
        }
        return true;
    }

    function addReactionAPI() {

        //Kontrollera om användaren redan har reagerat tidigare
        $stmt = $this->db->prepare("SELECT * FROM reactions WHERE user_id = ? AND post_id = ?");
        $stmt->bind_param("dd", $this->userID, $this->postID);

        $stmt->execute();
        $stmt_result = $stmt->get_result() or trigger_error($stmt->error, E_USER_ERROR);

        if($stmt_result->num_rows>0) {
            // Användare har redan reagerat (här kan man möjligtvis OGILLA / byta typ av reaktion beroende på vad man klickar)
            return false;
        } else {
            // Lägg till reaktion
            $stmt = $this->db->prepare("INSERT INTO reactions(type, user_id, post_id) VALUES(?, ?, ?);");
            $stmt->bind_param("ddd", $this->reactionType, $this->userID, $this->postID);
            $result = $stmt->execute();
            return $result;
        }

    }

    function loadCommentsAPI() {

        $sql = "SELECT * FROM comments WHERE post_id = " . $this->postID . " ORDER BY date DESC;";
        $result = $this->db->query($sql);

        if(!$result = $this->db->query($sql)){
            die('Fel vid SQL-fråga [' . $this->db->error . ']');
        }

        if($result->num_rows == 1) {
            return [
                'result' => $result,
                'fetchedArray' => $result->fetch_assoc()
            ];
        } elseif($result->num_rows > 1) {
            // $comments[] = $result->num_rows;
            while($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }

        }
        
        return $comments;
    }
}

?>