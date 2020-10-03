<?php

namespace App\Component;

/**
 * Class Notifier
 */
class Notifier
{
    /**
     * @param string $type
     * @param string $message
     *
     * @return bool
     */
    public static function addNotification(string $type, string $message): bool
    {
        $_SESSION['notification-type'] = $type;
        $_SESSION['notification'] = $message;

        return self::hasNotification();
    }

    /**
     * @return string
     */
    public static function getNotification(): string
    {
        return $_SESSION['notification'] ?? '';
    }

    /**
     * @return string
     */
    public static function getNotificationType(): string
    {
        return $_SESSION['notification-type'] ?? '';
    }

    /**
     * @return bool
     */
    public static function hasNotification(): bool
    {
        return isset($_SESSION['notification']);
    }

    /**
     * @return bool
     */
    public static function clearNotification(): bool
    {
        unset($_SESSION['notification-type'], $_SESSION['notification']);

        return !self::hasNotification();
    }
}
