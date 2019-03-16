<?php

    include_once('includes/config.php');
        
    $post = new Post();
    $user = new User();

        // Hämtar användarens info
        if(isset($_GET['id'])) {
            $userinfo = $user->getUserInfo($_GET['id']);
        }
    
    
        // Kontrollerar om sista bokstaven på användarens förnamn är s, x eller z
        if($userinfo['firstname'][strlen($userinfo['firstname'])-1] === 's' || $userinfo['firstname'][strlen($userinfo['firstname'])-1] === 'z' || $userinfo['firstname'][strlen($userinfo['firstname'])-1] === 'x') {
            $subtitle = $userinfo['firstname'] . ' profil';
        } else {
            $subtitle = $userinfo['firstname'] . 's profil';
        }

    
    if(isset($_SESSION['username'])) {
        include_once('includes/loginheader.php');
    } else {
        include_once('includes/defaultheader.php');
    }



?>


    <!-- Kategorifält -->
    <nav class="categories">
        <ul>
            <li><a href="main.php">Allmänt</a></li>
            <li><a href="tech.php">Teknologi</a></li>
            <li><a href="halsa.php">Hälsa</a></li>
            <li><a href="sport.php">Sport</a></li>
            <li><a href="mat.php">Mat</a></li>
            <li><a href="samhalle.php">Samhällsrelaterat</a></li>
        </ul>
    </nav>
    <!-- Inläggtitel -->
    <div class="container" style="margin-bottom: 3rem;">
    <?php 
    if(isset($message)) echo $message;

    if(isset($returnToMainPage)) {
        echo '<a href="main.php" class="btn btn-primary returnbtn" role="button" aria-pressed="true">Gå tillbaka till huvudsidan</a>';
    }
    ?>
    </div>
    <section class="profile">
        <h1 class="profile__title">
        <?php 
        // Kontrollerar om sista bokstaven på användarens förnamn är s, x eller z
        if($userinfo['firstname'][strlen($userinfo['firstname'])-1] === 's' || $userinfo['firstname'][strlen($userinfo['firstname'])-1] === 'z' || $userinfo['firstname'][strlen($userinfo['firstname'])-1] === 'x') {
            echo $userinfo['firstname'] . ' profil';
        } else {
            echo $userinfo['firstname'] . 's profil';
        }
        ?>
        </h1>
        <div class="profile__img"></div>
        <div class="profile__info">
            <div class="titlewrapper">
                <h2 class="profile__info-title">Användarinformation</h2>
            </div>
            <!-- Add Full name -->
            <div class="profile__fullname">
                <h3  class="profile__username-text">Fullständigt namn: <span><?= $userinfo['firstname'] . ' ' . $userinfo['lastname']; ?></span></h3>
            </div>
            <div class="profile__username">
                <h3  class="profile__username-text">Användarnamn: <span><?= $userinfo['username']; ?></span></h3>
            </div>
            <div class="profile__registerdate">
                <h3 class="profile__registerdate-text">Registreringsdatum: <span><?= substr($userinfo['register_date'], 0, 10); ?></span></h3>
            </div>
            <div class="profile__amountposts">
                <h3 class="profile__amountposts-text">Antalet inlägg skrivna: <span>
                <?php
                $amountposts = $user->countUserPosts($userinfo['id']);
                echo $amountposts['amountposts'];
                ?></span></h3>
            </div>
            <div class="profile__amountcomments">
                <h3 class="profile__amountcomments-text">Antalet kommentarer tillagda: <span><?= "0 kommentarer"; ?></span></h3>
            </div>
        </div>
    </section>

    <!-- Innehåll -->


<?php 
    include_once('includes/footer.php');
?>