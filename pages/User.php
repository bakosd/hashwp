<?php

class User
{
    private $session;

    // Constructor -> creates a Session class member's object.
    // So all the User object data is in the $_SESSION.
    public function __construct($usersID, $username, $email, $firstname, $lastname, $phonenumber, $birthdate, $licensecardNumber, $licensecardPlace, $idcardNumber, $state, $level, $avatar, $token, $tokenExpires, $password)
    {
        $this->session = new Session();
        $this->session->set('userID', $usersID);
        $this->session->set('username', $username);
        $this->session->set('email', $email);
        $this->session->set('firstname', $firstname);
        $this->session->set('lastname', $lastname);
        $this->session->set('phone', $phonenumber);
        $this->session->set('birthdate', $birthdate);
        $this->session->set('licenseNumber', $licensecardNumber);
        $this->session->set('licensePlace', $licensecardPlace);
        $this->session->set('personalNumber', $idcardNumber);
        $this->session->set('state', $state);
        $this->session->set('level', $level);
        $this->session->set('avatar', $avatar);
    }

    //Getter methods
    public function getUserID(): int
    {
        if(!$this->session->exists('userID'))
            $this->sqlValue('userID');
        return (int)$this->session->get('userID');
    }

    public function getUsername(): string
    {
        if(!$this->session->exists('username'))
            $this->sqlValue('username');
        return (string)$this->session->get('username');
    }

    public function getEmail(): string
    {
        if(!$this->session->exists('email'))
            $this->sqlValue('email');
        return (string)$this->session->get('email');
    }

    public function getFirstname(): string
    {
        if(!$this->session->exists('firstname'))
            $this->sqlValue('firstname');
        return (string)$this->session->get('firstname');
    }

    public function getLastname(): string
    {
        if(!$this->session->exists('lastname'))
            $this->sqlValue('lastname');
        return (string)$this->session->get('lastname');
    }

    public function getPhone(): string
    {
        if(!$this->session->exists('phone'))
            $this->sqlValue('phone');
        return (string)$this->session->get('phone');
    }

    public function getBirthdate(): string
    {
        if(!$this->session->exists('birthdate'))
            $this->sqlValue('birthdate');
        return (string)$this->session->get('birthdate');
    }

    public function getLicenseNumber(): string
    {
        if(!$this->session->exists('licenseNumber'))
            $this->sqlValue('licenseNumber');
        return (string)$this->session->get('licenseNumber');
    }

    public function getLicensePlace(): string
    {
        if(!$this->session->exists('licensePlace'))
            $this->sqlValue('licensePlace');
        return (string)$this->session->get('licensePlace');
    }

    public function getPersonalNumber(): string
    {
        if(!$this->session->exists('personalNumber'))
            $this->sqlValue('personalNumber');
        return (string)$this->session->get('personalNumber');
    }

    public function getState(): string
    {
        if(!$this->session->exists('state'))
            $this->sqlValue('state');
        return (string)$this->session->get('state');
    }

    public function getLevel(): string
    {
        if(!$this->session->exists('level'))
            $this->sqlValue('level');
        return (string)$this->session->get('level');
    }

    public function getAvatar(): string
    {
        if(!$this->session->exists('avatar'))
            $this->sqlValue('avatar');
        return (string)$this->session->get('avatar');
    }

    //Setter methods
    public function setUserID($value): void{

            $this->sqlValue('userID', true, $value);
    }

    public function setUsername($value): void{

            $this->sqlValue('username', true, $value);
    }

    public function setEmail($value): void{

            $this->sqlValue('email', true, $value);
    }

    public function setFirstname($value): void{

            $this->sqlValue('firstname', true, $value);
    }

    public function setLastname($value): void{

            $this->sqlValue('lastname', true, $value);
    }

    public function setPhone($value): void{

            $this->sqlValue('phone', true, $value);
    }

    public function setBirthdate($value): void{

            $this->sqlValue('birthdate', true, $value);

    }

    public function setLicenseNumber($value): void{

            $this->sqlValue('licenseNumber', true, $value);
    }

    public function setLicensePlace($value): void{

            $this->sqlValue('personalNumber', true, $value);
    }

    public function setPersonalNumber($value): void{

            $this->sqlValue('personalNumber', true, $value);

    }

    public function setState($value): void{
            $this->sqlValue('state', true, $value);
    }

    public function setLevel($value): void{
            $this->sqlValue('level', true, $value);
    }

    public function setAvatar($value): void{
            $this->sqlValue('avatar', true, $value);
    }


    private function sqlValue($name, $set = false, $value = "")
    {
        require_once "config.php";
        if ($this->session->exists('userID')) {
            $userID = $this->session->exists('userID');
            if (!$set) {
                $query = new SQLQuery(
                    'SELECT ' . $name . ' FROM users WHERE usersID = :param',
                    [':param' => $userID]
                );
                if ($query->getResult() != null) {
                    $this->session->set($name, $query->getDbq()->fetchColumn());
                } else {
                    $query = new SQLQuery(
                        'UPDATE ' . $name . ' SET ' . $name . ' = :param WHERE usersID = :param2',
                        [':param' => $name, ':param2' => $value]
                    );
                    if ($query->getResult() != null) {
                        $this->session->set($name, $value);
                    }
                }
            }
        }
    }
}