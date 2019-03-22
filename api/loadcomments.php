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

    $post->postID = isset($_GET['id']) ? intval($_GET['id']) : die();

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


?>