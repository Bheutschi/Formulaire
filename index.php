<?php
require_once 'dbconnexion.php';
require_once 'header.php';
require_once 'nav.php';

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
    <div class="column is-2 is-offset-5 ">
        <div class="select is-normal">
            <label for="sex" id="sex"></label>
            <select name="sex" id="sex">
                <option value="0">Monsieur</option>
                <option value="1">Madame</option>
            </select>
        </div>

        <div class="select is-normal">
            <label for="civility" id="civility"></label>
            <select name="civility" id="civility">
                <option value="0">Célibataire</option>
                <option value="1">Marié</option>
                <option value="2">Divorcé</option>
                <option value="3">Veuf</option>
            </select>
        </div>
        <div class="field">
            <label class="label" for="first_name">Prénom</label>
            <div class="control">
                <label>
                    <input class="input" type="text" placeholder="Entrez votre prénom" name="first_name">
                </label>
            </div>
        </div>

        <div class="field">
            <label class="label" for="last_name">Nom</label>
            <div class="control">
                <label>
                    <input class="input" type="text" placeholder="Entrez votre nom" name="last_name">
                </label>
            </div>
        </div>
        <div class="field">
            <label class="label" for="birthdate">Date de naissance</label>
            <div class="control">
                <label>
                    <input class="input" type="date" name="birthdate">
                </label>
            </div>
        </div>
        <div class="field">
            <label class="label" for="email">Adresse mail</label>
            <div class="control">
                <label>
                    <input class="input" type="email" placeholder="Entrez votre email" name="email">
                </label>
            </div>
        </div>
        <div class="field">
            <label for="street" class="label">Adresse</label>
            <div class="control">
                <label>
                    <input name="street" class="input " type="text" placeholder="Entrer votre adresse">
                </label>
            </div>
        </div>
        <div class="field">
            <label for="npa" class="label">Code postal</label>
            <div class="control">
                <label>
                    <input name="npa" class="input" type="number" placeholder="Entrer votre code postal">
                </label>
            </div>
        </div>
        <div class="field">
            <label for="city" class="label">Ville</label>
            <div class="control">
                <label>
                    <input name="city" class="input" type="text" placeholder="Entrez le nom de votre ville">
                </label>
            </div>
        </div>
        <div class="field">
            <label for="country" class="label">Pays</label>
            <div class="control">
                <label>
                    <input name="country" class="input" type="text" placeholder="Entrez le nom de votre pays">
                </label>
            </div>
        </div>

        <div class="field">
            <label for="phone" class="label">N° de téléphone</label>
            <div class="control">
                <label>
                    <input class="input" type="text" placeholder="Entrer votre N° de téléphone" name="phone">
                </label>

            </div>
        </div>

        <div class="control">
            <input id="submit_id" name="submit" type="submit" class="input is-primary" value="Entrez">
        </div>
    </div>
</form>

<?php
?>



