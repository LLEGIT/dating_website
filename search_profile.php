<?php 
require_once "./config/db_manage.php";
$email = $_GET['login'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My_Galaxy_Search</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="favicon" href="./images/logo.ico">
</head>

<body>
    <div class="searchBar">
        <a href="./my_account.php?login=<?php print $_GET['login']; ?>">Revenir au profil</a>
        <h1 id="searchHeading">Rechercher un(e) personne à rencontrer autour de vous</h1>
        <span id="loupe">🔎</span>
    </div>
    <div class="containerSearch">
        <form action="search_profile.php?login=<?php print $email; ?>" method="POST">
            <label for="genre">Choisir un genre</label>
            <select name="genre" id="choixGenre">
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
                <option value="non-binaire">Non-binaire</option>
                <option value="nintendo-switch">Nintendo Switch</option>
                <option value="salade-cesar">Salade César</option>
                <option value="fiat-multipla">Fiat Multipla</option>
            </select><br>
            <label for="city">La ville</label>
            <input type="text" name="city" maxlength="30" placeholder="Mont-de-Marsan" required><br>
            <label for="age">La tranche d'âge</label><br>
            <input type="radio" name="age" id="1" value="1825" checked>
            <label for="1">18-25 ans</label>
            <input type="radio" name="age" id="2" value="2535">
            <label for="1">25-35 ans</label>
            <input type="radio" name="age" id="3" value="3545">
            <label for="1">35-45 ans</label>
            <input type="radio" name="age" id="4" value="45100">
            <label for="1">45 ans et +</label><br>
            <label for="hobbies">Loisirs</label><br>
            <input type="checkbox" id="sport" name="hobbies[]" value="danse" checked>
            <label for="dance">Danse</label>
            <input type="checkbox" id="videogames" name="hobbies[]" value="jeux-vidéos">
            <label for="videogames">Jeux vidéos</label>
            <input type="checkbox" id="movies" name="hobbies[]" value="films">
            <label for="movies">Films</label>
            <input type="checkbox" id="music" name="hobbies[]" value="musique">
            <label for="music">Musique</label><br>
            <input type="checkbox" id="skateboard" name="hobbies[]" value="skateboard">
            <label for="skateboard">Skateboard</label>
            <input type="checkbox" id="manga" name="hobbies[]" value="manga">
            <label for="manga">Manga</label>
            <input type="checkbox" id="cooking" name="hobbies[]" value="cuisiner">
            <label for="cooking">Cuisiner</label>
            <input type="checkbox" id="unicorn" name="hobbies[]" value="licorne">
            <label for="unicorn">Licorne</label><br>
            <button type="submit" name="submit">Rechercher</button>
        </form>
    </div>
    <?php
    //On form sent//
    if (isset($_POST['submit'])) {
        //Defining vars//
        $genre = $_POST['genre'];
        $city = $_POST['city'];
        $tranche_age = $_POST['age'];
        $hobbies = $_POST['hobbies'];
        $searchQuery = new MyDatabase;
        try {
            $query = $searchQuery->search_profile($genre, $city, $tranche_age, $hobbies);
            ?>
            <div class="searchedContainer">
            <?php
            foreach ($query as $res) {
                ?>
                <p class="searchedLine"><?php print $res['prenom'] . " | " . $res['nom'] . " | " . 
                $res['age'] . " ans | " . $res['ville'] . " | " . $res['loisirs']; ?> 
                <a href="./see_profile.php?login=<?php print $email . $res['id']; ?>">Voir le profil</a></p>
                <?php
            }
            ?>
            </div>
            <?php
        }
        catch(PDOException $e) {
            print "Erreur:" . $e->getMessage();
        }

    }
    ?>
    <script src="./script/jquery-3.6.0.js"></script>
    <script src="./script/script.js"></script>
</body>

</html>