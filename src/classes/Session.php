<?php

namespace App\Classes;

class Session
{
    private $id;
    private $options;

    public function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public function get($key, $default="")
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
        
    }

    public static function changeConfigs()
    {

    }

    public function setFlash($key, $val)
    {
        if (!empty($key) && !empty($val)) {
            $_SESSION['_flashData'][$key] = $val;
        }
    }

    public function deleteFlash($key)
    {
        unset($_SESSION['_flashData'][$key]);
    }

    public function getFlash($key, $default="")
    {
        if (array_key_exists('_flashData', $_SESSION) && array_key_exists($key, $_SESSION['_flashData'])) {
            $flashedData = $_SESSION['_flashData'][$key];
            unset($_SESSION['_flashData'][$key]);
        } else {
            $flashedData = $default;
        }
        return $flashedData;
    }

    public function existsFlash($key)
    {
        if (isset($_SESSION['_flashData'][$key])) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        return $_SESSION;
    }

    public function destroy()
    {
        session_destroy();
        // destroy all the session data stored
    }

    public function clear($key)
    {
        $_SESSION[$key] = null;
    }

    public function exists($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        }
        return false;
    }
}
