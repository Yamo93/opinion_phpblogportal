<?php
    $subtitle = 'Registrering';

    include_once('includes/defaultheader.php');
    $user = new User();

    ?>

<div class="container">
    <?php
    $displayForm = true;
    global $displayForm;

    if(isset($_POST['registerbtn'])) {

        if($user->registerUser($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password'], $_POST['email'])) {
            echo '<div class="alert alert-success" role="alert">
            Användare skapad!
          </div>';
          $displayForm = false;
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Registrering ej lyckad.
          </div>';
          $displayForm = true;
        }
    }
?>
</div>
    <div class="login">
        <div class="container">
            <?php if($displayForm) { ?>
            <form method="post">
            <h1 class="login__title">Registrera dig på Opinion.</h1>
            <div class="form-group">
            <label for="InputFirstname">Förnamn</label>
            <input type="text" class="form-control" id="InputFirstname" name="firstname" placeholder="Vad är ditt förnamn?">
            </div>
            <div class="form-group">
            <label for="InputLastname">Efternamn</label>
            <input type="text" class="form-control" id="InputLastname" name="lastname" placeholder="Ange efternamn">
            </div>
            <div class="form-group">
            <label for="InputUsername1">Användarnamn</label>
            <input type="text" class="form-control" id="InputUsername1" name="username" placeholder="Ange användarnamn">
            </div>
            <div class="form-group">
            <label for="InputPassword1">Lösenord</label>
            <input type="password" class="form-control" id="InputPassword1" name="password" placeholder="Ange lösenord">
            </div>
            <div class="form-group">
            <label for="InputEmail">Mejladress</label>
            <input type="email" class="form-control" id="InputEmail" name="email" placeholder="Ange mejladress">
            </div>
            <div class="form-group">
            <label for="FormControlFile1">Ladda upp ditt personliga foto</label>
            <input type="file" class="form-control-file" name="imgfile" id="FormControlFile1">
            </div>
            <input type="submit" class="btn btn-primary" value="Registrera dig" name="registerbtn">
            </form>

            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Har du redan ett konto eller har du glömt ditt lösenord?</h5>
                <p class="card-text">Då kan du slippa registreringsprocessen och logga in, eller begära ett nytt lösenord.</p>
                <div class="buttons">
                    <a href="login.php" class="card-link"><button class="btn btn-success btn-sm">Logga in nu</button></a>
                    <a href="#" class="forgot">
                    <button type="submit" class="btn btn-warning">Glömt lösenord</button>
                    </a>
                </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="card">
                <div class="card-body">
                <h5 class="card-title">Grattis. Du är nu medlem på Opinion!</h5>
                <p class="card-text">Vänligen klicka på knappen nedan och logga in med dina användaruppgifter.</p>
                <div class="buttons">
                    <a href="login.php" class="card-link"><button class="btn btn-success btn-sm">Logga in nu</button></a>
                </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>