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
$stmt = $pdo->query('SELECT * FROM users');
while ($row = $stmt->fetch())
{?>
   <table>
    <tr><?php echo $row['first_name'] . "\n"?></tr>
    <tr><?php echo $row['last_name'] . "\n"?></tr>
    <tr><?php echo $row['street'] . "\n"?></tr>
    <tr><?php echo $row['postal_code'] . "\n"?></tr>
    <tr><?php echo $row['city'] . "\n"?></tr>
    <tr><?php echo $row['name'] . "\n"?></tr>
    <tr><?php echo $row['birthdate'] . "\n"?></tr>
    <tr><?php echo $row['email'] . "\n"?></tr>
    <tr><?php echo $row['phone'] . "\n"?></tr>
    <tr><?php echo $row['sex'] . "\n"?></tr>
    <tr><?php echo $row['civility'] . "\n"?></tr>
</table>
<?php
}?>


<table>
    <tr><?php echo $row['first_name']?></tr>
</table>
<div>
    <p><a href="index.php">Go to sign in >></a></p>
</div>

