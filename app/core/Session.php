<?php

namespace App\Core;

class Session
{
    /**
     * Check session exists or not by a key
     *
     * @param string|int $key
     * @return boolean
     */
    public static function has(string|int $key): bool
    {
        return (bool) self::get($key);
    }

    /**
     * Store data to session
     *
     * @param string|int $key
     * @param $value
     * @return void
     */
    public static function put(string|int $key, $value): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION[$key] = $value;
    }

    /**
     * Get session data
     *
     * @param string|int $key
     * @param $default
     * @return void
     */
    public static function get(string|int $key, $default = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    /**
     * Flash data into session
     *
     * @param string|int $key
     * @param $value
     * @return void
     */
    public static function flash(string|int $key, $value): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['_flash'][$key][] = $value;
    }


    /**
     * Remove all flash data from session
     *
     * @return void
     */
    public static function unflash(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['_flash'])) unset($_SESSION['_flash']);
    }

    /**
     * Remove all session data
     *
     * @return void
     */
    public static function flush(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
    }

    /**
     * Destroy all session data
     *
     * @return void
     */
    public static function destroy(): void
    {
        self::flush();

        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
