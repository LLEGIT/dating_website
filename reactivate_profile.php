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
    <link rel="favicon" href="./images/logo.ico">
    <link rel="stylesheet" href="./style/style.css">
    <title>My_Galaxy_Reactivate</title>
</head>

<body>
    <div class="containerReactivate">
        <h1>CE COMPTE A ÉTÉ SUPPRIMÉ, RÉACTIVER LE COMPTE ?</h1>
        <form action="reactivate_profile.php?login=<?php print $email; ?>" method="POST">
            <button type="submit" name="submit" id="deleteConf">RÉACTIVER</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $query = new MyDatabase;
            $query->pass_member_to_active($email);
        }
        ?>
        <a href="index.php">Revenir à l'accueil</a>
    </div>
</body>

</html>