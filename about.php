<?php

    include_once('includes/config.php');
        
    $post = new Post();
    $user = new User();

    $subtitle = 'Om oss';

    $displayForm = true;

    if(isset($_POST['submitmsg']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
        $email = strip_tags($_POST['email']);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $message = strip_tags($_POST['message']);
        $message = filter_var($message, FILTER_SANITIZE_STRING);
        $subject = strip_tags($_POST['subject']);
        $subject = filter_var($subject, FILTER_SANITIZE_STRING);

        $to = "yamo.gebrewold@gmail.com";
        $headers = "From: $email" . "\r\n";

        if(mail($to,$subject,$message,$headers)) {
            $alertMessage = '<div class="alert alert-success" role="alert">Meddelandet har skickats!</div>';
          $displayForm = false;
        } else {
            $alertMessage = '<div class="alert alert-danger" role="alert">Något gick fel. Vänligen försök igen.</div>';
        }
    } elseif(isset($_POST['submitmsg']) && empty($_POST['email'])) {
        $alertMessage = '<div class="alert alert-warning" role="alert">Vänligen fyll i din mejladress.</div>';
    } elseif(isset($_POST['submitmsg']) && empty($_POST['subject'])) {
        $alertMessage = '<div class="alert alert-warning" role="alert">Vänligen ange ett ämne.</div>';
    } elseif(isset($_POST['submitmsg']) && empty($_POST['message'])) {
        $alertMessage = '<div class="alert alert-warning" role="alert">Vänligen ange ett meddelande.</div>';
    }


    

    
    if(isset($_SESSION['username'])) {
        include_once('includes/loginheader.php');

        $userinfo = $user->getUserInfo($user->getUserID($_SESSION['username']));

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


    <!-- Kategorifält -->
    <nav class="categories">
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

    if(isset($returnToMainPage)) {
        echo '<a href="main.php" class="btn btn-primary returnbtn" role="button" aria-pressed="true">Gå tillbaka till huvudsidan</a>';
    }
    ?>
    </div>
    <section class="about">
    <?php if(isset($alertMessage)) echo $alertMessage; ?>
    <h1 class="about__title">Om oss på <span class="badge badge-primary">Opinion</span></h1>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Vad är Opinion?</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Målet</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Kontakt</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Denna plattform har skapats för att medlemmar ska kunna dela tankar, åsikter och diskutera diverse ämnen. Man kan välja att skriva om allmänna ämnen eller inom specifika kategorier.</div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Målet med denna webbplats är att alla ska kunna ta del av en plats där man kan göra sin röst hörd. Tanken är att positiva diskussioner ska skapas och att medlemmarna tillsammans kan innovera och utveckla.</div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  

  För att ta kontakt med den ansvarige på denna sida, vänligen fyll i nedanstående formulär:

<?php if($displayForm) { ?>
<form method="post">
  <div class="form-group">
    <label for="contactmail">E-postadress</label>
    <input type="email" name="email" class="form-control" id="contactmail" aria-describedby="emailHelp" placeholder="Ange din e-postadress" required>
    <small id="emailHelp" class="form-text text-muted" style="font-size: 1.4rem;">Vi kommer aldrig sprida din e-postadress.</small>
  </div>
  <div class="form-group">
    <label for="contactsubject">Ämne</label>
    <input type="text" name="subject" class="form-control" id="contactsubject" placeholder="Vänligen ange ämnet" required>
  </div>
  <div class="form-group">
    <label for="contacttext">Ditt meddelande</label>
    <textarea class="form-control" name="message" id="contacttext" rows="3" placeholder="Vänligen skriv ditt önskemål här" required></textarea>
  </div>
  <button type="submit" class="btn btn-primary" name="submitmsg">Skicka</button>
</form>
<?php } ?>

  </div>
</div>

    </section>

    <!-- Innehåll -->


<?php 
    include_once('includes/footer.php');
?>