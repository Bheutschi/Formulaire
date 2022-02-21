<?php
require_once 'dbconnexion.php';
require_once 'header.php';

//Au moment ou l'on va appuyer sur le bouton envoyer le code va s'executer
if (isset($_POST['submit'])) {

    $country = ucfirst(strtolower(trim($_POST['country'])));

    //Permet de tester si le pays existe dans ma base de donnée
    $stmt_country_exist_or_not = $pdo->prepare('SELECT * FROM countries WHERE name = :country ');
    $stmt_country_exist_or_not->execute([
        'country' => $country
    ]);
    $data = $stmt_country_exist_or_not->fetchAll();


    if ($data) {
        $id_country = $data[0]['id_country'];

    } else {

        $stmt_country = $pdo->prepare(
            'INSERT INTO countries (name)VALUE(:name)');
        $stmt_country->execute([
            'name' => $country,
        ]);
        //Stocker dans une variable l'identifiant de la dernière ligne insérer pour ensuite la récuperer
        $id_country = $pdo->lastInsertId();
    }

//Prepapre l'execution pour inserer mes différents champs
    $stmt_adress = $pdo->prepare(
        'INSERT INTO adresses (street, postal_code, city, countries_id_country) VALUES(:street, :postal_code, :city, :countries_id_country)');
// Execute ma requète avec les champs demander
    $stmt_adress->execute([
        'street' => $_POST['street'],
        'postal_code' => $_POST['npa'],
        'city' => $_POST['city'],
        'countries_id_country' => $id_country,
    ]);
    $id_adress = $pdo->lastInsertId();

    $stmt = $pdo->prepare(
        'INSERT INTO users (first_name, last_name, birthdate, email, phone, civility, sex)
                   VALUES(:first_name, :last_name, :birthdate, :email, :phone, :civility, :sex)');
    $stmt->execute([
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'birthdate' => $_POST['birthdate'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'civility' => $_POST['civility'],
        'sex' => $_POST['sex'],
    ]);
    // lier ma table user avec la table adresse grâce à la table intermédiaire users has adresses
    $id_user = $pdo->lastInsertId();

    $stmt_users_has_adresses = $pdo->prepare(
        'INSERT INTO users_has_adresses (users_id_user, adresses_id_adress) 
                VALUES (:users_id_user, :adresses_id_adress)');
    $stmt_users_has_adresses->execute([
        'users_id_user' => $id_user,
        'adresses_id_adress' => $id_adress,
    ]);

}
?>
<form action="index.php" method="post">
    <label for="sex" id="sex">Votre sexe</label>
    <select name="sex" id="sex">
        <option value="0">Monsieur</option>
        <option value="1">Madame</option>
    </select>
    <label for="civility" id="civility">Votre civilité</label>
    <select name="civility" id="civility">
        <option value="0">Célibataire</option>
        <option value="1">Marié</option>
        <option value="2">Divorcé</option>
        <option value="3">Veuf</option>
    </select><br>

    <label for="first_name">Prénom<br><input type="text" name="first_name"
                                             placeholder="Entrer votre prénom"><br><br>

    </label>
    <label for="last_name">Nom<br><input type="text" name="last_name" placeholder="Entrer votre nom de famille"><br><br>
    </label>
    <label for="birthdate">Anniversaire
        <br><input type="date" name="birthdate" placeholder="Entrer votre date d'anniversaire"><br><br>
    </label>
    <label for="email">Email
        <br><input type="email" name="email" placeholder="Entrer votre email"><br><br>
    </label>
    <label for="street">Adresse
        <br><input type="text" name="street" placeholder="Entrer votre adresse"><br><br>
    </label>
    <label for="npa">Code postal
        <br><input type="number" name="npa" placeholder="Entrer votre code postal"><br><br>
    </label>
    <label for="city">Ville
        <br><input type="text" name="city" placeholder="Entrer votre ville"><br><br>
    </label>
    <label for="country">Pays
        <br><input type="text" name="country" placeholder="Sélectionner votre pays"><br><br>
    </label>
    <label for="phone">N° de téléphone
        <br><input type="tel" name="phone" maxlength="12" placeholder="Entrer votre N° de téléphone"><br><br>
    </label>
    <input id="submit_id" type="submit" name="submit" value="Entrez"><br><br>
</form>
<?php
?>


<div>
    <p><a href="users.php">Go to events >></a></p>
</div>

