<?php
namespace App\Classes;

class Cookie 
{
    protected $name;
    protected $content;
    protected $expire;

    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    public function setContent($value)
    {
        $this->content = $value;
        return $this;
    }

    public function setExpire($value)
    {
        $this->expire = $value;
        return $this;
    }

    public function add()
    {
        $_COOKIE[$this->name] = $this->content;
        setcookie($this->name, $this->content, strtotime($this->expire), '/');
        return $this;
    }

    public function remove()
    {
        setcookie($this->name, "", time()-3600, '/');
    }

    public function get($name)
    {
        $content = null;
        if(array_key_exists($name, $_COOKIE)) {
            $content = $_COOKIE[$name];
        }
        return $content;
    }
}
?>
