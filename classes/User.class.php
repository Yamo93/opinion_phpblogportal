<?php

class User {
    private $db;

    function __construct() {
        //$pdo = new PDO('mysql:host=localhost;dbname=db_kurs(bka)', 'root', '');
        $this->db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD,DB_NAME);
        //Verbindung überprüfen
        if ($this->db->connect_errno)
        {
        printf("Fel vid anslutning", $mysqli->connect_error);
        exit();
        }
    }

    function registerUser($firstname, $lastname, $username, $password, $email) {
        $stmt = $this->db->prepare("INSERT INTO users(firstname, lastname, username, password, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstname, $lastname, $username, $password, $email);

        $result = $stmt->execute();

        return $result;
    }

}

?>