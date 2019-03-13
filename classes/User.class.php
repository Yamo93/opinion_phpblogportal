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

    function registerUser($firstname, $lastname, $username, $password, $email) {

        $stmt = $this->db->prepare("INSERT INTO users(firstname, lastname, username, password, email) VALUES (?, ?, ?, ?, ?)");

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bind_param("sssss", $firstname, $lastname, $username, $password, $email);

        $result = $stmt->execute();

        return $result;
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

}

?>