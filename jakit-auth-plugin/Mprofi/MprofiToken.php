<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

namespace Jak\Wordpress\JakitAuthPlugin\Mprofi;

class MprofiToken implements \Serializable
{
    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $recipient;

    /**
     * @var int
     */
    private $expiresAt;

    /**
     * @var int
     */
    private $createdAt;

    /**
     * @var string
     */
    private $auth;

    /**
     * MprofiToken constructor.
     * @param string $secret
     * @param string $recipient
     * @param string $auth
     * @param int $expireSeconds
     */
    public function __construct(string $secret, string $recipient, string $auth, int $expireSeconds = 300)
    {
        $this->secret = $secret;
        $this->recipient = $recipient;
        $this->auth = $auth;
        $this->createdAt = \time();
        $this->expiresAt = $this->createdAt + \abs($expireSeconds);
    }

    /**
     * @return string
     */
    public function getAuth(): string
    {
        return $this->auth;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return int
     */
    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !(\time() >= $this->expiresAt);
    }

    /**
     * @return string
     */
    public function getMprofiFormat(): string
    {
        $data = new \StdClass;
        $data->apikey = $this->auth;
        $data->recipient = $this->recipient;
        $data->message = $this->secret;

        return (string)\json_encode($data);
    }

    /**
     * @return mixed|string|void
     */
    public function serialize()
    {
        return \json_encode($this->_getData());
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = \json_decode($serialized);
        $this->secret = $data->secret;
        $this->recipient = $data->recipient;
        $this->createdAt = $data->createdAt;
        $this->expiresAt = $data->expiresAt;
        $this->auth = $data->auth;
    }

    /**
     * @return \StdClass
     */
    private function _getData(): \StdClass
    {
        $data = new \StdClass;
        $data->secret = $this->secret;
        $data->recipient = $this->recipient;
        $data->createdAt = $this->createdAt;
        $data->expiresAt = $this->expiresAt;
        $data->auth = $this->auth;

        return $data;
    }
}