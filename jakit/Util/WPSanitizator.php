<?php declare(strict_types = 1);

namespace Jak\Wordpress\Util;
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

/**
 * Class WPSanitizator - serves static sanitization calback functions
 * for providing sanitized data saved in options table
 * @package Jak\Wordpress\Util
 */
class WPSanitizator
{
    /**
     * @param string $url
     * @return string
     */
    public static function sanitizeUrl(string $url): string
    {
        return $url;
    }

    /**
     * @param string $bool
     * @return string
     */
    public static function sanitizeBooleanPost(?string $bool): string
    {
        if ($bool !== '1') {
            $bool = '';
        }

        return $bool;
    }

    /**
     * @param string $str
     * @return string
     */
    public static function sanitizeStringAlnumInterpunct(string $str): string
    {
        if (!\mb_ereg_match('[a-zA-Z0-9\!\.\:\-\_]{6,64}', $str)) {
            $str = '';
        }

        return $str;
    }

    /**
     * @param string $str
     * @return string
     */
    public static function sanitizeEmailAddr(string $str): string
    {
        if (!\filter_var($str, \FILTER_VALIDATE_EMAIL)) {
            $str = '';
        }

        return $str;
    }
}