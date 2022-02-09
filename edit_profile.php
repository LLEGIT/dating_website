<?php 
require_once "./config/db_manage.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My_Galaxy_Edit</title>
    <link rel="icon" href="logo.ico">
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <?php
    //Getting back original mail & password//
    $email = $_GET['login'];
    $query = new MyDatabase;
    $arrInfos = $query->get_infos($email);
    $originalPassword = $arrInfos['mot_de_passe_hash'];
    ?>
    <div class="containerEdit">
        <h1>MODIFIER LE COMPTE</h1>
        <form action="edit_profile.php?login=<?php print $email; ?>" method="post">
            <label for="emailChange">Changer d'adresse mail (sinon ne pas écrire)</label><br>
            <input type="mail" value="<?php print $email;?>" name="emailChange" required><br>
            <label for="passwordChange">Changer de mot de passe (sinon ne pas écrire)</label><br>
            <input type="password" name="passwordChange"><br>
            <label for="originalPassword">Veuillez entrer votre ancien mot de passe pour enregistrer</label><br>
            <input type="password" name="originalPassword"><br>
            <button type="submit" name="submit">Enregistrer</button>
        </form>
        <a href="./my_account.php?login=<?php print $email; ?>">Revenir au compte</a>
    </div>

    <?php
    //On submit//
    if (isset($_POST['submit'])) {
        $newMail = $_POST['emailChange'];
        $password = $_POST['originalPassword'];
        if ($_POST['passwordChange']) {
            $newPassword = $_POST['passwordChange'];
        }
        else {
            $newPassword = $password;
        }
        $update_query = new MyDatabase;
        $res = $update_query->edit_profile($email, $password, $newMail, $newPassword);
        if ($res === true) {
            header("location: my_account.php?login=$newMail");
            exit;
        }
        elseif ($res === false) {
            ?><span class="errors"><?php print "Erreur: ancien mot de passe incorrect !";?></span><?php
        }
    }
    ?>
</body>
</html>