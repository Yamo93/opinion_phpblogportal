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

    function getUsername($id) {
        $sql = "SELECT username FROM users WHERE id = $id;";

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

    function uploadUserImg($username) {
        if(empty($_FILES)) {
            return false;
        }

        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {
            $target_dir = "uploadedimg/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
    
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
    
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $username . '.' . $imageFileType)) {
                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    
                    // Sparar filnamn i DB
                    $stmt = $this->db->prepare("INSERT INTO images(filename, user_id) VALUES(?, ?);");
                    $stmt->bind_param("sd", $filename, $user_id);
    
                    $filename = $username . '.' . $imageFileType;
                    echo "Filename: " . $filename . "<br>";
                    $user_id = $this->getUserID($username);
                    
    
                    $result = $stmt->execute();
    
                    return $result;
    
    
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

        } else {
            echo "Image not updated.";
        }
    }

    function isImgUploaded($user_id) {
        $sql = "SELECT * FROM images WHERE user_id = $user_id";
        $result = $this->db->query($sql);

        if($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getUserImgFilename($user_id) {
        $sql = "SELECT filename FROM images WHERE user_id = $user_id";
        $result = $this->db->query($sql);

        $result = $result->fetch_assoc();

        return $result['filename'];
    }

    function updateUserImg($username, $user_id) {
        if(empty($_FILES)) {
            return false;
        }

        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {
            // Radera användarens bild från mapp
            $filename = $this->getUserImgFilename($user_id);
            if(file_exists('./uploadedimg/' . $filename)) {
                unlink('./uploadedimg/' . $filename);
            } else {
                echo "couldnt remove file from folder";
                return false;
            }
    
            // Radera användarens föregående bild från db
            $sql = "DELETE FROM images WHERE user_id = $user_id";
            $result = $this->db->query($sql);
    
            if($result) { // filnamn är raderat från db
                $target_dir = "uploadedimg/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
        
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
        
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $username . '.' . $imageFileType)) {
                        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been updated.";
        
                        // Sparar filnamn i DB
                        $stmt = $this->db->prepare("INSERT INTO images(filename, user_id) VALUES(?, ?);");
                        $stmt->bind_param("sd", $filename, $user_id);
        
                        $filename = $username . '.' . $imageFileType;
                        echo "Filename: " . $filename . "<br>";
                        $user_id = $this->getUserID($username);
                        
        
                        $result = $stmt->execute();
        
                        return $result;
        
        
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
    
            }

        } else {
            echo "Image not updated.";
        }

    }


}

?>