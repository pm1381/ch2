<?php 

namespace App\Classes;

use DateTimeImmutable;
use Firebase\JWT\JWT as FIREBASEJWT;
use Firebase\JWT\Key;

class Jwt
{
    private DateTimeImmutable $time;
    private string $uniqueToken;
    private string $issurer = DOMAIN;
    private $secretKey = JWT_SECRET_KEY;
    private $signAlgorithm = JWT_ALGORITHM;
    //you can also add many more payloads for your system

    public function __construct()
    {
        $this->time = new DateTimeImmutable();
        $this->setUniqueToken(base64_encode(random_bytes(16)));
    }

    /**
     * Get the value of signAlgorithm
     */ 
    public function getSignAlgorithm()
    {
        return $this->signAlgorithm;
    }

    /**
     * Set the value of signAlgorithm
     *
     * @return  self
     */ 
    public function setSignAlgorithm($signAlgorithm)
    {
        $this->signAlgorithm = $signAlgorithm;
        return $this;
    }

    /**
     * Get the value of secretKey
     */ 
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Set the value of secretKey
     *
     * @return  self
     */ 
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
        return $this;
    }

    /**
     * Get the value of issurer
     */ 
    public function getIssurer()
    {
        return $this->issurer;
    }

    /**
     * Set the value of issurer
     *
     * @return  self
     */ 
    public function setIssurer($issurer)
    {
        $this->issurer = $issurer;
        return $this;
    }

    /**
     * Get the value of uniqueToken
     */ 
    public function getUniqueToken()
    {
        return $this->uniqueToken;
    }

    /**
     * Set the value of uniqueToken
     *
     * @return  self
     */ 
    public function setUniqueToken($uniqueToken)
    {
        $this->uniqueToken = $uniqueToken;
        return $this;
    }

    public function create($data)
    {
        $payload = [
            'iat' => $this->time->getTimestamp(),
            'jti' => $this->uniqueToken,
            'iss' => $this->issurer,
            'nbf' => $this->time->getTimestamp(),
            'exp' => $this->time->modify(EXPIRE_DATE)->getTimestamp(),
            'data' => $data
        ];

        return FIREBASEJWT::encode($payload, $this->secretKey, $this->signAlgorithm);
    }

    public function get($string)
    {
        return FIREBASEJWT::decode($string, new Key($this->secretKey, $this->signAlgorithm));
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }
}