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

    // Filtrerar värden
    $data->postID = filter_var($data->postID, FILTER_SANITIZE_NUMBER_INT);
    $data->type = filter_var($data->type, FILTER_SANITIZE_NUMBER_INT);

    // Tilldelning av värden
    $post->postID = $data->postID;
    $post->userID = $user->getUserID($_SESSION['username']);
    $post->reactionType = $data->type;

    if($post->addReactionAPI()) {
        // Ladda in de uppdaterade reaktionerna
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
    } else {
        die();
    }

    print_r(json_encode($postArray));

    

?>