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

    function uploadUserImg($username, $thumb = false, $thumb_folder = '', $thumb_width = '', $thumb_height = '') {
        if(empty($_FILES)) {
            return false;
        }

        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {
            // $target_dir = "img/uploadedimg/"; // lokalt
            $target_dir = "../../writeable/uploadedimg/"; // publikt
            
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
    
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "Filen är en bild - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "Filen är inte en bild.";
                $uploadOk = 0;
            }
    
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Tyvärr, filen existerar redan.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 2000000) {
                echo "Tyvärr, filen är för stor.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Tyvärr, de enda giltiga formaten är JPG, JPEG, PNG och GIF.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Tyvärr, din bild har ej laddats upp.";
            // if everything is ok, try to upload file
            } else {
                $pathAndFilename = $target_dir . $username . '.' . $imageFileType;
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $pathAndFilename)) {
                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " har laddats upp.";
    
                    // Sparar filnamn i DB
                    $stmt = $this->db->prepare("INSERT INTO images(filename, user_id) VALUES(?, ?);");
                    $stmt->bind_param("sd", $filename, $user_id);
    
                    $filename = $username . '.' . $imageFileType;
                    echo "Filename: " . $filename . "<br>";
                    $user_id = $this->getUserID($username);
                    
    
                    $result = $stmt->execute();

                    // Skapar thumbnail
                    if($thumb == true)
                    {
                        $thumbnail = $thumb_folder.$filename;
                        list($width,$height) = getimagesize($pathAndFilename);
                        $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
                        switch($imageFileType){
                            case 'jpg':
                                $source = imagecreatefromjpeg($pathAndFilename);
                                break;
                            case 'jpeg':
                                $source = imagecreatefromjpeg($pathAndFilename);
                                break;
            
                            case 'png':
                                $source = imagecreatefrompng($pathAndFilename);
                                break;
                            case 'gif':
                                $source = imagecreatefromgif($pathAndFilename);
                                break;
                            default:
                                $source = imagecreatefromjpeg($pathAndFilename);
                        }
            
                        imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
                        switch($imageFileType){
                            case 'jpg' || 'jpeg':
                                imagejpeg($thumb_create,$thumbnail,100);
                                break;
                            case 'png':
                                imagepng($thumb_create,$thumbnail,100);
                                break;
            
                            case 'gif':
                                imagegif($thumb_create,$thumbnail,100);
                                break;
                            default:
                                imagejpeg($thumb_create,$thumbnail,100);
                        }
            
                    }
    
                    return $result;
    
    
                } else {
                    echo "Något gick fel vid bilduppladdningen.";
                }
            }

        } else {
            echo "Bild ej uppdaterad.";
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

    function updateUserImg($username, $user_id, $thumb = false, $thumb_folder = '', $thumb_width = '', $thumb_height = '') {
        if(empty($_FILES)) {
            return false;
        }

        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {
            // Radera användarens bild från mapp
            $filename = $this->getUserImgFilename($user_id);
            // if(file_exists('./img/uploadedimg/' . $filename)) {
            //     unlink('./img/uploadedimg/' . $filename);
            //     unlink('./img/uploadedimg/thumbs/' . $filename);
            if(file_exists('../../writeable/uploadedimg/' . $filename)) {
                unlink('../../writeable/uploadedimg/' . $filename);
                unlink('../../writeable/uploadedimg/thumbs/' . $filename);

            } else {
                echo "couldnt remove file from folder";
                return false;
            }
    
            // Radera användarens föregående bild från db
            $sql = "DELETE FROM images WHERE user_id = $user_id";
            $result = $this->db->query($sql);
    
            if($result) { // filnamn är raderat från db
                // $target_dir = "img/uploadedimg/";
                $target_dir = "../../writeable/uploadedimg/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
        
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "Filen är en bild - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "Filen är inte en bild.";
                    $uploadOk = 0;
                }
        
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Tyvärr, filen existerar redan.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 2000000) {
                    echo "Tyvärr, filen är för stor.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Tyvärr, de enda giltiga formaten är JPG, JPEG, PNG och GIF.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Tyvärr, din bild har ej laddats upp.";
                // if everything is ok, try to upload file
                } else {
                    $pathAndFilename = $target_dir . $username . '.' . $imageFileType;
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $pathAndFilename)) {
                        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " har uppdaterats.";
        
                        // Sparar filnamn i DB
                        $stmt = $this->db->prepare("INSERT INTO images(filename, user_id) VALUES(?, ?);");
                        $stmt->bind_param("sd", $filename, $user_id);
        
                        $filename = $username . '.' . $imageFileType;
                        echo "Filename: " . $filename . "<br>";
                        $user_id = $this->getUserID($username);
                        
        
                        $result = $stmt->execute();

                    // Skapar thumbnail
                    if($thumb == true)
                    {
                        $thumbnail = $thumb_folder.$filename;
                        list($width,$height) = getimagesize($pathAndFilename);
                        $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
                        switch($imageFileType){
                            case 'jpg':
                                $source = imagecreatefromjpeg($pathAndFilename);
                                break;
                            case 'jpeg':
                                $source = imagecreatefromjpeg($pathAndFilename);
                                break;
            
                            case 'png':
                                $source = imagecreatefrompng($pathAndFilename);
                                break;
                            case 'gif':
                                $source = imagecreatefromgif($pathAndFilename);
                                break;
                            default:
                                $source = imagecreatefromjpeg($pathAndFilename);
                        }
            
                        imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
                        switch($imageFileType){
                            case 'jpg' || 'jpeg':
                                imagejpeg($thumb_create,$thumbnail,100);
                                break;
                            case 'png':
                                imagepng($thumb_create,$thumbnail,100);
                                break;
            
                            case 'gif':
                                imagegif($thumb_create,$thumbnail,100);
                                break;
                            default:
                                imagejpeg($thumb_create,$thumbnail,100);
                        }
            
                    }
        
                        return $result;
        
        
                    } else {
                        echo "Något gick fel vid bilduppladdning.";
                    }
                }
    
            }

        } else {
            echo "Bild ej uppdaterad.";
        }

    }


}

?>