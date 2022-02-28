<?php
require_once 'dbconnexion.php';
require_once 'header.php';
require_once 'nav.php';


$getUserId = $_GET['id-user'];

if (!$getUserId) {
    header('Location: index.php');
}

$stmtGetUserId = $pdo->prepare(
    'SELECT * FROM users_has_adresses
           INNER JOIN adresses a 
               on a.id_adress = users_has_adresses.adresses_id_adress
          INNER JOIN countries c 
               on c.id_country = a.countries_id_country
          INNER JOIN users u 
               on u.id_user = users_has_adresses.users_id_user
               WHERE id_user = :id'
);
$stmtGetUserId->execute(
    ["id" => $getUserId]
);
$user = $stmtGetUserId->fetch();

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
                        <div class="container">
                              <p class="is-size-2"><?= $user['first_name'] . " " . $user['last_name'] ?></p>
                            <div class="container">
                        <span class="icon-text" style="align-items: center">
                              <span class="icon is-large">
                                <ion-icon name="calendar-outline" size="large"></ion-icon>
                              </span>
                              <span class="is-size-4"><?= $user['birthdate'] ?></span>
                            </span>
                            </div>
                        </div>

                    </div>
                    <div class="container">
                        <span class="icon-text" style="align-items: center">
                              <span class="icon is-large">
                                <ion-icon name="at-outline" size="large"></ion-icon>
                              </span>
                              <span class="is-size-4"><?= $user['email'] ?></span>
                            </span>
                    </div>
                    <div class="container">
                        <span class="icon-text" style="align-items: center">
                              <span class="icon is-large">
                                <ion-icon name="home-outline" size="large"></ion-icon>
                              </span>
                              <span class="is-size-4"><?= $user['street'] . " - " . $user['postal_code'] . " - " . $user['city'] ?></span>
                            </span>
                    </div>
                    <div class="container">
                        <span class="icon-text" style="align-items: center">
                              <span class="icon is-large">
                                <ion-icon name="pin-outline" size="large"></ion-icon>
                              </span>
                              <span class="is-size-4"><?= $user['name'] ?></span>
                            </span>
                    </div>
                    <div class="container">
                        <span class="icon-text" style="align-items: center">
                              <span class="icon is-large">
                                <ion-icon name="call-outline" size="large"></ion-icon>
                              </span>
                              <span class="is-size-4"><?= $user['phone'] ?></span>
                            </span>
                    </div>
                </div>
                <form action="edit.php" method="get">
                    <div class="card">
                        <footer class="card-footer">
                            <a class="card-footer-item" href="edit.php?id-user=<?= $user['id_user'] ?>">Edit</a>
                            <a class="card-footer-item" href="delete.php?id-user=<?= $user['id_user'] ?>">Delete</a>
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
require_once 'footer.php';