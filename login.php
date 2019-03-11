<?php
    $subtitle = 'Logga in';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= 'Opinion | ' . $subtitle; ?></title>
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
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Opinion</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
        <a class="nav-link" href="about.php">Om webbplatsen<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="main.php">Huvudsidan</a>
        </li>

        </ul>
        </div>
        </nav>
    </header>
    <div class="login">
        <div class="container">
            <form>
            <h1 class="login__title">Logga in på Opinion.</h1>
            <div class="form-group">
            <label for="InputUsername1">Användarnamn</label>
            <input type="text" class="form-control" id="InputUsername1" placeholder="Ange användarnamn">
            </div>
            <div class="form-group">
            <label for="InputPassword1">Lösenord</label>
            <input type="password" class="form-control" id="InputPassword1" placeholder="Ange lösenord">
            </div>
            <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Låt mig förbli inloggad</label>
            </div>
            <button type="submit" class="btn btn-primary">Logga in</button>
            <a href="#" class="forgot">
            <button type="submit" class="btn btn-warning">Glömt lösenord</button>
            </a>
            </form>

            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Är du ny på Opinion?</h5>
                <p class="card-text">Du kan enkelt registrera ett kostnadsfritt konto genom att klicka på knappen nedanför.</p>
                <div class="buttons">
                    <a href="register.php" class="card-link"><button class="btn btn-success btn-sm">Registrera dig nu</button></a>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>