<?php declare(strict_types = 1);

namespace Jak\Wordpress\Util;
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

interface Query {
    public function query(string $str) : bool;
}