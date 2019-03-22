<?php
    session_start();
    /* Lokal utveckling */
    // define("DB_HOST", 'localhost');
    // define("DB_USERNAME", 'root');
    // define("DB_PASSWORD", 'yamo123');
    // define("DB_NAME", 'opinion_blogportal');

    /* Publikt */
    define("DB_HOST", 'studentmysql.miun.se');
    define("DB_USERNAME", 'yage1800');
    define("DB_PASSWORD", 'j9jxpj24');
    define("DB_NAME", 'yage1800');
    
    function my_autoloader($class) {
        include '../classes/' . $class . '.class.php';
    }
    
    spl_autoload_register('my_autoloader');

      // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $post = new Post();
    $user = new User();

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Filtrerar input
    $data->postID = filter_var($data->postID, FILTER_SANITIZE_NUMBER_INT);
    $data->content = filter_var($data->content, FILTER_SANITIZE_STRING);

    // Tilldelar egenskaperna de nya värdena
    $post->postID = $data->postID;
    $post->userID = $user->getUserID($_SESSION['username']);
    $post->commentContent = $data->content;

    if($post->addCommentAPI()) {
        // Ladda in de uppdaterade kommentarerna
        $postArray = $post->loadCommentsAPI();

        if(isset($postArray['result']) && $postArray['result']->num_rows === 1) {
    
            $userinfo = $user->getUserInfo($postArray['fetchedArray']['user_id']);
            // print_r($userinfo); // användarinformation
            $postArray['fetchedArray']['username'] = $userinfo['username'];
            $postArray['fetchedArray']['firstname'] = $userinfo['firstname'];
            $postArray['fetchedArray']['lastname'] = $userinfo['lastname'];
            $postArray['fetchedArray']['filename'] = $user->getUserImgFilename($postArray['fetchedArray']['user_id']);
    
            print_r(json_encode($postArray['fetchedArray']));
    
        } else {
    
            foreach($postArray as $post => $val) {
            $userinfo = $user->getUserInfo($val['user_id']);
            $val['username'] = $userinfo['username'];
            $val['firstname'] = $userinfo['firstname'];
            $val['lastname'] = $userinfo['lastname'];
            $val['filename'] = $user->getUserImgFilename($val['user_id']);
            $array[$post] = json_decode(json_encode($val));
            }
    
            print_r(json_encode($array));
        }
    } else {
        die();
    }

    // print_r(json_encode($postArray));

    

?>