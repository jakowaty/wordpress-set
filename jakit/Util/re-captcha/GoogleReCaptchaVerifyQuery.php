<?php declare(strict_types = 1);

namespace Jak\Wordpress\Util\ReCaptcha;

/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

use Jak\Wordpress\Util\Query;

/**
 * This is not a http client in means that it doesn't provide
 * api for setting headers, request params etc.
 * It serves as simple api to query Google servers for recaptcha challenge score
 * for given token.
 *
 * Class GoogleReCaptchaVerifyQuery
 * @package Jak\Wordpress\Util\ReCaptcha
 */
class GoogleReCaptchaVerifyQuery implements Query
{
    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var null | string | bool
     */
    private $result = null;

    /**
     * @var bool
     */
    private $error = false;

    /**
     * GoogleReCaptchaVerifyQuery constructor.
     * @param string $secret
     * @param string $url
     */
    public function __construct(string $secret, string $url = 'https://www.google.com/recaptcha/api/siteverify')
    {
        $this->apiSecret = $secret;
        $this->apiUrl = $url;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function query(string $token): bool
    {
        //prepare payload
        $payload = \http_build_query([
            'secret' => $this->apiSecret,
            'response' => $token
        ]);

        //prepare context
        $context = \stream_context_create([
            'http' => [
                'method' => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'max_redirects' => '0',
                'ignore_errors' => '1',
                'content' => $payload
            ]
        ]);

        //send request
        $googleVerifyResponse = \file_get_contents($this->apiUrl, false, $context);

        //connection problems/404/500?
        if (!$googleVerifyResponse) {
            $this->error = true;
            $this->result = 'Connection or Availability problems';
            return false;
        }

        $googleVerifyResponseObject = \json_decode($googleVerifyResponse);

        //decode failed or response of not expected type
        if (!\is_object($googleVerifyResponseObject)) {
            $this->error = true;
            $this->result = 'Response problems - expecting object, given: ' . \gettype($googleVerifyResponseObject);
            return false;
        }

        //we have success
        if (isset($googleVerifyResponseObject->success) && $googleVerifyResponseObject->success === true) {
            $this->error = false;
            $this->result = 'Operation succeed';
            return true;
        }

        //now we have an error for sure
        $this->error = true;
        //hack because of Google sending response with error field called "error-codes"
        //have to go this way if want to use object api
        $googleVerifyResponseObjectErrorField = 'error-codes';
        $this->result = \implode(', ', $googleVerifyResponseObject->$googleVerifyResponseObjectErrorField);

        return false;
    }

    /**
     * @return bool|null|string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return bool
     */
    public function reset(): bool
    {
        $this->result = null;
        $this->error = false;

        return true;
    }
}