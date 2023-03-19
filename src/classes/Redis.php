<?php

namespace App\Classes;

use Predis\Client;

class Redis
{
    private $predis;
    private $keyName;

    public function __construct($key = "")
    {
        $this->predis = new Client();
        //redis-cli -h 127.0.0.1 -p 6379 -a "mypass" connecting to redis remote server
        $this->keyName = $key;
    }

    public function getKeyName()
    {
        return $this->keyName;
        return $this;
    }

    public function setKeyName($name)
    {
        $this->keyName = $name;
        return $this;
    }

    public function getPredis()
    {
        return $this->predis;
        return $this;
    }

    public function store($value)
    {
        $this->predis->set($this->keyName, $value);
        return $this;
    }

    public function delete()
    {
        $this->predis->del($this->keyName);
        return $this;
    }

    public function exists()
    {
        return $this->predis->exists($this->keyName);
    }

    public function mGet()
    {
        return $this->predis->mget($this->keyName);
    }

    public function setEX($seconds, $val)
    {
        return $this->predis->setex($this->keyName, $seconds, $val);
    }

    public function append($val)
    {
        $this->predis->append($this->keyName, $val);
        return $this;
    }

    public function renameKey($newKey)
    {
        $this->predis->renamenx($this->keyName, $newKey);
        return $this;
    }

    public function timeRemain()
    {
        return $this->predis->ttl($this->keyName);
        // return time has been remain until rxpire time of key in seconds;
    }

    public function removeExp()
    {
        $this->predis->persist($this->keyName);
        return $this;
    }

    public function dump($key)
    {
        return $this->predis->dump($key);
        //giving a serialized value
    }

    public function expireDate($seconds)
    {
        $this->predis->expire($this->keyName, $seconds);
        return $this;
    }

    public function pushList($val)
    {
        $this->predis->lpush($this->keyName, $val);
        return $this;
    }

    public function popList($start, $end)
    {
        $this->predis->lrange($this->keyName, $start, $end);
        return $this;
    }

    public function getKeys($pattern = "*")
    {
        $this->predis->keys($pattern);
        return $this;
    }

    public function get()
    {
        $result = $this->predis->get($this->keyName);
        if ($result == "") {
            return false;
        }
        return $this->predis->get($this->keyName);
    }

    public function hashDelete(array $fields)
    {
        $this->predis->hdel($this->keyName, $fields);
        return $this;
    }

    public function hashExists($field)
    {
        return $this->predis->hexists($this->keyName, $field);
    }

    public function hashData($key)
    {
        return $this->predis->hgetall($key);
    }

    public function getFieldValue($field)
    {
        return $this->predis->hget($this->keyName, $field);
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
