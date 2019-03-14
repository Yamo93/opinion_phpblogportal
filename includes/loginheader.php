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
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
</head>
<body>
    <!-- Modal -->
    <div class="modal fade" id="addPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Skapa ett inlägg</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form method="post">
            <div class="form-group">
            <label for="blogtitle">Titel</label>
            <input type="text" name="title" class="form-control" id="blogtitle" placeholder="Ange inläggets titel" required>
            </div>
            <div class="form-group">
            <label for="blogdesc">Beskrivning</label>
            <input type="text" name="desc" class="form-control" id="blogdesc" placeholder="Skriv en kort beskrivning om inlägget" required>
            </div>
            <div class="form-group">
            <label for="blogcategory">Välj ämne (frivilligt)</label>
            <select class="form-control" id="blogcategory" name="categoryid">
            <option value="1" selected>Allmänt</option>
            <option value="2">Teknologi</option>
            <option value="3">Hälsa</option>
            <option value="4">Sport</option>
            <option value="5">Mat</option>
            <option value="5">Samhällsrelaterat</option>
            </select>
            </div>
            <div class="form-group">
            <label for="blogcontent">Skriv ditt inlägg nedan</label>
            <textarea class="form-control"  name="editor1" id="blogcontent" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Gå tillbaka</button>
            <input type="submit" name="addpost" class="btn btn-success" value="Lägg till inlägg">
        </form>
    </div>
        </div>
    </div>
    </div>


    <header class="header">
        <nav class="header__nav">
            <ul class="header__nav-primarylist">
                <li class="header__nav-brand"><a href="main.php">Opinion</a></li>
                <li><a href="main.php">Huvudsidan</a></li>
                <li><a href="about.php">Om webbplatsen</a></li>
            </ul>

            <form action="" method="post" class="header__search">
                <input type="search" name="search" id="search" placeholder="Sök efter inlägg..." class="header__search-input">
                <input type="submit" value="Sök" class="header__search-btn">
            </form>

            <ul class="header__nav-secondarylist">
                <li><a href="#">Välkommen, <span><?php 
                $userinfo = $user->getUserInfo($_SESSION['id']);
                $firstname = $userinfo['firstname'];
                echo $firstname;
                ?></span>!</a></li>
                <li><button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPost">
                Skapa ett inlägg
                </button></li>
                <li><a href="logout.php" class="btn btn-warning">Logga ut</a></li>
            </ul>

        </nav>
    </header>