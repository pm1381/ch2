<?php

namespace App\Classes;

use App\Helpers\Tools;

class Date
{
    public static function autoTime($num, $value, $format = "Y-m-d H:i:s")
    {
        return date($format, strtotime("+$num $value"));
    }

    public static function now()
    {
        return date("Y-m-d H:i:s");
    }

    public static function getCurrentDate()
    {
        return date("Y-m-d");
    }

    public static function getCurrentTime()
    {
        return date("H:i:s");
    }

    public static function isTimestamp($string)
    {
        try {
            new \DateTime('@' . $string);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public static function ago($date)
    {
        $time1 = new \DateTime(date("Y-m-d H:i:s", $date));
        $time2 = new \DateTime(date("Y-m-d H:i:s"));

        $diff = $time1->diff($time2);

        if ($diff->y > 0) {
            $ago = $diff->y . ' سال';
        } elseif ($diff->m > 0) {
            $ago = $diff->m . ' ماه';
        } elseif ($diff->d > 0) {
            $ago = $diff->d . ' روز';
        } elseif ($diff->h > 0) {
            $ago = $diff->h . ' ساعت';
        } elseif ($diff->i > 0) {
            $ago = $diff->i . ' دقیقه';
        } else {
            $ago = $diff->s . ' ثانیه';
        }

        return 'حدود ' . $ago . ' پیش';
    }

    // phpcs:ignore
    public static function M2J($format, $date = "")
    {
        if (!$date) {
            $date = self::now();
        }

        if (!self::isTimestamp($date)) {
            if (strtotime($date)) {
                $date = strtotime($date);
            } else {
                return '';
            }
        } elseif ($date < 0) {
            return '';
        }

        return jdate($format, $date);
    }

    // phpcs:ignore
    public static function J2M($format, $date)
    {
        $date = explode(" ", Tools::numberToEn($date));
        $array = explode("/", $date[0]);
        $getDate = jalali_to_gregorian($array[0], $array[1], $array[2]);

        $time = "";
        if (isset($date[1])) {
            $time = $date[1];
        }

        return date($format, strtotime(trim($getDate[0] . '-' . $getDate[1] . '-' . $getDate[2] . ' ' . $time)));
    }
}
