<?php

class Session
{
    public function __construct(string $cacheExpire = null)
    {
        if (session_status() === PHP_SESSION_NONE) {

            if ($cacheExpire !== null) {
                session_cache_expire($cacheExpire); // To add expire time to a session
            }

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

    public function clear(): void
    {
        session_unset();
    }
}