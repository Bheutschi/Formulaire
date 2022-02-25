<?php
require_once 'dbconnexion.php';
require_once 'header.php';
require_once 'nav.php';

$stmtUserAndAddress = $pdo->prepare(
    'SELECT * FROM users_has_adresses
           INNER JOIN adresses a 
               on a.id_adress = users_has_adresses.adresses_id_adress
          INNER JOIN countries c 
               on c.id_country = a.countries_id_country
          INNER JOIN users u 
               on u.id_user = users_has_adresses.users_id_user'
);
$stmtUserAndAddress->execute();

/*foreach ($user as $row) {
    echo "{$row['first_name']} - {$row['last_name']} - {$row['street']} - {$row['postal_code']} - {$row['city']} - {$row['name']} - {$row['birthdate']}- {$row['email']} - {$row['phone']} - {$row['sex']} - {$row['civility']}<br>  ";
}*/
while ($user = $stmtUserAndAddress->fetch()) {
    ?>
    <div class="container">
        <div class="column is-half is-offset-one-quarter">
            <div class="card">
                <div class="card-content">
                    <div class="media">
                        <div class="media-left">
                            <figure class="image is-96x96">
                                <img src="https://w7.pngwing.com/pngs/504/252/png-transparent-pepe-the-frog-television-meme-meme-television-vertebrate-grass.png"
                                     alt="">
                            </figure>
                        </div>
                        <div class="media-content">
                            <p class="title is-4"><?= $user['first_name'] . " " . $user['last_name'] ?></p>
                            <p class="subtitle is-6"><?= $user['email'] ?></p>
                        </div>
                    </div>

                    <div class="content">
                        <p class="subtitle is-6"><?= " + " . $user['phone'] ?></p>
                        <p class="subtitle is-6"><?= $user['birthdate'] ?></p>
                        <p class="subtitle is-6"><?= $user['street'] . " - " . $user['postal_code'] . " - " . $user['city'] ?></p>
                        <p class="subtitle is-6"><?= $user['name'] ?></p>
                    </div>
                    <form action="edit.php" method="get">
                        <div class="card">
                            <footer class="card-footer">
                                <a class="card-footer-item" href="edit.php?id-user=<?= $user['id_user'] ?>">Edit</a>
                                <a class="card-footer-item" href="#">Delete</a>
                            </footer>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <table>
        <tr><?php echo $row['first_name'] . "\n" ?></tr>
        <tr><?php echo $row['last_name'] . "\n" ?></tr>
        <tr><?php echo $row['street'] . "\n" ?></tr>
        <tr><?php echo $row['postal_code'] . "\n" ?></tr>
        <tr><?php echo $row['city'] . "\n" ?></tr>
        <tr><?php echo $row['name'] . "\n" ?></tr>
        <tr><?php echo $row['birthdate'] . "\n" ?></tr>
        <tr><?php echo $row['email'] . "\n" ?></tr>
        <tr><?php echo $row['phone'] . "\n" ?></tr>
        <tr><?php echo $row['sex'] . "\n" ?></tr>
        <tr><?php echo $row['civility'] . "\n" ?></tr>
    </table>
    <?php
} ?>

<?php


