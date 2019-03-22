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

    $post = new Post();
    $user = new User();

    $post->postID = isset($_GET['id']) ? filter_var(intval($_GET['id']), FILTER_SANITIZE_NUMBER_INT) : die();
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