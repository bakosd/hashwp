<?php

class UserSystem
{
    public static function tryRegister($username, $password, $firstname, $lastname, $birthdate, $email, $phone, $id_card, $license_number, $license_place):string{
        $returnValue = "";
        require_once "config.php";
        if(!UserSystem::checkUserExistence($username, $email)) {
            $token = UserSystem::createToken(40);
            $password = password_hash($password, PASSWORD_DEFAULT); // HASHING THE PASSWORD
            $query = new SQLQuery("INSERT INTO users (username, password, firstname, lastname, birthdate, email, phonenumber, idcardNumber, licensecardNumber, licensecardPlace, token, state, tokenExpires) VALUES (:username, :password, :firstname, :lastname, :birthdate, :email, :phonenumber, :idcardNumber, :licensecardNumber, :licensecardPlace, :token, :state, DATE_ADD(now(),INTERVAL 1 DAY))",
                [':username' => $username, ':password' => $password, ':firstname' => $firstname, ':lastname' => $lastname, ':birthdate' => $birthdate, ':email' => $email, ':phonenumber' => $phone, ':idcardNumber' => $id_card, ':licensecardNumber' => $license_number, ':licensecardPlace' => $license_place, ':token' => $token, ':state' => 0]
            );
            if ($query->getDbq()->rowCount() > 0){
                if(UserSystem::sendEmail($firstname, $lastname, $email, $token, "register")){
                    $returnValue = "Sikeres regisztráció.";
                }
                else {
                    $returnValue = "Nem sikerült elküldeni az email-t.";
                }
            }
            else{
                $returnValue = "Nem sikerült bevinni az adatokat az adatbázisba.";
            }
        }
        else{
            $returnValue = "Már létezik ilyen felhasználó.";
        }
        return $returnValue;
    }

    public static function tryActivate($token):bool{
        $query = new SQLQuery(
            "UPDATE users SET state=1, token='', tokenExpires='' WHERE binary token = :token AND tokenExpires>now()",
            [':token' => $token]
        );
        if($query->getDbq()->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function tryRecovery($email):bool{
        $username = UserSystem::getUsernameFromEmail($email);
        $returnValue = false;
        if(UserSystem::checkUserExistence($username, $email)){
            $query = new SQLQuery(
                "SELECT state, firstname, lastname FROM users WHERE username = :username AND email = :email",
                [':username' => $username, ':email' => $email]
            );
            if($query->getDbq()->rowCount() > 0) {
                $res = $query->getResult()[0];
                if ($res->state == "1") {
                    $token = self::createToken(50);
                    $query2 = new SQLQuery(
                        "UPDATE users SET state=2, token=:token, tokenExpires= DATE_ADD(now(),INTERVAL 1 DAY) WHERE email = :email AND username = :username",
                        [':token' => $token, ':email' => $email, ':username' => $username]
                    );
                    if ($query2->getDbq()->rowCount() > 0) {
                        self::sendEmail($res->firstname, $res->lastname, $email, $token, "recovery");

                        $returnValue = true;
                    }
                }
            }
        }
        return $returnValue;
    }
    public static function tryUpdatePassword($password, $token):bool{
        $password = password_hash($password, PASSWORD_DEFAULT); // HASHING THE PASSWORD
        $query = new SQLQuery(
            "UPDATE users SET password=:password, state=1, token='', tokenExpires='' WHERE binary token = :token AND tokenExpires>now()",
            [':password'=>$password,':token' => $token]
        );
        if($query->getDbq()->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function tryLogin($user, $password):string{
        require_once "config.php";
        $user = UserSystem::getUsernameFromEmail($user);

        if(UserSystem::checkUserExistence($user)){
            $query = new SQLQuery(
                "SELECT password, usersID, username, email, firstname, lastname, state, level, avatar FROM users WHERE (username = :user OR email = :user ) LIMIT 1",
                [':user' => $user]
            );
            if ($query->getDbq()->rowCount() > 0) {
                $result = $query->getResult()[0];
                if(password_verify($password, $result->password)) {
                    if ((int)$result->state > 0) {
                        $session = new Session();
                        $session->createUser(...(array)$result);
                        return "Sikeresen bejelentkeztél!";
                    }
                    else
                        return "Hiba, aktiváld a fiókot!";
                }
                else
                    return "Hibás bejelentkezési adatok!";
            }
            else
                return "Hibás bejelentkezési adatok!";
        }
        else
            return "Hibás bejelentkezési adatok!";
    }

    private static function checkUserExistence($username="", $email=""):bool
    {
        require_once "config.php";
        $query = null;
        if (!empty($username) && !empty($email)) {
            $query = new SQLQuery(
                "SELECT usersID FROM users WHERE username = :username OR email = :email",
                [':username' => $username, ':email' => $email]
            );

        }else if(!empty($username)){
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

    public static function getUsernameFromEmail($user){
        if(strpos($user, '@'))
            return substr($user, 0, strpos($user, "@")); // janos@gmail.com -> janos
        else
            return $user;
    }

    /**
     * @param string $name Parameter name
     * @param bool $set If false get, otherwise set
     * @param string $value The value for object if set
     */
    public static function value(string $name, bool $set = false, string $value = "")
    {
        $session = new Session();
        require_once "config.php";
        if ($session->exists('userID')) {
            $userID = $session->get('userID');
            if (!$set) {
                $query = new SQLQuery(
                    'SELECT ' . $name . ' FROM users WHERE usersID = :param',
                    [':param' => $userID]
                );
                if ($query->getResult() != null) {
                    $session->set($name, (string)$query->getResult()[0]->$name);
                } else {
                    $query = new SQLQuery(
                        'UPDATE users SET ' . $name . ' = :param WHERE usersID = :param2',
                        [':param' => $name, ':param2' => $userID]
                    );
                    if ($query->getResult() != null) {
                        $session->set($name, $value);
                    }
                }
            }
        }
    }

    public static function sendEmail($firstname, $lastname, $mail, $token="", $type = ""): bool
    {
        $header = "From: Hash Carrent <no-reply@hash.proj.vts.su.ac.rs>\n";
        $header .= "X-Sender: no-reply@hash.proj.vts.su.ac.rs/\n";
        $header .= "X-Mailer: PHP/" . phpversion();
        $header .= "X-Priority: 1\n";
        $header .= "Reply-To: support@hash.proj.vts.su.ac.rs\r\n";
        $header .= "Content-Type: text/html; charset=UTF-8\n";

        $sub = "";
        $message = "Data:\n\n user: $firstname $lastname \n \n www.vts.su.ac.rs";
        $message .= "\n\n ";
        if($type == "register") {
            $message .= "to activate";
            $sub = "Account activation";
        }elseif ($type == "recovery"){
            $message .= "to recovery";
            $sub = "Password recovery";
        }
        $message .= " your account click on the link: " . SITE . "activate.php?token=$token";
        $to = $mail;
        $subject = $sub." at VTS";
        return mail($to, $subject, $message, $header);
    }
}