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
    $post->postID = $data->postID;
    $post->userID = $user->getUserID($_SESSION['username']);

    if($post->addBookmarkAPI()) {
        // Ladda in de uppdaterade bokmärken
        $postArray = $post->loadBookmarksAPI();

        if(isset($postArray['result']) && $postArray['result']->num_rows === 1) {
    
            $authorinfo = $user->getUserInfoFromPostID($postArray['fetchedArray']['post_id']);

            $postinfo = $post->getPost($postArray['fetchedArray']['post_id']);
    
            $postArray['fetchedArray']['title'] = $postinfo['title'];
            $postArray['fetchedArray']['firstname'] = $authorinfo['firstname'];
            $postArray['fetchedArray']['lastname'] = $authorinfo['lastname'];
    
            print_r(json_encode($postArray['fetchedArray']));
    
        } else {
    
            foreach($postArray as $postIndex => $val) {
                $authorinfo = $user->getUserInfoFromPostID($val['post_id']);
        
                $postinfo = $post->getPost($val['post_id']);
                $val['title'] = $postinfo['title'];
                $val['firstname'] = $authorinfo['firstname'];
                $val['lastname'] = $authorinfo['lastname'];
                $array[$postIndex] = json_decode(json_encode($val));
                }
    
            print_r(json_encode($array));
        }
    } else {
        die();
    }

    // print_r(json_encode($postArray));

    

?>