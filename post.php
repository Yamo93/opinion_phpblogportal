<?php
    $subtitle = 'Inlägg av Yamo';

    // Loggar in "fejk" för testskäl
    $_SESSION['username'] = "Yamo93";

    if(isset($_SESSION['username'])) {
        include_once('includes/loginheader.php');
    } else {
        include_once('includes/defaultheader.php');
    }

    // Kolla om det är den inloggade användarens post, om så: visa edit-knapp
?>

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
            <input type="text" class="form-control" id="blogtitle" placeholder="Ange inläggets titel" required>
            </div>
            <div class="form-group">
            <label for="blogdesc">Beskrivning</label>
            <input type="text" class="form-control" id="blogdesc" placeholder="Skriv en kort beskrivning om inlägget" required>
            </div>
            <div class="form-group">
            <label for="blogcategory">Välj ämne (frivilligt)</label>
            <select class="form-control" id="blogcategory">
            <option value="tech">Teknologi</option>
            <option value="halsa">Hälsa</option>
            <option value="sport">Sport</option>
            <option value="mat">Mat</option>
            <option value="samhalle">Samhällsrelaterat</option>
            </select>
            </div>
            <div class="form-group">
            <label for="blogcontent">Redigera ditt inlägg nedan</label>
            <textarea class="form-control"  name="editor2" id="blogcontent" rows="3"></textarea>
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
    <section class="post">
        <h1 class="post__title">Det här är en titel till ett inlägg</h1>
        <p class="post__desc">Det här är beskrivningen till själva inlägget.</p>
        <div class="post__author">
            <div class="post__authorimg"></div>
            <div class="post__authorinfo">
                <p class="post__authorname">Av <span>Yamo Gebrewold</span></p>
                <p class="post__date">2019-01-01 01:00</p>
                <p class="post__read">4 mins läsning</p>
            </div>
        </div>
            <?php 
            // Kolla om det är den inloggade användarens post, om så: visa edit-knapp
            echo '<button type="button" class="btn btn-primary editbtn" data-toggle="modal" data-target="#editPost">
            Redigera inlägget
            </button>';
            ?>

        <!-- Bokmärkesknapp -->

        <p class="post__para">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil aliquid praesentium, id nesciunt aperiam corrupti quae eum labore a nemo qui, autem accusamus possimus voluptatum dolorum dicta nam temporibus itaque beatae dolorem aliquam. Consequatur commodi ipsam numquam a voluptates quas consectetur quidem eveniet id laboriosam quisquam qui, fugit fuga earum.
        </p>
        <p class="post__para">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt, voluptatum explicabo quia porro id vel quidem nobis officia delectus quisquam animi necessitatibus accusamus harum consectetur natus fugit saepe non maxime.</p>
        <p class="post__para">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Atque impedit accusantium vel natus sequi, libero iusto! Tenetur, placeat. Veritatis ipsam, maxime rem architecto ex numquam provident dignissimos pariatur laboriosam accusamus consequuntur tempore. Rem consequatur id similique vel ipsum quas, magni ipsa nam neque optio praesentium!</p>
        <p class="post__para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus possimus autem nam distinctio, odit cumque a saepe. Reiciendis necessitatibus corrupti illo a nesciunt voluptatem in!</p>
    </section>

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
    <script>
        CKEDITOR.replace( 'editor1' );
        CKEDITOR.replace( 'editor2' );
    </script>
</body>
</html>