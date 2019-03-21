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
<?php 
    // Laddar in kategorymenyn dynamiskt (från databasen)
    include_once('includes/categories.php');
?>

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

            <?php 
            $usersArray = $user->getAllUsers();
            ?>
    <div class="container userlist">
    <p>
    <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Visa alla användare</a>
    </p>
    <div class="row">
    <div class="col">
        <div class="collapse multi-collapse" id="multiCollapseExample1">
        <div class="card card-body">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Notering!</strong> Vänligen klicka på användarens inläggstitlar för att läsa innehållet.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
            <div class="accordion" id="accordionExample">
            <!-- Beginning of card -->
            <?php foreach($usersArray as $index =>  $userArray) { ?>
            <div class="card cardwrapper">
            <div class="card-header" id="<?= $userArray['id'] ?>">
            <h2 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#user<?= $userArray['id'] ?>" aria-expanded="true" aria-controls="user<?= $userArray['id'] ?>">
                <?= $userArray['firstname'] . ' ' . $userArray['lastname'] . ' (' . $userArray['username'] . ')'; ?>
            </button>
            </h2>
            </div>

            <div id="user<?= $userArray['id'] ?>" class="collapse" aria-labelledby="<?= $userArray['id'] ?>" data-parent="#accordionExample">
            <div class="card-body">
                <?php 
                $userPosts = $post->getPostsFromUser($userArray['id']);
                if($userPosts) { ?>

                <ol>
                    <h3><?= $userArray['username'] . 's inlägg:'; ?> <span class="showprofile"><a href="profile.php?id=<?= $userArray['id'] ?>" target="_blank">Visa <?= $userArray['username'] . 's profil' ?></a></span></h3>
                <?php foreach($userPosts as $index => $userPost) { ?>
                        <p><a href="post.php?id=<?= $userPost['id']; ?>" class="userpostlink" target="_blank"><?= $userPost['title']; ?></a><span class="userpostdate"><?= substr($userPost['created_date'], 0, 10) ?></span></p>
                        
                    <?php } ?>

                </ol>
                <?php } else { ?>
                    <h3><?= $userArray['username'] . 's inlägg:'; ?> <span class="showprofile"><a href="profile.php?id=<?= $userArray['id'] ?>" target="_blank">Visa <?= $userArray['username'] . 's profil' ?></a></span></h3>
                    <?php
                    echo "Inga inlägg skrivna.";
                }
                ?>
            </div>
            </div>
            </div>

            <?php } ?>



            </div>
        </div>
        </div>
    </div>
    </div>
    </div>

    <div class="mainpage">
        <section class="mainpage__left">
            <h1 class="mainpage__title">De senaste blogginläggen</h1>

            <?php 
                $result = $post->getPosts(5);
                foreach($result as $grabbedpost => $val) { ?>
            <article class="mainpage__article">
                <h2 class="mainpage__article-title"><a href="post.php?id=<?= $val['id']; ?>"><?= $val['title']; ?></a></h2>
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
                <div class="buttons">
                <a href="post.php?id=<?= $val['id']; ?>" class="mainpage__article-readbtn btn btn-primary">Läs mer</a>
                <a href="#" class="mainpage__article-addbookmark btn btn-success">Bokmärk</a>
                </div>
            </article>
                <?php } ?>

        </section>

<?php include_once('includes/rightmainpage.php'); ?>

    </div>

<?php 
    include_once('includes/footer.php');
?>