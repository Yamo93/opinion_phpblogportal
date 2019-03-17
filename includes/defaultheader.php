<?php
    include_once('config.php');
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
    <link rel="stylesheet" href="./css/parsley.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">Opinion</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
        <a class="nav-link" href="main.php">Huvudsidan <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="about.php">Om webbplatsen</a>
        </li>
        <li class="nav-item active dropdown categoriesdropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kategorier
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="category.php?id=1">Allmänt</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="category.php?id=2">Teknologi</a>
                <a class="dropdown-item" href="category.php?id=3">Hälsa</a>
                <a class="dropdown-item" href="category.php?id=4">Sport</a>
                <a class="dropdown-item" href="category.php?id=5">Mat</a>
                <a class="dropdown-item" href="category.php?id=6">Samhällsrelaterat</a>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="login.php">Logga in</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="register.php">Registrera dig</a>
        </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Sök på sidan" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Sök</button>
        </form>
        </div>
        </nav>
        <!-- <nav class="header__nav">
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

        </nav> -->
    </header>