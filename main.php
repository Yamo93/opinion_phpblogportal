<?php
    $subtitle = 'Huvudsidan';
    include_once('includes/config.php');

    $post = new Post();
    $user = new User();

    if(isset($_SESSION['username'])) {
        include_once('includes/loginheader.php');

    
        if(isset($_POST['addpost'])) {
            // print_R($_POST);
            if($post->addPost($_POST['title'], $_POST['desc'], $_POST['editor1'], $_SESSION['id'], $_POST['categoryid'])) {
                $message = '<div class="alert alert-success" role="alert">
                Blogginlägget har publicerats!
              </div>';
            } else {
                $message = '<div class="alert alert-danger" role="alert">
                Något gick fel. Vänligen försök igen.
              </div>';
            }
        }


    } else {
        include_once('includes/defaultheader.php');
    }

?>

    <!-- Kategorifält -->
    <nav class="categories">
        <ul>
            <li><a href="#" class="active">Allmänt</a></li>
            <li><a href="tech.php">Teknologi</a></li>
            <li><a href="halsa.php">Hälsa</a></li>
            <li><a href="sport.php">Sport</a></li>
            <li><a href="mat.php">Mat</a></li>
            <li><a href="samhalle.php">Samhällsrelaterat</a></li>
        </ul>
    </nav>

    <!-- Välkomstmeddelande -->
    <div class="container" style="margin-bottom: 3rem;">
    <?php 
    if(isset($message)) echo $message;
    ?>
    </div>

    <?php

    if(!isset($_SESSION['username'])) {
        echo '<div class="card text-center card-welcome">
        <div class="card-body">
        <h5 class="card-title">Välkommen till <span>Opinion</span>!</h5>
        <p class="card-text">Här får du dela med dig av dina tankar.</p>
        <a href="register.php" class="btn btn-primary">Registrera dig för att delta.</a>
        </div>
        </div>';
    } else {
        $userinfo = $user->getUserInfo($_SESSION['id']);
        $firstname = $userinfo['firstname'];

        echo '<div class="card text-center card-welcome">
        <div class="card-body">
        <h5 class="card-title">Välkommen till Opinion, <span>' . $firstname . '</span>!</h5>
        <p class="card-text">Här får du dela med dig av dina tankar.</p>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPost">
        Börja skriv ett inlägg
        </button>
        </div>
        </div>';
    }
    ?>

    <div class="mainpage">
        <section class="mainpage__left">
            <h1 class="mainpage__title">De senaste blogginläggen</h1>

            <?php 
                $result = $post->getPosts(5);
                foreach($result as $grabbedpost => $val) { ?>
            <article class="mainpage__article">
                <h2 class="mainpage__article-title"><?= $val['title']; ?></h2>
                <p class="mainpage__article-desc"><?= $val['description']; ?></p>
                <p class="mainpage__article-category">Kategori: <span><?= $post->getCategoryName($val['category_id']); ?></span></p>
                <p class="mainpage__article-author">Av <span><a href="profile.php?id=<?= $val['user_id'];?>" target="_blank"><?php
                $userinfo = $user->getUserInfo($val['user_id']);
                echo $userinfo['firstname'] . ' ' . $userinfo['lastname'];
                ?></a></span></p>
                <p class="mainpage__article-date"><?= $val['created_date']; ?></p>
                <p class="mainpage__article-read">Fyra minuters läsning</p>
                <div class="visitswrapper">
                <p class="mainpage__article-visits">Antal läsningar: <span>
                    <?php 
                    $visits = $post->countPostVisits($val['id']);
                    extract($visits);
                    echo $amountvisits;
                    ?>
                </span></p>
                </div>
                <a href="post.php?id=<?= $val['id']; ?>" class="mainpage__article-readbtn btn btn-primary">Läs mer</a>
            </article>
                <?php } ?>

        </section>

<?php include_once('includes/rightmainpage.php'); ?>

    </div>

<?php 
    include_once('includes/footer.php');
?>