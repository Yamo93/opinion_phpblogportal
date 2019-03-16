
<nav class="categories">
<?php
    $categoryarray = $post->getCategories();
    // print_r($categoryarray);
?>
        <ul>
            <!-- Skriver ut kategorifältet dynamiskt -->
            <?php foreach($categoryarray as $category => $value) { ?>
                <li><a href="category.php?id=<?= $value['id']; ?>" <?php 
                    if($_GET['id'] == $value['id']) echo 'class="active"';
                    ?>><?= $value['name']; ?></a></li>
            <?php } ?>
            <!-- <li><a href="#" class="active">Allmänt</a></li>
            <li><a href="tech.php">Teknologi</a></li>
            <li><a href="halsa.php">Hälsa</a></li>
            <li><a href="sport.php">Sport</a></li>
            <li><a href="mat.php">Mat</a></li>
            <li><a href="samhalle.php">Samhällsrelaterat</a></li> -->
        </ul>
    </nav>