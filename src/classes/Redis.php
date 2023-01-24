<?php

namespace App\Classes;

use Predis\Client;

class Redis
{
    private $predis;

    public function __construct()
    {
        $this->predis = new Client();
        //redis-cli -h 127.0.0.1 -p 6379 -a "mypass" connecting to redis remote server
    }

    public function getPredis()
    {
        return $this->predis;
    }

    public function store($key, $value)
    {
        $this->predis->set($key, $value);
    }

    public function delete($key)
    {
        $this->predis->del($key);
    }

    public function exists($key)
    {
        return $this->predis->exists($key);
    }

    public function mGet($keys)
    {
        return $this->predis->mget($keys);
    }

    public function setEX($key, $seconds, $val)
    {
        return $this->predis->setex($key, $seconds, $val);
    }

    public function append($key, $val)
    {
        $this->predis->append($key, $val);
    }

    public function renameKey($key, $newKey)
    {
        $this->predis->renamenx($key, $newKey);
    }

    public function timeRemain($key)
    {
        return $this->predis->ttl($key);
        // return time has been remain until rxpire time of key in seconds;
    }

    public function removeExp($key)
    {
        $this->predis->persist($key);
    }

    public function dump($key)
    {
        return $this->predis->dump($key);
        //giving a serialized value
    }

    public function expireDate($key, $seconds)
    {
        $this->predis->expire($key, $seconds);
    }

    public function pushList($key, $val)
    {
        $this->predis->lpush($key, $val);
    }

    public function popList($key, $start, $end)
    {
        $this->predis->lrange($key, $start, $end);
    }

    public function getKeys($pattern="*")
    {
        $this->predis->keys($pattern);
    }

    public function get($key) {
        $result = $this->predis->get($key);
        if ($result == "") {
            return false;
        }
        return $this->predis->get($key);
    }

    public function hashDelete($key, array $fields)
    {
        $this->predis->hdel($key, $fields);
    }

    public function hashExists($key, $field)
    {
        return $this->predis->hexists($key, $field);
    }

    public function hashData($key)
    {
        return $this->predis->hgetall($key);
    }

    public function getFieldValue($key, $field)
    {
        return $this->predis->hget($key, $field);
    }

    public function setFieldValue($key, $field, $val)
    {
        return $this->predis->hset($key, $field, $val);
    }

    public function getFields($key)
    {
        return $this->predis->hkeys($key);
    }

    public function empty()
    {
        $this->predis->flushdb();
    }

    public function getVals($key)
    {
        return $this->predis->hvals($key);
    }

    public function iterator($key)
    {
        return $this->predis->hscan($key, 0);
    }

}