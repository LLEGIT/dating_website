<?php
require_once "config/db_manage.php";
$email = $_GET['login'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My_Galaxy_Account</title>
    <link rel="icon" href="./images/logo.ico">
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <a class="searchLink" href="search_profile.php?login=<?php print $email; ?>">Rechercher une personne 🔎</a>
    <?php
    $query = new MyDatabase;
    $arrInfos = $query->get_infos($email);
    $name = $arrInfos['nom'];
    $firstname = $arrInfos['prenom'];
    $age = $arrInfos['age'];
    $genre = $arrInfos['genre'];
    $hobbies = $arrInfos['loisirs'];
    $city = $arrInfos['ville'];
    ?>
    <header class="headerProfile">
        <img class="arrowDown" src="./images/arrow_down.png" alt="arrow down">
        <h1>Mon compte & infos</h1>
        <img class="arrowDown" src="./images/arrow_down.png" alt="arrow down">
    </header>
    <div class="containerProfile">
        <img id="avatarImg" src="./images/avatar.png" alt="avatar icon"><br>
        <span class="infos"><?php print $firstname . " " . $name; ?></span><br>
        <span class="infos"><img src="./images/mail_logo.png" alt="mail logo"><?php print $email; ?></span><br>
        <span class="infos"><img src="./images/calendar_logo.png" alt="calendar logo"><?php print $age; ?> ans</span><br>
        <span class="infos"><img src="./images/male_female_logo.png" alt="male/female logo"><?php print $genre; ?></span><br>
        <span class="infos"><img src="./images/icone_ville.png" alt="city logo"><?php print $city; ?></span><br>
        <span class="infos"><img id="hobbiesLogo" src="./images/hobbies_logo.png" alt="hobbies logo"><?php print $hobbies; ?></span><br>
        <a class="accountLinks" href="edit_profile.php?login=<?php print $email ?>">MODIFIER LE MAIL/MDP</a><br>
        <a class="accountLinks" href="delete_profile.php?login=<?php print $email; ?>">SUPPRIMER LE COMPTE</a>
        <a class="accountLinks" id="disconnect" href="./index.php">SE DÉCONNECTER</a>
    </div>
    <script src="./script/jquery-3.6.0.js"></script>
    <script src="./script/script.js"></script>
</body>

</html>