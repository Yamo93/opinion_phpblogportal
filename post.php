<?php
    $subtitle = 'Huvudsidan';
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header class="header">
        <nav class="header__nav">
            <ul class="header__nav-primarylist">
                <li class="header__nav-brand"><a href="index.php">Opinion</a></li>
                <li><a href="main.php">Huvudsidan</a></li>
                <li><a href="about.php">Om webbplatsen</a></li>
            </ul>

            <form action="" method="post" class="header__search">
                <input type="search" name="search" id="search" placeholder="Sök efter inlägg..." class="header__search-input">
                <input type="submit" value="Sök" class="header__search-btn">
            </form>

            <ul class="header__nav-secondarylist">
                <li><a href="login.php">Logga in</a></li>
                <li><a href="register.php">Registrera dig</a></li>
            </ul>

        </nav>
    </header>

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
</body>
</html>