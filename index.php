<?php
    include_once('includes/config.php');

    $subtitle = 'Logga in';
    $user = new User();

    if(isset($_SESSION['username'])) {
        header("Location: main.php");
    }


    if(isset($_POST['submit'])) {
        if($user->loginUser($_POST['username'], $_POST['password'])) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['id'] = $user->getUserID($_POST['username']);
            header("Location: main.php");
        } else {
            $message = '<div class="alert alert-danger" role="alert">
            Användarnamnet eller lösenordet är felaktigt. Vänligen försök igen.
          </div>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Opinion | En bloggportal för alla</title>
    <link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png">
    <link rel="manifest" href="./img/favicon/site.webmanifest">
    <link rel="mask-icon" href="./img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="./img/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="./img/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Tinos:400,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="welcome">
        <div class="welcome__left">
            <ul class="welcome__list">
                <li class="welcome__list-item">Diskutera aktuella frågor.</li>
                <li class="welcome__list-item">Ta reda på senaste nytt om ditt favoritämne.</li>
                <li class="welcome__list-item">Dela med dig av din åsikt.</li>
            </ul>
        </div>
        <div class="welcome__right">
            <form method="post" class="form-inline welcome__form">
                <div class="form-group mb-2">
                    <input type="text" class="form-control" id="staticEmail2" placeholder="Användarnamn" name="username">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="password" class="form-control" id="inputPassword2" placeholder="Lösenord" name="password">
                </div>
                <input type="submit" class="btn btn-primary mb-2" name="submit" value="Logga in">
            </form>
            <div class="container" style="margin-bottom: 3rem;">
            <?php if(isset($message)) echo $message; ?>
            </div>
            <h1 class="welcome__right-title">Delta i öppna diskussioner!</h1>
            <p class="welcome__right-desc">Gå med i <span>Opinion</span> idag.</p>
            <div class="buttons">
                <a href="register.php" class="btn btn-primary welcomebtn">Registrera dig</a>
                <a href="main.php" class="btn btn-success welcomebtn">Jag gör det sen</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>