<section class="mainpage__right">
            <h1 class="mainpage__title">Statistik om <span>Opinion</span></h1>
            <div class="amountusers">
                <i class="fas fa-users usersicon"></i>
                <h2>Antalet användare:</h2>
                <p class="info"><span><?php 
                $amountusers = $user->countUsers(); 
                echo $amountusers['amountusers']; ?></span> användare</p>
            </div>
            <div class="amountposts">
            <i class="far fa-edit posticon"></i>
                <h2>Antalet inlägg:</h2>
                <p class="info"><span><?php 
                $amountposts = $post->countPosts(); 
                echo $amountposts['amountposts']; ?></span> inlägg</p>
            </div>
            <div class="mostread">
                <i class="fas fa-fire-alt fireicon"></i>
                <h2>Opinions hetaste ämnen:</h2>
                <ul>
                    <?php 
                    $popularTopicArray = $post->orderPopularTopics();

                    foreach($popularTopicArray as $index => $category) { 
                        $categoryname = $post->getCategoryName($category['category_id']);
                        $amountposts = $category['amountcategoryposts']; ?>
                    <li><a href="category.php?id=<?= $category['category_id']; ?>" class="popularcategory"><?= $categoryname; ?></a>
                    <p class="amountcategoryposts"><?= $amountposts; ?> inlägg</p></li>

                    <?php } ?>

                    <!-- <li><p class="popularpost">Lorem ipsum dolor sit amet</p>
                    <p class="popularauthor">Av <span>User2</span></p>
                    <p class="reads">25 läsningar</p></li>
                    <li><p class="popularpost">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    <p class="popularauthor">Av <span>User3</span></p>
                    <p class="reads">30 läsningar</p></li> -->
                </ul>
            </div>
        </section>