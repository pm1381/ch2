<?php

namespace App\Entities;

use App\Classes\Cookie;
use App\Classes\Jwt;
use App\Classes\Session;
use App\Models\Admin as ModelsAdmin;
use DateTimeImmutable;

class Admin
{
    private int $isSuper = 0;
    private int $passCall = 0;
    private string $name;
    private string $password;
    private string $mobile;
    private int $id;
    private array $access;
    private string $token;

    public static $currentUser = [];

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of mobile
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set the value of mobile
     *
     * @return  self
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return html_entity_decode($this->password);
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function hashPassword()
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
        return $this;
    }

    public function checkPassword($password, $hashed)
    {
        return password_verify($password, $hashed);
        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of passCall
     */
    public function getPassCall()
    {
        return $this->passCall;
    }

    /**
     * Set the value of passCall
     *
     * @return  self
     */
    public function setPassCall($passCall)
    {
        $this->passCall = $passCall;

        return $this;
    }

    /**
     * Get the value of isSuper
     */
    public function getIsSuper()
    {
        return $this->isSuper;
    }

    /**
     * Set the value of isSuper
     *
     * @return  self
     */
    public function setIsSuper($isSuper)
    {
        $this->isSuper = $isSuper;

        return $this;
    }

    /**
     * Get the value of access
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set the value of access
     *
     * @return  self
     */
    public function setAccess($access)
    {
        $this->access = $access;
        return $this;
    }

    public function isLogin()
    {
        $data['login'] = false;
        // بر دو جهان نمیدهم یک سر تار موی تو
        // یو هوو هاهاهااا
        $session = new Session();
        if ($session->exists('userId')) {
            $token = $session->get('token');
            $admin = new ModelsAdmin();
            $result = $admin->getByFieldName('token', $token);
            if (count($result)) {
                $data['login'] = true;
                $data['admin'] = $result[0];
            }
        }
        return $data;
    }

    public function isLoginJwt()
    {
        $data['login'] = false;
        $cookie = new Cookie();
        $jwtString = $cookie->get('jwtToken');
        if ($jwtString != null) {
            $now = new DateTimeImmutable();
            $jwt = new Jwt();
            $result = $jwt->get($jwtString);
            if ($result->iss == DOMAIN && $result->nbf <= $now->getTimestamp() && $result->exp >= $now->getTimestamp()) {
                $data['login'] = true;
                $admin = new ModelsAdmin();
                $res = $admin->getByFieldName('token', $jwtString);
                $data['admin'] = $res[0];
            }
        }
        return $data;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}
