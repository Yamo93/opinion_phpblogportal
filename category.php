<?php
    include_once('includes/config.php');

    $post = new Post();
    $user = new User();


    if(isset($_GET['id'])) {
        $subtitle = $post->getCategoryName($_GET['id']);
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

<?php 
    include_once('includes/categories.php');
?>

    <!-- Välkomstmeddelande -->
    <div class="container" style="margin-bottom: 3rem;">
    <?php 
    if(isset($message)) echo $message;
    ?>
    </div>

    <?php

    if(!isset($_SESSION['username'])) {
        echo '<div class="card text-center card-welcome">
        <div class="card-body">
        <h5 class="card-title">Välkommen till <span>Opinion</span>!</h5>
        <p class="card-text">Här får du dela med dig av dina tankar.</p>
        <a href="register.php" class="btn btn-primary">Registrera dig för att delta.</a>
        </div>
        </div>';
    } else {
        $userinfo = $user->getUserInfo($_SESSION['id']);
        $firstname = $userinfo['firstname'];

        echo '<div class="card text-center card-welcome">
        <div class="card-body">
        <h5 class="card-title">Välkommen till Opinion, <span>' . $firstname . '</span>!</h5>
        <p class="card-text">Här får du dela med dig av dina tankar.</p>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPost">
        Börja skriv ett inlägg
        </button>
        </div>
        </div>';
    }
    ?>

    <div class="mainpage">
        <section class="mainpage__left">
            <h1 class="mainpage__title">De senaste blogginläggen inom ämnet <span><?= $subtitle; ?></span></h1>

            <?php 
                $result = $post->getPostsFromCategory($_GET['id'], 5);
                foreach($result as $grabbedpost => $val) { ?>
            <article class="mainpage__article">
                <h2 class="mainpage__article-title"><a href="post.php?id=<?= $val['id']; ?>"><?= $val['title']; ?></a></h2>
                <p class="mainpage__article-desc"><?= $val['description']; ?></p>
                <p class="mainpage__article-category">Kategori: <span><?= $post->getCategoryName($val['category_id']); ?></span></p>
                <p class="mainpage__article-author">Av <span><a href="profile.php?id=<?= $val['user_id'];?>" target="_blank"><?php
                $userinfo = $user->getUserInfo($val['user_id']);
                echo $userinfo['firstname'] . ' ' . $userinfo['lastname'];
                ?></a></span></p>
                <p class="mainpage__article-date"><?= $val['created_date']; ?></p>
                <p class="mainpage__article-read">Fyra minuters läsning</p>
                <div class="visitswrapper">
                <p class="mainpage__article-visits">Antal läsningar: <span>
                    <?php 
                    $visits = $post->countPostVisits($val['id']);
                    extract($visits);
                    echo $amountvisits;
                    ?>
                </span></p>
                </div>
                <div class="buttons">
                <a href="post.php?id=<?= $val['id']; ?>" class="mainpage__article-readbtn btn btn-primary">Läs mer</a>
                <?php if(isset($_SESSION['username'])) { ?>
                <button class="mainpage__article-addbookmark btn btn-success" data-userid="<?= $val['user_id']; ?>" data-postid="<?= $val['id']; ?>">Bokmärk</button>
                <?php } ?>
                </div>
            </article>
                <?php } ?>

                <script>
                    
                    if(document.querySelector('.mainpage')) {
                        document.querySelector('.mainpage').addEventListener('click', addBookmark);
                    }
                    function addBookmark(event) {
                        if(event.target.matches('.mainpage__article-addbookmark')) {
                            // console.log(event.target.dataset.postid);
                            // console.log(event.target.dataset.userid);
                            var httpBookmarkAdd = new XMLHttpRequest();
                            var url = './api/addbookmark.php';
                            var params = {
                                postID: event.target.dataset.postid,
                                userID: event.target.dataset.userid
                            };
                            httpBookmarkAdd.open('POST', url, true);
                        

                        // finish off the rest of the httpBookmarkAdd (just like httpCommentAdd AND THEN load in new bookmarks depending on datatype (obj or arr))
                                            //Send the proper header information along with the request
                        httpBookmarkAdd.setRequestHeader('Content-type', 'application/json');
                        httpBookmarkAdd.send(JSON.stringify(params));
                        httpBookmarkAdd.onreadystatechange = function() {//Call a function when the state changes.
                        if(httpBookmarkAdd.readyState == 4 && httpBookmarkAdd.status == 200) {
                        // alert(httpBookmarkAdd.responseText);

                        // Laddar in nya kommentarer här
                        let bookmarks = JSON.parse(httpBookmarkAdd.responseText);
                        // console.log(bookmarks);

                        let alertBox = `
                        <div class="alert alert-success alert-dismissible" style="margin-top: 1.5rem;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        Bokmärket har sparats!
                        </div>`;
                        event.target.parentElement.parentElement.insertAdjacentHTML('beforeend', alertBox);
                        // Rensar elementet först
                        if (bookmarks instanceof Array === false) {

                        
                        document.querySelector('.bookmarkslist').innerHTML = `
                        <a class="dropdown-item" href="bookmarks.php">Bokmärkshanteraren</a><div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="post.php?id=${bookmarks.post_id}" target="_blank">${bookmarks.title.length < 20 ? bookmarks.title : bookmarks.title.slice(0, 20) + '...'} av <span>${bookmarks.firstname} ${bookmarks.lastname}</span></a>
                        `;
                } else if(bookmarks instanceof Array) {
                // Rensar elementet först
                document.querySelector('.bookmarkslist').innerHTML = '<a class="dropdown-item" href="bookmarks.php">Bokmärkshanteraren</a><div class="dropdown-divider"></div>';
                    
                bookmarks.forEach(bookmark => {
                let markup = `
                <a class="dropdown-item" href="post.php?id=${bookmark.post_id}" target="_blank">${bookmark.title.length < 20 ? bookmark.title : bookmark.title.slice(0, 20) + '...'} av <span>${bookmark.firstname} ${bookmark.lastname}</span></a>
                `;
                document.querySelector('.bookmarkslist').insertAdjacentHTML('beforeend', markup);
            });
                }
                    }
                    }
                }
                    }
                </script>

        </section>
        <?php include_once('includes/rightmainpage.php'); ?>
    </div>

<?php 
    include_once('includes/footer.php');
?>