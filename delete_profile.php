<?php
require_once "./config/db_manage.php";
$email = $_GET['login'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="favicon" href="./images/logo.ico">
    <link rel="stylesheet" href="./style/style.css">
    <title>My_Galaxy_Remove</title>
</head>
<body>
    <div class="containerDelete">
        <h1>ÊTES VOUS SÛR DE VOULOIR SUPPRIMER LE COMPTE ?</h1>
        <form action="delete_profile.php?login=<?php print $email; ?>" method="POST">
            <button type="submit" name="submit" id="deleteConf">CONFIRMATION</button>
        </form>
        <?php
        if (isset($_POST['submit'])){
            $query = new MyDatabase;
            $query->pass_member_to_inactive($email);
        }    
        ?>
        <br>
        <a href="./my_account.php?login=<?php print $email; ?>">Annuler et revenir au profil</a>
    </div>    
</body>
</html>