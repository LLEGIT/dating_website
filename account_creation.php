<?php
//Connect to db//
require_once "./config/db_manage.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My_Galaxy_Creation</title>
    <link rel="icon" href="./images/logo.ico">
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <header class="headerProfile">
        <img class="arrowDown" src="./images/arrow_down.png" alt="arrow down">
        <h1>Créer un compte</h1>
        <img class="arrowDown" src="./images/arrow_down.png" alt="arrow down">
    </header>
    <div class="containerRegistration">
        <form method="POST" action="account_creation.php">
            <label for="firstname">Prénom</label><br>
            <input type="text" name="firstname" maxlength="20" required><br>
            <label for="name">Nom</label><br>
            <input type="text" name="name" maxlength="20" required><br>
            <label for="birthdate">Date de naissance</label><br>
            <input type="date" name="birthdate" required><br>
            <label for="genre">Genre</label><br>
            <input type="radio" name="genre" id="homme" checked value="homme">
            <label for="homme">Homme</label>
            <input type="radio" name="genre" id="femme" value="femme">
            <label for="Femme">Femme</label>
            <input type="radio" name="genre" id="autre" value="non-binaire">
            <label for="autre">Non binaire</label><br>
            <input type="radio" name="genre" id="autre" value="nintendo-switch">
            <label for="autre">Nintendo Switch</label>
            <input type="radio" name="genre" id="autre" value="salade-cesar">
            <label for="autre">Salade César</label>
            <input type="radio" name="genre" id="autre" value="fiat-multipla">
            <label for="autre">Fiat Multipla</label><br>
            <label for="city">Ville</label><br>
            <input type="text" name="city" placeholder="Saint Médard en Jalles" maxlength="25" required><br>
            <label for="email">Adresse mail</label><br>
            <input type="email" name="email"><br>
            <label for="password">Mot de Passe</label><br>
            <input type="password" name="password" maxlength="20"><br>
            <label for="passwordConf">Confirmation du mot de passe</label><br>
            <input type="password" name="passwordConf" maxlength="20"><br>
            <label for="hobbies">Loisirs</label><br>
            <input type="checkbox" id="sport" name="hobbies[]" value="danse">
            <label for="dance">Danse</label>
            <input type="checkbox" id="videogames" name="hobbies[]" value="jeux-vidéos">
            <label for="videogames">Jeux vidéos</label>
            <input type="checkbox" id="movies" name="hobbies[]" value="films">
            <label for="movies">Films</label><br>
            <input type="checkbox" id="music" name="hobbies[]" value="musique">
            <label for="music">Musique</label>
            <input type="checkbox" id="skateboard" name="hobbies[]" value="skateboard">
            <label for="skateboard">Skateboard</label><br>
            <input type="checkbox" id="manga" name="hobbies[]" value="manga">
            <label for="manga">Manga</label>
            <input type="checkbox" id="cooking" name="hobbies[]" value="cuisiner">
            <label for="cooking">Cuisiner</label>
            <input type="checkbox" id="unicorn" name="hobbies[]" value="licorne">
            <label for="unicorn">Licorne</label><br>
            <button name="submit" type="submit">S'inscrire</button>
        </form>
        <a href="index.php">REVENIR À L'ACCUEIL</a>
    </div>
    <?php
    //Sending data to form//
    if (isset($_POST['submit'])) {
        //Defining vars//
        $name = $_POST['name'];
        $firstname = $_POST['firstname'];
        $birthdate = $_POST['birthdate'];
        $genre = $_POST['genre'];
        $city = $_POST['city'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
        $hobbies = implode("/", $_POST['hobbies']);
        $date = Date('Ymd');
        if((substr($date, 0, 4) - substr($birthdate, 0, 4)) < 18) {
            header("location: https://www.youtube.com/watch?v=aPjHCM9FwQo");
            exit;
        }
        if ($password == $passwordConf) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $query = new MyDatabase;
                $exists = $query->do_users_exists($email);
                if($exists === 0) {
                    $add = new MyDatabase;
                    $add->add_user_to_db($name, $firstname, $birthdate, $genre, $city, $email, $password_hash, $hobbies);
                    usleep(25000);
                    header("location: index.php");
                    exit;
                }
                elseif ($exists === 1) {
                    ?>
                    <a class="errors"><?php print "Un utilisateur avec le même mail existe déjà, veuillez réessayer !";?></a>
                    <?php
                }
            }
            catch (PDOException $e) {
                print $e->getMessage();
            }
        }
        else {
            ?>
            <a class="errors"><?php print "Les mots de passe ne coïncident pas ! Veuillez réessayer"; ?></a>
            <?php
        }
    }
    ?>
    <script src="./script/jquery-3.6.0.js"></script>
    <script src="./script/script.js"></script>
</body>

</html>