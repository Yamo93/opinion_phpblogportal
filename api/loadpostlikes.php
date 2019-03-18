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

    $post->postID = isset($_GET['id']) ? $_GET['id'] : die();

    $post->loadPostLikesAPI();

    $postArray = [
      'likes' => $post->numLikes,
      'dislikes' => $post->numDislikes
    ];

    print_r(json_encode($postArray));

    

?>