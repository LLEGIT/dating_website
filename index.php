    <?php
    require_once "config/db_manage.php";
    ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My_Galaxy_Homepage</title>
        <link rel="icon" href="./images/logo.ico">
        <link rel="stylesheet" href="./style/style.css">
    </head>

    <body>
    <header class="headerIndex">
        <h1>Bienvenue sur My Galaxy ! Trouvez l'étoile qui illuminera votre vie ❤️</h1><br>
        <img class="arrowDown" src="./images/arrow_down.png" alt="arrow down">
    </header>
        <div class="containerConnection">
            <h1>CONNEXION</h1>
            <form method="post" action="index.php">
                <label for="email">Adresse mail</label><br>
                <input type="email" name="email"><br>
                <label for="password">Mot de passe</label><br>
                <input type="password" name="password"><br>
                <button type="submit" name="submit">Se connecter</button>
            </form>
            <a href="account_creation.php">Pas de compte ? Créez en un !</a>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $query = new MyDatabase;
            $res = $query->do_users_exists($_POST['email']);
            if ($res == 1) {
                $check = $query->check_password($_POST['email'], $_POST['password']);
                if ($check === true) {
                    $email = $_POST['email'];
                    $query2 = new MyDatabase;
                    if ($query2->is_member_active($_POST['email']) == true) {
                        header("location: my_account.php?login=$email");
                        exit;
                    } else {
                        header("location: reactivate_profile.php?login=$email");
                        exit;
                    }
                } elseif ($check === false) {
        ?><span class="errors"><?php print "Erreur: mot de passe incorrect !"; ?></span>
                <?php
                    exit;
                }
            } elseif ($res == 0) {
                ?><span class="errors"><?php print "Erreur: aucun compte associé à ce mail !"; ?></span>
        <?php
            }
        }
        ?>
        <script src="./script/jquery-3.6.0.js"></script>
        <script src="./script/script.js"></script>
    </body>

    </html>