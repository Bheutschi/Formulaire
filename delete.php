<?php
require_once 'header.php';
require_once 'dbconnexion.php';
require_once 'nav.php';


$getUserId = $_GET['id-user'];

if (!$getUserId) {
    header('Location: index.php');
}

$stmtUsersHasAdresses = $pdo->prepare(
    'SELECT * FROM users_has_adresses WHERE users_id_user=:users_id_user'
);
$stmtUsersHasAdresses->execute([
    'users_id_user' => $getUserId
]);

$usersHasAdresses = $stmtUsersHasAdresses->fetch();
var_dump($usersHasAdresses);

// Requètes delete Where ID
$stmt_adress = $pdo->prepare(
    'DELETE FROM adresses
WHERE id_adress=:id_adress');

$stmt_adress->execute([
    'id_adress' => $_POST['id_adress']
]);
$stmt = $pdo->prepare(
    'DELETE FROM users_has_adresses
WHERE users_id_user=:users_id_user');

$stmt->execute([
    'users_id_user' => $getUserId
]);

$stmt = $pdo->prepare(
    'DELETE FROM users
WHERE id_user=:id_user');

$stmt->execute([
    'id_user' => $getUserId
]);





// Si delete ok, redirection page liste utilisateurs

if ($stmt->execute()){
    header('location: users.php');
}else {
    var_dump("L'utilisateur n'a pas été supprimer");
}
