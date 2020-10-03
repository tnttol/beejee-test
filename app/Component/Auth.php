<?php

namespace App\Component;

/**
 * Class Auth
 */
class Auth
{
    /** @var array */
    private static $users;

    /**
     * Init Session
     */
    private static function init(): void
    {
        $isStarted = session_status() === PHP_SESSION_ACTIVE;

        if (!$isStarted) {
            session_name('TEST_SESS');
            session_start();
        }
    }

    /**
     * @param array $users
     */
    public static function setUsers(array $users): void
    {
        self::$users = $users;

        self::init();
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public static function login(string $username, string $password): bool
    {
        $isAuth = isset(self::$users[$username]) && self::$users[$username] === $password;

        $_SESSION['is_auth'] = $isAuth;

        return $isAuth;
    }

    /**
     * @return bool
     */
    public static function isAuth(): bool
    {
        return (bool)($_SESSION['is_auth'] ?? false);
    }

    /**
     * logout
     */
    public static function logout(): bool
    {
        unset($_SESSION['is_auth']);

        return !isset($_SESSION['is_auth']);
    }
}
