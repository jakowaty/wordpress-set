<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

namespace Jak\Wordpress\JakitAuthPlugin\Util;

class StringGenerator
{
    private const CHARACTERSET_ALPHALOWER = 'abcdefghijklmnopqrstuvwxyz';
    private const CHARACTERSET_ALPHAUPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const CHARACTERSET_NUMERIC = '0123456789';
    private const CHARACTERSET_INTERPUNCT = '.,?!:;';
    private const CHARACTERSET_EMPTY = '';

    private $currentCharacterset = false;

    /**
     * StringGenerator constructor.
     * @param bool $mixed
     * @param bool $alphaLower
     * @param bool $alphaUpper
     * @param bool $numeric
     * @param bool $interpunct
     */
    public function __construct(
        bool $mixed = true,
        bool $alphaLower = false,
        bool $alphaUpper = false,
        bool $numeric = false,
        bool $interpunct = false
    ) {
        $this->setCurrentCharactersetMode($mixed, $alphaLower, $alphaUpper, $numeric, $interpunct);
    }

    /**
     * @param int $length
     * @return string
     */
    public function generate(int $length): string
    {
        if (!$this->currentCharacterset || empty($this->currentCharacterset)) {
            throw new \LogicException("Characterset is not set or empty");
        }

        $str = '';
        $charactersetLastIndex = \mb_strlen($this->currentCharacterset) - 1;

        while($length > 0) {
            $randIndex = \mt_rand(0, $charactersetLastIndex);
            $char = $this->currentCharacterset[$randIndex];
            $str .= $char;
            $length--;
        }

        return $str;
    }

    /**
     * @param bool $mixed
     * @param bool $alphaLower
     * @param bool $alphaUpper
     * @param bool $numeric
     * @param bool $interpunct
     * @return StringGenerator
     */
    public function setCurrentCharactersetMode(
        bool $mixed,
        bool $alphaLower,
        bool $alphaUpper,
        bool $numeric,
        bool $interpunct
    ): self {

        if ($mixed || (!$mixed && !$alphaLower && !$alphaUpper && !$numeric && !$interpunct)) {
            $alphaUpper = $alphaLower = $numeric = $interpunct = true;
        }

        $this->currentCharacterset = self::CHARACTERSET_EMPTY;

        if ($alphaUpper) {
            $this->currentCharacterset .= self::CHARACTERSET_ALPHAUPPER;
        }

        if ($alphaLower) {
            $this->currentCharacterset .= self::CHARACTERSET_ALPHALOWER;
        }

        if ($numeric) {
            $this->currentCharacterset .= self::CHARACTERSET_NUMERIC;
        }

        if ($interpunct) {
            $this->currentCharacterset .= self::CHARACTERSET_INTERPUNCT;
        }

        return $this;
    }

    /**
     * @param string $characterset
     * @return StringGenerator
     */
    public function overrideCurrentCharacterset(string $characterset): self
    {
        $this->clearCurrentCharacterset()->currentCharacterset = $characterset;
        return $this;
    }

    /**
     * @param string $characterset
     * @return StringGenerator
     */
    public function addToCurrentCharacterset(string $characterset): self
    {
        $this->currentCharacterset .= $characterset;
        return $this;
    }

    /**
     * @return StringGenerator
     */
    public function clearCurrentCharacterset(): self
    {
        $this->currentCharacterset = false;
        return $this;
    }
}