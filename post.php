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

<?php if(isset($authorIsLoggedIn) && $authorIsLoggedIn) : ?>
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

    <?php endif; ?>

    <!-- Kategorifält -->
    <nav class="categories">
    <?php 
    $post->recordPostVisit($_SERVER['REMOTE_ADDR'], $_GET['id']);
    ?>
        <ul>
            <li><a href="category.php?id=1">Allmänt</a></li>
            <li><a href="category.php?id=2">Teknologi</a></li>
            <li><a href="category.php?id=3">Hälsa</a></li>
            <li><a href="category.php?id=4">Sport</a></li>
            <li><a href="category.php?id=5">Mat</a></li>
            <li><a href="category.php?id=6">Samhällsrelaterat</a></li>
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
            <!-- <div class="post__authorimg"></div> -->
            <?php 
        $updateImg = false; // uppdatering ej tillgänglig
        $uploadImg = true; // uppladdning tillgänglig
        if($user->isImgUploaded($selectedpost['user_id'])) {
            $updateImg = true;
            $uploadImg = false;

            $filename = $user->getUserImgFilename($selectedpost['user_id']);
        }

        ?>

        <div class="post__authorimg" style="<?php if(!$uploadImg) 
            echo 'background-image: url(./uploadedimg/thumbs/' . $filename; ?>"><?php if($uploadImg) echo "<div class='name'><p>" . $authorinfo['firstname'][0] . ' ' . $authorinfo['lastname'][0] . "</p></div>"; ?></div>

            <!-- Slut på bilduppladdning -->
            <div class="post__authorinfo">
                <p class="post__authorname">Av <span><a href="profile.php?id=<?= $authorinfo['id']; ?>" target="_blank"><?= $authorinfo['firstname'] . ' ' . $authorinfo['lastname']; ?></a></span></p>
                <p class="post__date"><?= $selectedpost['created_date']; ?></p>
                <p class="post__read">4 mins läsning</p>
            </div>
        </div>
        <p class="post__visits">Antal visningar: <span>
        <?php 
        $visitsarray = $post->countPostVisits($_GET['id']);
        extract($visitsarray);
        echo $amountvisits;
        ?> </span> </p>
        <?php } ?>

        <?php 
        // $post->postID = isset($_GET['id']) ? $_GET['id'] : die();
        // print_r($post->loadPostLikesAPI());

            //  Kontrollerar att den inloggade medlemmen är inläggets författare

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
        
        <div class="reactions">
            <script>
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                if (this.status === 200 && this.readyState === 4) {
                let reactions = JSON.parse(this.response);
                if(reactions.userReaction) {
                    if(reactions.userReaction.type === 1) {
                        document.querySelector('.likelink').classList.add('hasreacted');
                        document.querySelector('.likelink').innerHTML = 'Du har gillat <i class="fas fa-thumbs-up"></i>';
                    }
                    else if(reactions.userReaction.type === 2) {
                        document.querySelector('.dislikelink').classList.add('hasreacted');
                        document.querySelector('.dislikelink').innerHTML = 'Du har ogillat <i class="fas fa-thumbs-down"></i>';
                    }
                }

                document.querySelector('.numlikes').textContent = reactions.likes;
                document.querySelector('.numdislikes').textContent = reactions.dislikes;
                }
                }
                xhttp.open('GET', './loadreactions.php?id=<?= $_GET['id']; ?>', true);
                xhttp.send();
            </script>

            <div class="likes">
                <div class="like">
                    <button class="likelink" data-type="1">Gilla <i class="fas fa-thumbs-up"></i></button>
                    <span class="numlikes">0</span>
                </div>
                <div class="dislike">
                    <button class="dislikelink" data-type="2">Ogilla <i class="fas fa-thumbs-down"></i></button><span class="numdislikes">0</span>
                </div>
            </div>
            <?php if(!isset($_SESSION['username'])) { ?>
                <div class="alert alert-warning alert-dismissible fade show nolike" role="alert">
                <strong>Notering!</strong> Du måste vara inloggad för att gilla eller ogilla inlägget. Vänligen <a href="register.php" target="_blank">registrera dig</a> eller <a href="login.php" target="_blank">logga in</a> om du redan är en medlem.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <?php } ?>
            
            <script>
                document.querySelector('.likelink').addEventListener('click', addReaction);
                document.querySelector('.dislikelink').addEventListener('click', addReaction);

                function addReaction() {
                    var http = new XMLHttpRequest();
                    var url = 'addreaction.php';
                    var params = {
                        postID: <?= $_GET['id']; ?>,
                        userID: <?= $user->getUserID($_SESSION['username']); ?>,
                        type: this.dataset.type
                    };
                    http.open('POST', url, true);

                    //Send the proper header information along with the request
                    http.setRequestHeader('Content-type', 'application/json');
                    http.send(JSON.stringify(params));
                    http.onreadystatechange = function() {//Call a function when the state changes.
                    if(http.readyState == 4 && http.status == 200) {
                    // alert(http.responseText);

                    // Laddar in nya reaktioner här
                    let reactions = JSON.parse(http.responseText);
                    if(reactions.userReaction) {
                    if(reactions.userReaction.type === 1) {
                        document.querySelector('.likelink').classList.add('hasreacted');
                        document.querySelector('.likelink').innerHTML = 'Du har gillat <i class="fas fa-thumbs-up"></i>';
                    }
                    else if(reactions.userReaction.type === 2) {
                        document.querySelector('.dislikelink').classList.add('hasreacted');
                        document.querySelector('.dislikelink').innerHTML = 'Du har ogillat <i class="fas fa-thumbs-down"></i>';
                    }
                }

                document.querySelector('.numlikes').textContent = reactions.likes;
                document.querySelector('.numdislikes').textContent = reactions.dislikes;
                    }
                    }
                    http.send(params);
                }
                

            </script>
        </div>

        <section class="commentsection">
                <h1 class="commentsection__title">Inga kommentarer än</h1>
                <?php if(isset($_SESSION['username'])) { ?>
                <div class="commentbox">
                    <div class="commentbox__left">
                        <!-- <div class="commentbox__img"></div> -->
                        <?php 
        $updateCommentImg = false; // uppdatering ej tillgänglig
        $uploadCommentImg = true; // uppladdning tillgänglig
        if(isset($_SESSION['username']) && $user->isImgUploaded($user->getUserID($_SESSION['username']))) {
            $updateCommentImg = true;
            $uploadCommentImg = false;

            $filename = $user->getUserImgFilename($user->getUserID($_SESSION['username']));
        }

        ?>

        <div class="commentbox__img" style="<?php if(!$uploadImg) 
            echo 'background-image: url(./uploadedimg/thumbs/' . $filename; ?>"><?php if($uploadImg) echo "<div class='name'><p>" . $userinfo['firstname'][0] . ' ' . $userinfo['lastname'][0] . "</p></div>"; ?></div>
                    </div>
                    <div class="commentbox__right">

                            <textarea name="comment" id="commentfield" cols="30" rows="5" placeholder="Vänligen skriv en kommentar"></textarea>
                            <div class="alertmsgcomment"></div>
                            <button class="commentbox__submit">Skicka</button>
                    </div>
                </div>
                <?php } ?>
                <!-- Slut på kommentarsbox -->
                <script>
                document.querySelector('.commentbox__submit').addEventListener('click', addComment);
                            

                function addComment() {
                    if (document.querySelector('#commentfield').value === "") {
                        document.querySelector('.alertmsgcomment').classList.remove('alertmsgsuccess');
                        document.querySelector('.alertmsgcomment').classList.add('alertmsgempty');
                        document.querySelector('.alertmsgcomment').textContent = "Vänligen fyll i fältet.";
                        } else {

                            var httpCommentAdd = new XMLHttpRequest();
                    var url = 'addcomment.php';
                    var params = {
                        postID: <?= $_GET['id']; ?>,
                        userID: <?= $user->getUserID($_SESSION['username']); ?>,
                        content: document.querySelector('#commentfield').value
                    };
                    httpCommentAdd.open('POST', url, true);

                    //Send the proper header information along with the request
                    httpCommentAdd.setRequestHeader('Content-type', 'application/json');
                    httpCommentAdd.send(JSON.stringify(params));
                    httpCommentAdd.onreadystatechange = function() {//Call a function when the state changes.
                    if(httpCommentAdd.readyState == 4 && httpCommentAdd.status == 200) {
                    // alert(httpCommentAdd.responseText);

                    // Laddar in nya kommentarer här
                    let comments = JSON.parse(httpCommentAdd.responseText);
                    console.log(comments);
                    // Rensar elementet först
                    document.querySelector('.comments').innerHTML = "";
                    document.querySelector('.alertmsgcomment').classList.remove('alertmsgempty');
                    document.querySelector('.alertmsgcomment').classList.add('alertmsgsuccess');
                    document.querySelector('.alertmsgcomment').textContent = "Meddelandet har skickats!";
                    document.querySelector('#commentfield').value = "";

                    if (comments instanceof Array === false) {
                    let imgTxt = null;
                    let imgStyle = null;
                    if (!comments.filename) {
                    imgTxt = `<div class='name'><p>${comments.firstname[0]} ${comments.lastname[0]}</p></div>`;
                    } else {
                    imgStyle = ` style="background-image: url(./uploadedimg/thumbs/${comments.filename});"`;
                    }
                    document.querySelector('.commentsection__title').textContent = "1 kommentar";
                    let markup = `
                    <div class="comment">
                            <div class="comment__left">
                                <div class="comment__img"${imgStyle}>${imgTxt}</div>
                            </div>
                            <div class="comment__right">
                                <h2 class="comment__author" data-userid="${comments.user_id}">
                                @${comments.username} <span>(${comments.firstname} ${comments.lastname})</span></h2>
                                <p class="comment__text" data-postid="${comments.post_id}">${comments.content}</p>
                                <p class="comment__date">Publicerad ${comments.date}</p>
                            </div>
                        </div>
                    `;
                        document.querySelector('.comments').insertAdjacentHTML('beforeend', markup);

                } else if (comments instanceof Array) {
                document.querySelector('.commentsection__title').textContent = comments.length + ' kommentarer';

                comments.forEach(comment => {
                let imgTxt = "";
                let imgStyle = null;
                if (!comment.filename) {
                    imgTxt = `<div class='name'><p>${comment.firstname[0]} ${comment.lastname[0]}</p></div>`;
                } else {
                    imgStyle = ` style="background-image: url(./uploadedimg/thumbs/${comment.filename});"`;
                }
                let markup = `
                <div class="comment">
                        <div class="comment__left">
                            <div class="comment__img"${imgStyle}>${imgTxt}</div>
                        </div>
                        <div class="comment__right">
                            <h2 class="comment__author" data-userid="${comment.user_id}">
                            @${comment.username} <span>(${comment.firstname} ${comment.lastname})</span></h2>
                            <p class="comment__text" data-postid="${comment.post_id}">${comment.content}</p>
                            <p class="comment__date">Publicerad ${comment.date}</p>
                        </div>
                    </div>
                `;
                    document.querySelector('.comments').insertAdjacentHTML('beforeend', markup);
                });

                }

                    }
                    }
                    httpCommentAdd.send(params);

                    }

                }
                

            </script>


                <!-- Slut på kommentarfältet -->
                <script>
                let xhttpComment = new XMLHttpRequest();
                xhttpComment.onreadystatechange = function () {
                if (this.status === 200 && this.readyState === 4) {
                let comments = JSON.parse(this.response);

                if (comments instanceof Array === false) {
                    let imgTxt = null;
                    let imgStyle = null;
                    if (!comments.filename) {
                        imgTxt = `<div class='name'><p>${comments.firstname[0]} ${comments.lastname[0]}</p></div>`;
                    } else {
                        imgStyle = ` style="background-image: url(./uploadedimg/thumbs/${comments.filename});"`;
                    }


                    document.querySelector('.commentsection__title').textContent = "1 kommentar";
                    let markup = `
                    <div class="comment">
                            <div class="comment__left">
                                <div class="comment__img"${imgStyle}>${imgTxt}</div>
                            </div>
                            <div class="comment__right">
                                <h2 class="comment__author" data-userid="${comments.user_id}">
                                @${comments.username} <span>(${comments.firstname} ${comments.lastname})</span></h2>
                                <p class="comment__text" data-postid="${comments.post_id}">${comments.content}</p>
                                <p class="comment__date">Publicerad ${comments.date}</p>
                            </div>
                        </div>
                    `;
                        document.querySelector('.comments').insertAdjacentHTML('beforeend', markup);

                } else if (comments instanceof Array) {
                document.querySelector('.commentsection__title').textContent = comments.length + ' kommentarer';
                comments.forEach(comment => {
                    let imgTxt = "";
                    let imgStyle = null;
                    if (!comment.filename) {
                        imgTxt = `<div class='name'><p>${comment.firstname[0]} ${comment.lastname[0]}</p></div>`;
                    } else {
                        imgStyle = ` style="background-image: url(./uploadedimg/thumbs/${comment.filename});"`;
                    }

                let markup = `
                <div class="comment">
                        <div class="comment__left">
                            <div class="comment__img"${imgStyle}>${imgTxt}</div>
                        </div>
                        <div class="comment__right">
                            <h2 class="comment__author" data-userid="${comment.user_id}">
                            @${comment.username} <span>(${comment.firstname} ${comment.lastname})</span></h2>
                            <p class="comment__text" data-postid="${comment.post_id}">${comment.content}</p>
                            <p class="comment__date">Publicerad ${comment.date}</p>
                        </div>
                    </div>
                `;
                    document.querySelector('.comments').insertAdjacentHTML('beforeend', markup);
                });

                }


                }
                }
                xhttpComment.open('GET', './loadcomments.php?id=<?= $_GET['id']; ?>', true);
                xhttpComment.send();
                </script>
                <div class="comments">
                    <!-- <div class="comment">
                        <div class="comment__left">
                            <div class="comment__img"></div>
                        </div>
                        <div class="comment__right">
                            <h2 class="comment__author">@Yamo93 <span>(Yamo Gebrewold)</span></h2>
                            <p class="comment__text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo recusandae dolore tenetur perspiciatis eius maxime quae suscipit obcaecati, doloribus non?</p>
                            <p class="comment__date">Publicerad 2019-01-01 00:00</p>
                        </div>
                    </div> -->
                    <!-- Slut på kommentar -->

                    <!-- <div class="comment">
                        <div class="comment__left">
                            <div class="comment__img"></div>
                        </div>
                        <div class="comment__right">
                            <h2 class="comment__author">@Yamo93 <span>(Yamo Gebrewold)</span></h2>
                            <p class="comment__text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo recusandae dolore tenetur perspiciatis eius maxime quae suscipit obcaecati, doloribus non?</p>
                            <p class="comment__date">Publicerad 2019-01-01 00:00</p>
                        </div>
                    </div> -->
                    <!-- Slut på kommentar -->
                </div>
    </section>
    </section>

    <!-- Innehåll -->


<?php 
    include_once('includes/footer.php');
?>