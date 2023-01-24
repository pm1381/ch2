<?php
namespace App\Entities;

use App\Classes\Cookie;
use App\Classes\Jwt;
use App\Classes\Session;
use App\Models\UserModel;
use DateTimeImmutable;

class User {
    private string $email = '';
    public string $name = '';
    private string $password = '';
    private string $token = '';
    private int $admin = 1;
    private int $id;
    private string $remeberToken = '';
    
    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return htmlentities($this->name);
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
     * Get the value of email
     */ 
    public function getEmail()
    {
        return  htmlentities($this->email);
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return htmlentities($this->password);
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
    }

    public function checkPassword($password, $hashed)
    {
        return password_verify($password, $hashed);
    }

    public function isLogin()
    {
        $data['login'] = false;
        $session = new Session();
        if ($session->exists('userId')) {
            $token = $session->get('userId');
            $userModel = new UserModel();
            $result = $userModel->getByFieldName('token', $token);
            if (count($result)) {
                $data['login'] = true;
                $data['user'] = $result[0];
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
            
            if ($result->iss == DOMAIN && $result->nbf < $now->getTimestamp() && $result->exp > $now->getTimestamp()) {
                $data['login'] = true;
                $data['user'] = $result->data;
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

    /**
     * Get the value of admin
     */ 
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     *
     * @return  self
     */ 
    public function setAdmin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

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
     * Get the value of remeberToken
     */ 
    public function getRemeberToken()
    {
        return $this->remeberToken;
    }

    /**
     * Set the value of remeberToken
     *
     * @return  self
     */ 
    public function setRemeberToken($remeberToken)
    {
        $this->remeberToken = $remeberToken;
        return $this;
    }
}
