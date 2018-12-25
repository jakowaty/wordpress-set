<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

namespace Jak\Wordpress\JakitAuthPlugin\Mprofi;

class MprofiClient
{
    /**
     * @param bool $post
     * @return resource
     */
    private function getCurl(bool $post = true)
    {
        $curl = \curl_init();
        \curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($post) {
            \curl_setopt($curl, \CURLOPT_POST, true);
        }

        return $curl;
    }

    /**
     * @param resource $curl
     * @return string
     */
    private function handleError($curl): string
    {
        return \curl_error($curl);
    }

    /**
     * @param MprofiToken $mprofiToken
     * @param string $apiurl
     * @return \StdClass
     */
    public function send(MprofiToken $mprofiToken, string $apiurl): \StdClass
    {
        $curl = $this->getCurl();
        $payload = $mprofiToken->getMprofiFormat();
        $r = new \StdClass;

        \curl_setopt($curl, \CURLOPT_POSTFIELDS, $payload);
        \curl_setopt($curl, \CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        \curl_setopt($curl, \CURLOPT_URL, $apiurl);

        $response = \curl_exec($curl);

        if (!$response) {
            $r->error = $this->handleError($curl);
        }

        $r->httpStatus = \curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $r->text = $response;

        \curl_close($curl);

        return $r;
    }

}