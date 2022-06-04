<?php

class Session
{
    public function __construct(string $cacheExpire = null)
    {
        $samesite = 'None';
        if (session_status() === PHP_SESSION_NONE) {

            if ($cacheExpire !== null) {
                session_cache_expire($cacheExpire); // To add expire time to a session
            }
            session_set_cookie_params(array(
                'samesite' => $samesite,
                'domain' => $_SERVER['HTTP_HOST'],
                'secure' => true,
                'httponly' => true
            ));
            session_start();
        }
    }

    public function exists(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function set(string $key, $value): self
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function get(string $key)
    {
        if ($this->exists($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    public function remove(string $key): void
    {
        if ($this->exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function clear(): bool
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_regenerate_id();
     return session_destroy();
    }

    public function createUser($usersID, $username, $email, $firstname, $lastname, $state, $level, $avatar, $password)
    {
        $this->set('userID', $usersID);
        $this->set('username', $username);
        $this->set('email', $email);
        $this->set('firstname', $firstname);
        $this->set('lastname', $lastname);
        $this->set('state', $state);
        $this->set('level', $level);
        $this->set('avatar', $avatar);
        $this->set('logged', time());
    }
}