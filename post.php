<?php
    include_once('includes/config.php');
    
    $post = new Post();
    $user = new User();
    
    // Hämtar skribentens användarinfo
    $authorinfo = $user->getUserInfoFromPostID($_GET['id']);

    // Hämtar inloggade användarens info
    if(isset($_SESSION['username'])) {
        $userinfo = $user->getUserInfo($_SESSION['id']);
    }



    $subtitle = 'Inlägg av ' . $authorinfo['firstname'];

    if(isset($_SESSION['username'])) {
        include_once('includes/loginheader.php');
    } else {
        include_once('includes/defaultheader.php');
    }


    // Redigeringsfunktion
    if(isset($_POST['editpost'])) {
        if($post->editPost($_GET['id'], $_POST['title'], $_POST['desc'], $_POST['editor2'], $_POST['categoryid'])) {
            $message = '<div class="alert alert-success" role="alert">
            Blogginlägget har uppdaterats!
          </div>';
        } else {
            $message = '<div class="alert alert-danger" role="alert">
            Något gick fel. Vänligen försök igen.
          </div>';
        }
    }

    // Redigeringsfunktion
    if(isset($_POST['delete'])) {
        if($post->deletePost($_GET['id'])) {
            $message = '<div class="alert alert-danger" role="alert">
            Blogginlägget har raderats!
          </div>';
          $returnToMainPage = true;
        } else {
            $message = '<div class="alert alert-warning" role="alert">
            Något gick fel. Vänligen försök igen.
          </div>';
        }
    }

    // Sparar info om inlägg + användare
    if(isset($_GET['id'])) {
        $selectedpost = $post->getPost($_GET['id']);
    }

    // Kolla om det är den inloggade användarens post, om så: visa edit-knapp och delete-knapp
    if(isset($_SESSION['id'])) {
        if($selectedpost['user_id'] === $_SESSION['id']) {
            // Den inloggade användaren är författaren
            $authorIsLoggedIn = true;
        } else {
            // Den inloggade användaren är inte författaren
            $authorIsLoggedIn = false;
        }
    }


?>

<div class="modal" id="deletemodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="post">
      <div class="modal-header">
        <h5 class="modal-title">Radering av inlägg</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Är du säker på att du vill radera inlägget?</p>
      </div>
      <div class="modal-footer">
        <input type="submit" name="delete" value="Radera inlägget" class="btn btn-danger">
        <button type="button" type="submit" class="btn btn-secondary" data-dismiss="modal">Gå tillbaka</button>
      </div>
    </form>
    </div>
  </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="editPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Redigera ditt inlägg</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form method="post">
            <div class="form-group">
            <label for="blogtitle">Titel</label>
            <input type="text" name="title" class="form-control" id="blogtitle" placeholder="Ange inläggets titel" value="<?= $selectedpost['title']; ?>" required>
            </div>
            <div class="form-group">
            <label for="blogdesc">Beskrivning</label>
            <input type="text" name="desc" class="form-control" id="blogdesc" placeholder="Skriv en kort beskrivning om inlägget" value="<?= $selectedpost['description']; ?>" required>
            </div>
            <div class="form-group">
            <label for="blogcategory">Välj ämne (frivilligt)</label>
            <select class="form-control" id="blogcategory" name="categoryid">
            <option value="1" <?php if($selectedpost['category_id'] == 1) echo "selected" ?>>Allmänt</option>
            <option value="2" <?php if($selectedpost['category_id'] == 2) echo "selected" ?>>Teknologi</option>
            <option value="3" <?php if($selectedpost['category_id'] == 3) echo "selected" ?>>Hälsa</option>
            <option value="4" <?php if($selectedpost['category_id'] == 4) echo "selected" ?>>Sport</option>
            <option value="5" <?php if($selectedpost['category_id'] == 5) echo "selected" ?>>Mat</option>
            <option value="6" <?php if($selectedpost['category_id'] == 6) echo "selected" ?>>Samhällsrelaterat</option>
            </select>
            </div>
            <div class="form-group">
            <label for="blogcontent">Redigera ditt inlägg nedan</label>
            <textarea class="form-control" name="editor2" id="blogcontent" rows="3"><?= $selectedpost['content']; ?></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Gå tillbaka</button>
            <button name="editpost" type="submit" class="btn btn-success">Redigera inlägg</button>
        </form>
    </div>
        </div>
    </div>
    </div>

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
    <!-- Inläggtitel -->
    <div class="container" style="margin-bottom: 3rem;">
    <?php 
    if(isset($message)) echo $message;

    if(isset($returnToMainPage)) {
        echo '<a href="main.php" class="btn btn-primary returnbtn" role="button" aria-pressed="true">Gå tillbaka till huvudsidan</a>';
    }
    ?>
    </div>
    <section class="post">
        <?php if(!isset($returnToMainPage))  { ?>
        <h1 class="post__title"><?= $selectedpost['title']; ?></h1>
        <p class="post__desc"><?= $selectedpost['description']; ?></p>
        <p class="post__category">Kategori: <span><?= $post->getCategoryName($selectedpost['category_id']); ?></span></p>
        <div class="post__author">
            <div class="post__authorimg"></div>
            <div class="post__authorinfo">
                <p class="post__authorname">Av <span><?= $authorinfo['firstname'] . ' ' . $authorinfo['lastname']; ?></span></p>
                <p class="post__date"><?= $selectedpost['created_date']; ?></p>
                <p class="post__read">4 mins läsning</p>
            </div>
        </div>
        <?php } ?>

        <?php 
            //  Tillåter endast att den inloggade medlemmen är inläggets författare

            if(isset($authorIsLoggedIn) && $authorIsLoggedIn) {
                echo '<button type="button" class="btn btn-primary editbtn" data-toggle="modal" data-target="#editPost">
                Redigera inlägget
                </button>';
                echo '<button type="button" class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deletemodal">
                Radera inlägget
                </button>';
            }
            ?>

        <!-- Bokmärkesknapp -->

        <?= $selectedpost['content']; ?>

    </section>

    <!-- Innehåll -->


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
        CKEDITOR.replace( 'editor2' );
    </script>
</body>
</html>