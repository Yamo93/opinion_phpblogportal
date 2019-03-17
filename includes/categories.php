
<nav class="categories">
<?php
    $categoryarray = $post->getCategories();
    // print_r($categoryarray);
?>
        <ul>
            <!-- Skriver ut kategorifältet dynamiskt -->
            <?php foreach($categoryarray as $category => $value) { ?>
                <li><a href="category.php?id=<?= $value['id']; ?>" <?php 
                // Kontrollerar om getparametern finns, om inte: så skriver jag ut aktiv-klassen på första elementet
                    if(isset($_GET['id'])) {
                        if ($_GET['id'] == $value['id'])  {
                        echo 'class="active"'; 
                    } 
                    } 
                    else {
                         if($value['id'] == 1) 
                         echo 'class="active"'; 
                        };
                    ?>><?= $value['name']; ?></a></li>
            <?php } ?>
        </ul>
    </nav>