<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

namespace Jak\Wordpress\JakitAuthPlugin\Util;

/**
 * Class UserToken
 * @package Jak\Wordpress\JakitAuthPlugin\Util
 */
class UserToken implements \Serializable
{
    /**
     * @var string
     */
    private $username;
    /**
     * @var int
     */
    private $userid;
    /**
     * @var int
     */
    private $hits;
    /**
     * @var int
     */
    private $createdAt;
    /**
     * @var int
     */
    private $expiresAt;

    /**
     * UserToken constructor.
     * @param \WP_User $user
     * @param int $expireSeconds
     */
    public function __construct(\WP_User $user, int $expireSeconds = 300)
    {
        $this->username = $user->user_login;
        $this->userid = $user->ID;
        $this->hits = 0;
        $this->createdAt = \time();
        $this->expiresAt = $this->createdAt + \abs($expireSeconds);
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->expiresAt >= \time();
    }

    /**
     * @return UserToken
     */
    public function incrementHits(): self
    {
        $this->hits++;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function serialize()
    {
        $obj = new \StdClass();
        $obj->username = $this->username;
        $obj->userid = $this->userid;
        $obj->hits = $this->hits;
        $obj->createdAt = $this->createdAt;
        $obj->expiresAt = $this->expiresAt;

        return \json_encode($obj);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $unserialized = \json_decode($serialized);

        if (\is_object($unserialized)) {
            $this->username = $unserialized->username;
            $this->userid = $unserialized->userid;
            $this->hits = $unserialized->hits;
            $this->createdAt = $unserialized->createdAt;
            $this->expiresAt = $unserialized->expiresAt;
        }
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getUserid(): int
    {
        return $this->userid;
    }

    /**
     * @return int
     */
    public function getHits(): int
    {
        return $this->hits;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }
}