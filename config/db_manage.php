<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_my_meetic');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

class MyDatabase
{
    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;
    private $dbUser = DB_USER;
    private $dbPassword = DB_PASSWORD;

    private $dbHandler;
    private $error;

    //Handling connection to DB//
    public function connect_to_db()
    {
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPassword, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //Adding user to db//
    public function add_user_to_db($name, $firstname, $birthdate, $genre, $city, $email, $password_hash, $hobbies)
    {
        $dbHandler = $this->connect_to_db();
        $sql = "REPLACE INTO users (nom, prenom, date_de_naissance, genre, ville, email, mot_de_passe_hash, loisirs, membre_actif) 
VALUES ('$name', '$firstname', '$birthdate', '$genre', '$city', '$email', '$password_hash', '$hobbies', '1')";
        try {
            $this->dbHandler->exec($sql);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //Checking if mail is in a row of users table//
    public function do_users_exists($email)
    {
        $dbHandler = $this->connect_to_db();
        $sql = "SELECT * FROM users WHERE email='$email'";
        $query = $this->dbHandler->prepare($sql);
        $query->execute();
        $res = $query->fetchAll();
        if (empty($res)) {
            return 0;
        } else {
            return 1;
        }
    }

    //Checking password given for connection with hashed password of DB//
    public function check_password($email, $password)
    {
        $dbHandler = $this->connect_to_db();
        $sql = "SELECT mot_de_passe_hash FROM users WHERE email='$email'";
        foreach ($this->dbHandler->query($sql) as $row) {
            $hashed_password = $row['mot_de_passe_hash'];
        }
        $check = password_verify($password, $hashed_password);
        if ($check === true) {
            return true;
        } elseif ($check === false) {
            return false;
        }
    }

    //To get infos from member from DB//
    public function get_infos($email)
    {
        $dbHandler = $this->connect_to_db();
        $sql = "SELECT *, FLOOR(DATEDIFF(CURRENT_DATE, date_de_naissance) / 365) AS 'age' FROM users WHERE email = '$email'";
        $query = $this->dbHandler->prepare($sql);
        try {
            $query->execute();
            $res = $query->fetch();
            return $res;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    //Updating infos with ones given//
    public function edit_profile($email, $password, $newMail, $newPassword)
    {
        $checkPassword = $this->check_password($email, $password);
        $new_password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
        if ($checkPassword == true) {
            try {
                $sql = "UPDATE users 
SET email = '$newMail', mot_de_passe_hash = '$new_password_hash' 
WHERE email = '$email'";
                $update = $this->dbHandler->prepare($sql);
                $update->execute();
                return true;
            } catch (PDOException $e) {
                print $e->getMessage();
            }
        } else {
            return false;
        }
    }

    //Passing members to inactive//
    public function pass_member_to_inactive($email)
    {
        $dbHandler = $this->connect_to_db();
        $sql = "UPDATE users SET membre_actif = '0' WHERE email = '$email'";
        try {
            $remove = $this->dbHandler->prepare($sql);
            $remove->execute();
            header("location: index.php");
            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    //Passing members back to active//
    public function pass_member_to_active($email)
    {
        $dbHandler = $this->connect_to_db();
        $sql = "UPDATE users SET membre_actif = '1' WHERE email = '$email'";
        try {
            $getBackToActive = $this->dbHandler->prepare($sql);
            $getBackToActive->execute();
            header("location: index.php");
            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    //Checking if member active or not during connection//
    public function is_member_active($email)
    {
        $dbHandler = $this->connect_to_db();
        $sql = "SELECT membre_actif FROM users WHERE email='$email'";
        $query = $this->dbHandler->prepare($sql);
        $query->execute();
        $res = $query->fetch();
        if ($res['membre_actif'] === 1) {
            return true;
        } else {
            return false;
        }
    }

    //Searching other members//
    public function search_profile($genre, $city, $tranche_age, $hobbies)
    {
        $dbHandler = $this->connect_to_db();
        $age1 = substr($tranche_age, 0, 2);
        $age2 = substr($tranche_age, 2);
        $hobbiesArr = [];
        foreach ($hobbies as $hobby) {
            //For the first hobby//
            if ($hobby === $hobbies[0]) {
                $hobbyWithQuotes = "'%" . $hobby . "%'";
            } else {
                //Parsing every hobbies to be checked alone//
                $hobbyWithQuotes = "OR loisirs LIKE '%" . $hobby . "%'";
            }
            array_push($hobbiesArr, $hobbyWithQuotes);
        }
        $hobbiesString = implode(" ", $hobbiesArr);
        $sql = "SELECT id, prenom, nom, genre, ville, FLOOR(DATEDIFF(CURRENT_DATE, date_de_naissance) / 365) as 'age', loisirs
        FROM users WHERE genre = '$genre' AND ville = '$city' 
        AND FLOOR(DATEDIFF(CURRENT_DATE, date_de_naissance) / 365) BETWEEN $age1 AND $age2 AND loisirs LIKE $hobbiesString";
        try {
            $query = $this->dbHandler->query($sql);
            $res = $query->fetchAll();
            return $res;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    //See profile of someone searched//
    public function see_profile($id)
    {
        $dbHandler = $this->connect_to_db();
        $sql = "SELECT *, FLOOR(DATEDIFF(CURRENT_DATE, date_de_naissance) / 365) AS 'age' FROM users WHERE id = '$id'";
        $query = $this->dbHandler->prepare($sql);
        try {
            $query->execute();
            $res = $query->fetch();
            return $res;
            return $res;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
}
