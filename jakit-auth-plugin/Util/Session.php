<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

namespace Jak\Wordpress\JakitAuthPlugin\Util;

/**
 * Class Session
 * @package Jak\Wordpress\JakitAuthPlugin\Util
 */
class Session
{
    /**
     * @param null|string $id
     * @return Session
     */
    public static function create(?string $id = null): self
    {
        if (empty(\session_id())) {

            if ($id) {
                \session_id($id);
            }

            \session_start();
        }

        return new self();
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return \array_key_exists($key, $_SESSION);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }
    }

    /**
     * @param $key
     * @param $value
     * @return Session
     */
    public function set($key, $value): self
    {
        if (!$this->isKeyTypeAllowed($key)) {
            throw new \LogicException('Not allowed session key type');
        }

        $_SESSION[$key] = $value;
        return $this;
    }

    /**
     * @param $key
     * @return Session
     */
    public function remove($key): self
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    private function isKeyTypeAllowed($key): bool
    {
        if (\is_string($key) || \is_long($key) || \is_float($key)) {
            return true;
        }

        return false;
    }
}