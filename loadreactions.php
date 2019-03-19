<?php
    session_start();
    define("DB_HOST", 'localhost');
    define("DB_USERNAME", 'root');
    define("DB_PASSWORD", 'yamo123');
    define("DB_NAME", 'opinion_blogportal');
    
    function my_autoloader($class) {
        include './classes/' . $class . '.class.php';
    }
    
    spl_autoload_register('my_autoloader');

      // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $post = new Post();
    $user = new User();

    $post->postID = isset($_GET['id']) ? intval($_GET['id']) : die();
    $post->userID = intval($user->getUserID($_SESSION['username']));

    if($post->loadReactionsAPI()) {
      $postArray = [
        'likes' => $post->numLikes,
        'dislikes' => $post->numDislikes
      ];
    } else {
      $postArray = [
        'likes' => $post->numLikes,
        'dislikes' => $post->numDislikes,
        'userID' => $post->userID,
        'postID' => $post->postID,
        'userReaction' => $post->userHasReacted
        ];
    }

    print_r(json_encode($postArray));

    

?>