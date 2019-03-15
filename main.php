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
            <li><a href="/tech">Teknologi</a></li>
            <li><a href="/halsa">Hälsa</a></li>
            <li><a href="/sport">Sport</a></li>
            <li><a href="/mat">Mat</a></li>
            <li><a href="/samhalle">Samhällsrelaterat</a></li>
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
                <p class="mainpage__article-author">Av <span><?php
                $userinfo = $user->getUserInfo($val['user_id']);
                echo $userinfo['firstname'] . ' ' . $userinfo['lastname'];
                ?></span></p>
                <p class="mainpage__article-date"><?= $val['created_date']; ?></p>
                <p class="mainpage__article-read">Fyra minuters läsning</p>
                <a href="post.php?id=<?= $val['id']; ?>" class="mainpage__article-readbtn btn btn-primary">Läs mer</a>
            </article>
                <?php } ?>

        </section>
        <section class="mainpage__right">
            <h1 class="mainpage__title">Statistik om <span>Opinion</span></h1>
            <div class="amountusers">
                <i class="fas fa-users usersicon"></i>
                <h2>Antalet användare:</h2>
                <p class="info"><span><?php 
                $amountusers = $user->countUsers(); 
                echo $amountusers['amountusers']; ?></span> användare</p>
            </div>
            <div class="amountposts">
            <i class="far fa-edit posticon"></i>
                <h2>Antalet inlägg:</h2>
                <p class="info"><span><?php 
                $amountposts = $post->countPosts(); 
                echo $amountposts['amountposts']; ?></span> inlägg</p>
            </div>
            <div class="mostread">
                <i class="fas fa-fire-alt fireicon"></i>
                <h2>Opinions mest lästa inlägg:</h2>
                <ul>
                    <li><p class="popularpost">Lorem ipsum dolor sit amet consectetur</p>
                    <p class="popularauthor">Av <span>User1</span></p>
                    <p class="reads">20 läsningar</p></li>
                    <li><p class="popularpost">Lorem ipsum dolor sit amet</p>
                    <p class="popularauthor">Av <span>User2</span></p>
                    <p class="reads">25 läsningar</p></li>
                    <li><p class="popularpost">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    <p class="popularauthor">Av <span>User3</span></p>
                    <p class="reads">30 läsningar</p></li>
                </ul>
            </div>
        </section>
    </div>

    <footer class="footer">
        <ul>
            <li><a href="about.php">Om webbplatsen</a></li>
            <li><a href="contact.php">Kontakta oss</a></li>
        </ul>
        <p class="copyright">&copy; Copyright 2019 av Yamo Gebrewold.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        CKEDITOR.replace( 'editor1' );
    </script>
</body>
</html>