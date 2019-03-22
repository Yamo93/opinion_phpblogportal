<?php

    include_once('includes/config.php');
        
    $post = new Post();
    $user = new User();


        // Hämtar användarens info
        if(isset($_GET['id'])) {
            $userinfo = $user->getUserInfo($_GET['id']);
        }

        if(isset($_POST['submitimg'])) {
            $user->uploadUserImg($_SESSION['username'], true, '../../writeable/uploadedimg/thumbs/', '250', '250');
        }

        if(isset($_POST['updateimg'])) {
            $user_id = $user->getUserID($_SESSION['username']);
            $user->updateUserImg($_SESSION['username'], $user_id, true, '../../writeable/uploadedimg/thumbs/', '250', '250');
            // echo "user id: " . $user->getUserID($_SESSION['username']);
        }
    
    
        // Kontrollerar om sista bokstaven på användarens förnamn är s, x eller z
        if($userinfo['firstname'][strlen($userinfo['firstname'])-1] === 's' || $userinfo['firstname'][strlen($userinfo['firstname'])-1] === 'z' || $userinfo['firstname'][strlen($userinfo['firstname'])-1] === 'x') {
            $subtitle = $userinfo['firstname'] . ' profil';
        } else {
            $subtitle = $userinfo['firstname'] . 's profil';
        }

    
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
            <li><a href="category.php?id=1">Allmänt</a></li>
            <li><a href="category.php?id=2">Teknologi</a></li>
            <li><a href="category.php?id=3">Hälsa</a></li>
            <li><a href="category.php?id=4">Sport</a></li>
            <li><a href="category.php?id=5">Mat</a></li>
            <li><a href="category.php?id=6">Samhällsrelaterat</a></li>
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

        <?php 
        // Kontrollerar om profilanvändaren har en bild
        $profileHasImg = false;
        $profileFilename = $user->getUserImgFilename(($_GET['id']));
        if($profileFilename) {
            $profileHasImg = true;
        }


        // Kontrollerar om detta är den inloggade användarens profilsida
        
        if(isset($_SESSION['id']) && $_GET['id'] == $_SESSION['id']) {
            $updateImg = false; // uppdatering ej tillgänglig
            $uploadImg = true; // uppladdning tillgänglig
            if($user->isImgUploaded($_SESSION['id'])) {
                $updateImg = true;
                $uploadImg = false;
            }
        }

        ?>

        <div class="profile__img" style="<?php if($profileHasImg) 
            echo 'background-image: url(../../writeable/uploadedimg/thumbs/' . $profileFilename; ?>);"><?php if(!$profileHasImg) echo "<div class='name'><p>" . $userinfo['firstname'][0] . ' ' . $userinfo['lastname'][0] . "</p></div>"; ?></div>
        
        <?php if(isset($uploadImg) && $uploadImg && $_SESSION['id'] == $_GET['id']) { ?>
        <div class="imageformwrapper">
            <h2>Ladda upp din personliga bild</h2>
            <form method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Välj din profilbild:</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Ladda upp bild" name="submitimg">
            </form>
        </div>
        <?php } ?>

        <?php if(isset($updateImg) && $updateImg && $user->getUserID($_SESSION['username']) == $_GET['id']) { ?>
        <div class="imageformwrapper">
            <h2>Uppdatera din personliga bild</h2>
            <form method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Välj din nya profilbild:</label>
            <input type="file" name="fileToUpload" id="fileToUpload">

            <input type="submit" value="Ladda upp bild" name="updateimg">
            </form>
        </div>
        <?php } ?>


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