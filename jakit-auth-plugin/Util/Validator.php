<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

namespace Jak\Wordpress\JakitAuthPlugin\Util;

class Validator
{
    /**
     * Check validity of given mobile phone number in PL
     * @param string $phone
     * @return bool
     */
    public static function isValidMobilePhonePL(string $phone): bool
    {
        return \mb_ereg_match('(\+48|\(\+48\))?[5-9]{1}[0-9]{8}', $phone);
    }

    /**
     * @param $postParam
     * @return int
     */
    public static function sanitizeBoolTinyintFlag($postParam): int
    {
        if ($postParam === 1 || $postParam === "1") {
            return 1;
        }

        return 0;
    }
}