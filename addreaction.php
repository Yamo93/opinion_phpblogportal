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
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $post = new Post();
    $user = new User();

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $post->postID = $data->postID;
    $post->userID = $data->userID;
    $post->reactionType = $data->type;

    if($post->addReactionAPI()) {
        // Ladda in de uppdaterade reaktionerna
        $post->loadPostLikesAPI();
    } else {
        die();
    }

    $postArray = [
      'likes' => $post->numLikes,
      'dislikes' => $post->numDislikes
    ];

    print_r(json_encode($postArray));

    

?>