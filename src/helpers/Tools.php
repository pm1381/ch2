<?php

namespace App\Helpers;

use App\Exceptions\Exception404;
use Rakit\Validation\ErrorBag;

class Tools
{
    public static function manageCUrl($params, $header, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        if (count($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if (count($params)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function slashToBackSlash($string)
    {
        return str_replace("/", "\\", $string);
    }

    public static function checkArray($key, $array)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        return '';
    }

    public static function checkObject($object, $property)
    {
        if (property_exists($object, $property)) {
            return $object->$property;
        }
        return '';
    }

    public static function createCode()
    {
        return rand(10000, 100000);
    }

    public static function getIp()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    public static function createUniqueToken($model)
    {
        do {
            $token = Tools::createSalt();
            $result = $model->getByFieldName('token', $token);
            $cnt = count($result);
        } while ($cnt > 0);
        return $token;
    }

    public static function getFilesInFolder($path, array $ignoreClasses = [])
    {
        $ignoreClasses[] = '.';
        $ignoreClasses[] = '..';
        $files = array_values(array_diff(scandir($path), $ignoreClasses));
        return $files;
    }

    public static function render($template, $found = [])
    {
        $file = VIEW . $template . '.php';
        if (file_exists($file)) {
            $data = json_decode(json_encode($found, JSON_INVALID_UTF8_IGNORE));
            require_once $file;
        } else {
            print_f("page not found");
        }
    }

    public static function translateErrors(ErrorBag $allErrors, $translation)
    {
        $messages = $allErrors->messages;
        foreach ($messages as $from => $valueArray) {
            foreach ($valueArray as $key => $value) {
                $value = strtolower($value);
                foreach ($translation as $k => $trans) {
                    if (strpos($value, $k) !== false) {
                        $value = str_replace($k, $trans, $value);
                        $messages[$from][$key] = $value;
                        break;
                    }
                }
            }
        }
        $allErrors->messages = $messages;
        return $allErrors;
    }

    public static function createSalt()
    {
        return password_hash(rand(100000000, 900000000), PASSWORD_DEFAULT);
    }

    public static function redirect($url, $code = 301)
    {
        header("location: " . $url, true, $code);
        exit();
    }

    public static function backSlashToSlash($string)
    {
        return str_replace("\\", "/", $string);
    }

    public static function uniteUrls($url)
    {
        $lastChar = substr($url, -1);
        if ($lastChar != "/") {
            $url .= "/";
        }
        return $url;
    }

    public static function getUrl()
    {
        return ORIGIN . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
