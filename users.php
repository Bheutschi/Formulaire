<?php
require_once 'dbconnexion.php';

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
$user = $stmtUserAndAddress->fetchAll();

foreach ($user as $row) {
    echo "{$row['first_name']} - {$row['last_name']} - {$row['street']} - {$row['postal_code']} - {$row['city']} - {$row['name']} - {$row['birthdate']}- {$row['email']} - {$row['phone']} - {$row['sex']} - {$row['civility']}<br>  ";
}
?>

<div>
    <p><a href="index.php">Go to sign in >></a></p>
</div>

