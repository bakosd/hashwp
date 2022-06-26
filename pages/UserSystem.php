<?php

class UserSystem
{
    public static function tryRegister($username, $password, $firstname, $lastname, $birthdate, $email, $phone, $id_card, $license_number, $license_place): string
    {
        $returnValue = "";
        require_once "config.php";
        if (!UserSystem::checkUserExistence($username, $email)) {
            $token = UserSystem::createToken(40);
            $password = password_hash($password, PASSWORD_DEFAULT); // HASHING THE PASSWORD
            $query = new SQLQuery("INSERT INTO users (username, password, firstname, lastname, birthdate, email, phonenumber, idcardNumber, licensecardNumber, licensecardPlace, token, state, tokenExpires) VALUES (:username, :password, :firstname, :lastname, :birthdate, :email, :phonenumber, :idcardNumber, :licensecardNumber, :licensecardPlace, :token, :state, DATE_ADD(now(),INTERVAL 1 DAY))",
                [':username' => $username, ':password' => $password, ':firstname' => $firstname, ':lastname' => $lastname, ':birthdate' => $birthdate, ':email' => $email, ':phonenumber' => $phone, ':idcardNumber' => $id_card, ':licensecardNumber' => $license_number, ':licensecardPlace' => $license_place, ':token' => $token, ':state' => 0]
            );
            if ($query->getDbq()->rowCount() > 0) {
                if (UserSystem::sendEmail("activation",$email,$firstname, $lastname,"activate.php", "?token=".$token)) {
                    $returnValue = "Sikeres regisztráció.";
                } else {
                    $returnValue = "Nem sikerült elküldeni az email-t.";
                }
            } else {
                $returnValue = "Nem sikerült bevinni az adatokat az adatbázisba.";
            }
        } else {
            $returnValue = "Már létezik ilyen felhasználó.";
        }
        return $returnValue;
    }

    public static function tryActivate($token): bool
    {
        $query = new SQLQuery(
            "UPDATE users SET state=1, token='', tokenExpires='' WHERE binary token = :token AND tokenExpires>now()",
            [':token' => $token]
        );
        if ($query->getDbq()->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function tryRecovery($email): bool
    {
        $username = UserSystem::getUsernameFromEmail($email);
        $returnValue = false;
        if (UserSystem::checkUserExistence($username, $email)) {
            $query = new SQLQuery(
                "SELECT state, firstname, lastname FROM users WHERE username = :username AND email = :email",
                [':username' => $username, ':email' => $email]
            );
            if ($query->getDbq()->rowCount() > 0) {
                $res = $query->getResult()[0];
                if ($res->state == "1") {
                    $token = self::createToken(50);
                    $query2 = new SQLQuery(
                        "UPDATE users SET state=2, token=:token, tokenExpires= DATE_ADD(now(),INTERVAL 1 DAY) WHERE email = :email AND username = :username",
                        [':token' => $token, ':email' => $email, ':username' => $username]
                    );
                    if ($query2->getDbq()->rowCount() > 0) {
                        self::sendEmail("recovery",$email, $res->firstname, $res->lastname, "activate.php", "?token=".$token);

                        $returnValue = true;
                    }
                }
            }
        }
        return $returnValue;
    }

    public static function tryUpdatePassword($password, $token, $logged_in = false, $old_pass = null): bool
    {
        $session = null;
        $password = password_hash($password, PASSWORD_DEFAULT); // HASHING THE PASSWORD
        $query_string = "UPDATE users SET password=:password, state=1, token='', tokenExpires='' WHERE binary token = :token AND tokenExpires>now()";
        $query_array = [':password' => $password, ':token' => $token];

        if ($logged_in && !empty($old_pass)) {
            $session = new Session();
            $sub_query = new SQLQuery("SELECT password FROM users WHERE usersID = :usersID AND username = :username", [':usersID' => $session->get('userID'), ':username' => $session->get('username')]);
            $query_password = $sub_query->getResult()[0];
            ob_start();
            var_dump($sub_query);
            error_log(ob_get_clean());
            if (!empty($query_password->password))
                if (password_verify($old_pass, $query_password->password)) {
                    $query_string = "UPDATE users SET password=:password WHERE usersID = :usersID AND username = :username";
                    $query_array = [':password' => $password, ':usersID' => $session->get('userID'), ':username' => $session->get('username')];
                } else {
                    require_once "config.php";
                    redirection('index.php?rec=9');
                    exit();
                }
        }

        $query = new SQLQuery($query_string, $query_array);
        if ($query->getDbq()->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function tryUpdateSubscription($user, $value, $is_user): bool
    {
        if ($is_user)
            $query = new SQLQuery("UPDATE users SET subscribed = :subscribed WHERE email = :email", [':subscribed' => $value, ':email' => $user]);
        else
            /*  if($value != 1) // Fuuture unsubscribe from newsletter from link
                  $query = new SQLQuery("DELETE FROM newslettermails WHERE email = :email", [$user]);
              else*/
            $query = new SQLQuery("INSERT INTO newslettermails (email, subscription) VALUES (:email, :subscribed)", [':subscribed' => $value, ':email' => $user]);

        if ($query->getDbq()->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function tryLogin($user, $password): string
    {
        require_once "config.php";
        $user = UserSystem::getUsernameFromEmail($user);

        if (UserSystem::checkUserExistence($user)) {
            $query = new SQLQuery(
                "SELECT usersID, username, email, firstname, lastname, state, level, avatar, password, subscribed FROM users WHERE (username = :user OR email = :user ) LIMIT 1",
                [':user' => $user]
            );
            if ($query->getDbq()->rowCount() > 0) {
                $result = $query->getResult()[0];
                if (password_verify($password, $result->password)) {
                    if ((int)$result->state > 0) {
                        $session = new Session();
                        $result_array = array_values((array)$result);
                        unset($result_array[8]);
                        ksort($result_array);
                        $session->createUser(...$result_array);
                        return "Sikeresen bejelentkeztél!";
                    } else
                        return "Hiba, aktiváld a fiókot!";
                } else
                    return "Hibás bejelentkezési adatok!";
            } else
                return "Hibás bejelentkezési adatok!";
        } else
            return "Hibás bejelentkezési adatok!";
    }

    private static function checkUserExistence($username = "", $email = ""): bool
    {
        require_once "config.php";
        $query = null;
        if (!empty($username) && !empty($email)) {
            $query = new SQLQuery(
                "SELECT usersID FROM users WHERE username = :username OR email = :email",
                [':username' => $username, ':email' => $email]
            );

        } else if (!empty($username)) {
            $query = new SQLQuery(
                "SELECT usersID FROM users WHERE username = :username",
                [':username' => $username]
            );
        }

        if ($query->getDbq()->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function createToken($length): string
    {
        $down = 98;
        $up = 123;
        $i = 0;
        $code = "";
        $div = mt_rand(3, 9); // 3

        while ($i < $length) {
            if ($i % $div == 0)
                $character = strtoupper(chr(mt_rand($down, $up)));
            else
                $character = chr(mt_rand($down, $up)); // mt_rand(97,122) chr(98)
            $code .= $character; // $code = $code.$character; //
            $i++;
        }
        return $code;
    }

    public static function getUsernameFromEmail($user)
    {
        if (strpos($user, '@'))
            return substr($user, 0, strpos($user, "@")); // janos@gmail.com -> janos
        else
            return $user;
    }

    /**
     * @param string $name Parameter name
     * @param bool $set If false get, otherwise set
     * @param string $value The value for object if set
     */
    public static function value(string $name, bool $set = false, string $value = "", bool $sess = false): string
    {
        $returnValue = "";
        $session = new Session();
        require_once "config.php";
        if ($session->exists('userID')) {
            $userID = (string)$session->get('userID');
            if (!$set) {
                $query = new SQLQuery(
                    "SELECT :param0 FROM users WHERE usersID = :param1",
                    [':param0'=>$name,':param1' => $userID]
                );
                if ($query->getResult() != null) {
                    if ($sess) $session->forceSet($name, $query->getResult()[0]->$name);
                    $returnValue = (string)$query->getResult()[0]->$name;
                }
            } else {
                $query = new SQLQuery(
                    "UPDATE users SET ".$name." = :paramOne WHERE usersID = :paramTwo",
                    [':paramOne' => (string)$value, ':paramTwo' => (string)$userID]
                );

                if ($query->getResult() != null)
                    $returnValue = $value;

                if ($query->getDbq()->rowCount() > 0)
                    $session->forceSet($name, $value);
            }
        }
        return $returnValue;
    }

    public static function sendEmail($message_type, $mail, $firstname, $lastname, $site="", $token="", $carname="", $carid="", $archive_code=""): bool
    {
        $mail_type = [
            'activation' => "Felhasználó aktiváció!",
            'recovery' => "Jelszó visszaállítás!",
            'order' => 'Rendelési információk!',
            'order_approved' => "Rendelés megerősítve!",
            'order_denied' => "Rendelés elutasítva!",
            'order_resigned' => "Rendelés lemondva!",
            'order_archived' => "Rendelés befejezve!",
            'contact' => "$lastname $firstname üzent",
            'newsletter' => "Hash - hírlevél",
        ];
        $header = "From: Hash - do not reply <no-reply@hash.proj.vts.su.ac.rs>\n";
        $header .= "X-Sender: no-reply@hash.proj.vts.su.ac.rs/\n";
        $header .= "X-Mailer: PHP/" . phpversion();
        $header .= "X-Priority: 1\n";
        $header .= "Reply-To: no-reply@hash.proj.vts.su.ac.rs\r\n";
        $header .= "Content-Type: text/html; charset=UTF-8\n";
        require_once "config.php";
        if (!empty($mail_type))
            $subject = $mail_type[$message_type];
        else
            $subject = "Hash. support - üzenet önnek!";
        if (isset($site)){
            $site = SITE . $site;
        }
        $to = $mail;
        $message = getHTMLFormattedMessage($message_type, $lastname, $firstname, $site, $token, $carname, $carid, $archive_code);
        return mail($to, $subject, $message, $header);
    }
}