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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700%7CTinos:400,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/parsley.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
</head>
<body>
    <!-- Modal -->
    <div class="modal fade" id="addPost" tabindex="-1" role="dialog" aria-labelledby="createPost" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalTitle">Skapa ett inlägg</h5>
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
        <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal">Gå tillbaka</button>
            <input type="submit" name="addpost" class="btn btn-success" value="Lägg till inlägg">
        </div>
    </form>
        </div>
    </div>
    </div>
</div>


    <header class="header">
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">Opinion</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownOne" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Välkommen, <span class="membername"><?php 
                $welcomeuser = $user->getUserInfo($_SESSION['id']);
                $firstname = $welcomeuser['firstname'];
                echo $firstname;
                ?></span>!
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownOne">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addPost" id="createPost">Skapa ett inlägg</a>
                <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPost">
                Skapa ett inlägg
                </button> -->
                <a class="dropdown-item" href="profile.php?id=<?= $_SESSION['id']; ?>">Min profil</a>
                <a class="dropdown-item" href="usersettings.php">Inställningar</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logga ut</a>
            </div>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="main.php">Huvudsidan <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="about.php">Om webbplatsen</a>
            </li>
            <li class="nav-item active dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownOne" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Mina bokmärken
            </a>
            <div class="dropdown-menu bookmarkslist" aria-labelledby="navbarDropdownOne">
                <a class="dropdown-item" href="bookmarks.php">Bokmärkshanteraren</a>
                <div class="dropdown-divider"></div>
                <!-- <a class="dropdown-item" href="post.php?id=1">Titel Ett av <span>Yamo Geb</span></a>
                <a class="dropdown-item" href="post.php?id=2">Titel Två av <span>Fredde Fredriksson</span></a> -->
            </div>
            </li>

            <!-- Dropdown för kategorier i små menyer -->
            <li class="nav-item active dropdown categoriesdropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTwo" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kategorier
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownTwo">
                <a class="dropdown-item" href="category.php?id=1">Allmänt</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="category.php?id=2">Teknologi</a>
                <a class="dropdown-item" href="category.php?id=3">Hälsa</a>
                <a class="dropdown-item" href="category.php?id=4">Sport</a>
                <a class="dropdown-item" href="category.php?id=5">Mat</a>
                <a class="dropdown-item" href="category.php?id=6">Samhällsrelaterat</a>
            </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Sök på sidan" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Sök</button>
        </form>
        </div>
        </nav>
    </header>

    <script>

        let xhttpBookmark = new XMLHttpRequest();
        xhttpBookmark.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
        // console.log(this.responseText);
        let bookmarks = JSON.parse(this.response);
        // console.log(bookmarks);
        if(bookmarks instanceof Array === false) {
            // Print out one bookmark
            let markup = `
                <a class="dropdown-item" href="post.php?id=${bookmarks.post_id}" target="_blank">${bookmarks.title.length < 20 ? bookmarks.title : bookmarks.title.slice(0, 20) + '...'} av <span>${bookmarks.firstname} ${bookmarks.lastname}</span></a>
                `;
                document.querySelector('.bookmarkslist').insertAdjacentHTML('beforeend', markup);
        } else if(bookmarks instanceof Array) {
            bookmarks.forEach(bookmark => {
                let markup = `
                <a class="dropdown-item" href="post.php?id=${bookmark.post_id}" target="_blank">${bookmark.title.length < 20 ? bookmark.title : bookmark.title.slice(0, 20) + '...'} av <span>${bookmark.firstname} ${bookmark.lastname}</span></a>
                `;
                document.querySelector('.bookmarkslist').insertAdjacentHTML('beforeend', markup);
            });
        }
        }
        }
        xhttpBookmark.open('GET', './loadbookmarks.php', true);
        xhttpBookmark.send();
    </script>