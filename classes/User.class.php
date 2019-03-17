<?php

class User {
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

    function isUsernameTaken($username) {
        $sql = "SELECT * FROM users WHERE username = '$username'";

        $result = $this->db->query($sql);

        if($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }

    }

    function registerUser($firstname, $lastname, $username, $password, $email) {

        $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
        $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if(strlen($username) < 5) {
            return [
                'arrayResult' => false,
                'alertClass' => 'danger',
                'alertMessage' => 'Användarnamnet är mindre än fem tecken.'
            ];
        }

        if(strlen($password) < 7) {
            return [
                'arrayResult' => false,
                'alertClass' => 'danger',
                'alertMessage' => 'Lösenordet är mindre än sju tecken.'
            ];
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))  {
            return [
                'arrayResult' => false,
                'alertClass' => 'danger',
                'alertMessage' => 'Mejladressen är felaktig.'
            ];
        }

        if($this->isUsernameTaken($username)) {
            return [
                'arrayResult' => false,
                'alertClass' => 'danger',
                'alertMessage' => 'Användarnamnet är upptaget.'
            ];
        }

        $stmt = $this->db->prepare("INSERT INTO users(firstname, lastname, username, password, email) VALUES (?, ?, ?, ?, ?)");

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bind_param("sssss", $firstname, $lastname, $username, $password, $email);

        $result = $stmt->execute();

        if($result) {
            return [
                'arrayResult' => $result,
                'alertClass' => 'success',
                'alertMessage' => 'Användare skapad!'
            ];
        } else {
            return [
                'arrayResult' => $result,
                'alertClass' => 'danger',
                'alertMessage' => 'Registreringen lyckades ej.'
            ];
        }

    }

    function loginUser($username, $password) {
        $password = $this->db->real_escape_string($password);
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");

        $stmt->bind_param("s", $username);

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if(password_verify($password, $row['password'])) {
            return true;
        } else {
            return false;
        }
    }

    function getUserID($username) {
        $sql = "SELECT id FROM users WHERE username = '$username';";

        $result = $this->db->query($sql);
        $result = $result->fetch_assoc();

        return $result['id'];
    }

    function getUserInfo($id) {
        $sql = "SELECT * FROM users WHERE id = $id;";

        $result = $this->db->query($sql);

        $result = $result->fetch_assoc();

        return $result;
    }

    function getUserInfoFromPostID($postid) {
        $sql = "SELECT * FROM users WHERE id = (SELECT user_id FROM posts WHERE id = $postid)";

        $result = $this->db->query($sql);

        $result = $result->fetch_assoc();

        return $result;
    }

    function getAllUsers() {
        $sql = "SELECT * FROM users";

        $result = $this->db->query($sql);

        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    function countUsers() {
        $sql = "SELECT count(username) as amountusers FROM users";

        $result = $this->db->query($sql);

        $result = $result ->fetch_assoc();

        return $result;
    }
    
    function countUserPosts($userid) {
        $sql = "SELECT count(id) AS amountposts FROM posts WHERE user_id = $userid";

        $result = $this->db->query($sql);
    
        $result = $result ->fetch_assoc();
    
        return $result;
    }

    function countUserComments($userid) {
        // Implement logic
    }


}

?>