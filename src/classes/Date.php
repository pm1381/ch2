<?php

namespace App\Classes;

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
}
