<?php
namespace App\Helpers;

class Arrays 
{
    public static function errorView()
    {
        return[
            'required' => ':attribute is required',
            'email' => 'field :attribute is required',
            'min' => 'field :attribute is less than required amount',
            'same' => 'field :attribute is not the same'
        ];
    }

    public static function fieldNameTranslations()
    {
        return [
            'name' => 'نام',
            'email' => 'ایمیل',
            'password' => 'رمزعبور',
            'confirmPass' => 'تایید رمزعبور'
        ];
    }

    public static function sessionOptions()
    {
        return[
            // 'cache_expire' => 180,
            // 'cache_limiter' => 'nocache',
            // 'cookie_domain' => '',
            'cookie_httponly' => true,
            'cookie_lifetime' => 8000,
            // 'cookie_path' => '/',
            'cookie_samesite' => 'Strict',
            'cookie_secure'   => true,
            // 'gc_divisor' => 100,
            // 'gc_maxlifetime' => 1440,
            // 'gc_probability' => true,
            // 'lazy_write' => true,
            // 'name' => 'PHPSESSID',
            // 'read_and_close' => false,
            // 'referer_check' => '',
            // 'save_handler' => 'files',
            // 'save_path' => '',
            // 'serialize_handler' => 'php',
            // 'sid_bits_per_character' => 4,
            // 'sid_length' => 32,
            // 'trans_sid_hosts' => $_SERVER['HTTP_HOST'],
            // 'trans_sid_tags' => 'a=href,area=href,frame=src,form=',
            // 'use_cookies' => true,
            // 'use_only_cookies' => true,
            // 'use_strict_mode' => false,
            // 'use_trans_sid' => false,
        ];
    }
}
