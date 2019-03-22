<?php
    $subtitle = 'Registrering';

    include_once('includes/defaultheader.php');
    include_once('includes/config.php');
    session_destroy();
    
    $user = new User();

    ?>

    <?php

    $displayForm = true;
    global $displayForm;

    if(isset($_POST['registerbtn']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) {

        $resultArray = $user->registerUser($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password'], $_POST['email']);


        if(isset($_FILES['fileToUpload'])) {
            $user->uploadUserImg($_POST['username']);
        };




        extract($resultArray);

        if($arrayResult) {
            $displayForm = false;
            $message = '<div class="alert alert-' . $alertClass . '" role="alert"  style="margin-bottom: 5rem;">
            ' . $alertMessage . '
              </div>';
        } else {
            $message = '<div class="alert alert-' . $alertClass . '" role="alert"  style="margin-bottom: 5rem;">
            ' . $alertMessage . '
              </div>';
        }

    }
?>

    <div class="login">
        <div class="container">

            <?php if(isset($message)) echo $message; ?>

            <?php if($displayForm) { ?>
            <form method="post" enctype="multipart/form-data" action="register.php" name="contentForm" role="form" data-toggle="validator">
            <h1 class="login__title">Registrera dig på Opinion.</h1>
            <div class="form-group">
            <label for="InputFirstname">Förnamn (*)</label>
            <input type="text" class="form-control" id="InputFirstname" name="firstname" placeholder="Vad är ditt förnamn?" required  data-error="Vänligen fyll i ditt förnamn.">
            <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
            <label for="InputLastname">Efternamn (*)</label>
            <input type="text" class="form-control" id="InputLastname" name="lastname" placeholder="Ange efternamn" required  data-error="Vänligen fyll i ditt efternamn.">
            <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
            <label for="InputUsername1">Användarnamn (*)</label>
            <input type="text" class="form-control" id="InputUsername1" name="username" placeholder="Ange användarnamn" required  data-error="Vänligen ange ett användarnamn med minst fem tecken.">
            <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
            <label for="InputPassword1">Lösenord (*)</label>
            <input type="password" class="form-control" id="InputPassword1" name="password" placeholder="Ange lösenord" required  data-error="Vänligen ange ett lösenord med minst sju tecken.">
            <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
            <label for="InputEmail">Mejladress (*)</label>
            <input type="email" class="form-control" id="InputEmail" name="email" placeholder="Ange mejladress" required  data-error="Vänligen ange din mejladress.">
            <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
            <label for="fileToUpload">Ladda upp ditt personliga foto (frivilligt)</label>
            <input type="file" name="fileToUpload" id="fileToUpload" class="form-control-file">
            </div>
            <input type="submit" class="btn btn-primary" value="Registrera dig" name="registerbtn">
            </form>

            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Har du redan ett konto eller har du glömt ditt lösenord?</h5>
                <p class="card-text">Då kan du slippa registreringsprocessen och logga in, eller begära ett nytt lösenord.</p>
                <div class="buttons">
                    <a href="login.php" class="card-link btn btn-success btn-sm">Logga in nu</a>
                    
                    <a href="#" class="forgot btn btn-warning">Glömt lösenord</a>
                    
                </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="card">
                <div class="card-body">
                <h5 class="card-title">Grattis. Nu är du medlem på Opinion!</h5>
                <p class="card-text">Vänligen klicka på knappen nedan och logga in med dina användaruppgifter.</p>
                <div class="buttons">
                <a href="login.php" class="card-link btn btn-success btn-sm">Logga in nu</a>
                </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

    
<?php 
    include_once('includes/footer.php');
?>