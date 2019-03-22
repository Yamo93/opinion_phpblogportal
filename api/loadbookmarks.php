<?php
    session_start();
    define("DB_HOST", 'localhost');
    define("DB_USERNAME", 'root');
    define("DB_PASSWORD", 'yamo123');
    define("DB_NAME", 'opinion_blogportal');
    
    function my_autoloader($class) {
        include '../classes/' . $class . '.class.php';
    }
    
    spl_autoload_register('my_autoloader');

      // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $post = new Post();
    $user = new User();

    $post->userID = isset($_SESSION['username']) ? $user->getUserID($_SESSION['username']) : die();

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


?>