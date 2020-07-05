<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

/**
 * @return array|bool
 */
function jakit_contactpage_settings_valid()
{
    $contactAddr = get_option('jakit_contactpage_addr');
    $reCaptchaSitekeyPublic = get_option('jakit_captcha_sitekey');
    $reCaptchaSecret = get_option('jakit_captcha_secret');
    //it has default value
    $reCaptchaApiUrl = get_option('jakit_captcha_addr');

    if (
        !$contactAddr || !filter_var($contactAddr, FILTER_VALIDATE_EMAIL) ||
        !$reCaptchaSitekeyPublic || $reCaptchaSitekeyPublic === '' ||
        !$reCaptchaSecret || $reCaptchaSecret === '' || !$reCaptchaApiUrl ||
        !filter_var($reCaptchaApiUrl, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED)
    ) {
        return false;
    }

    return [
        'contact_mail' => $contactAddr,
        'sitekey' => $reCaptchaSitekeyPublic,
        'secret' => $reCaptchaSecret,
        'api_url' => $reCaptchaApiUrl
    ];
}

/**
 * @param $secret
 * @param $apiUrl
 * @param $contactAddr
 * @return array|null
 */
function jakit_contactpage_post_action($secret, $apiUrl, $contactAddr)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
        return  null;
    }

    $result = function ($success, $txt) {
        return [
            'success' => $success,
            'txt' => $txt
        ];
    };

    if (!isset($_POST['text-msg'], $_POST['g-recaptcha-response'])) {
        return $result(false, 'Invalid request');
    }

    $reCaptchaQuery = new \Jak\Wordpress\Util\ReCaptcha\GoogleReCaptchaVerifyQuery($secret, $apiUrl);

    if (!$reCaptchaQuery->query($_POST['g-recaptcha-response'])) {
        return $result(false, "Captcha failed {$reCaptchaQuery->getResult()}");
    }

    $subject = "Contact request from " . $_SERVER['SERVER_ADDR'];
    $mailQuery = new \Jak\Wordpress\Util\Mail\SmtpSimpleMailQuery($subject, (string)$_POST['text-msg']);

    if (!$mailQuery->query($contactAddr)) {
        return $result(
            false,
            "Failed to send message: " .
            isset(\Jak\Wordpress\Util\Mail\SmtpSimpleMailQuery::ERROR_CODES[$mailQuery->errorCode]) ?
                \Jak\Wordpress\Util\Mail\SmtpSimpleMailQuery::ERROR_CODES[$mailQuery->errorCode] :
                'unknown_error'
        );
    }

    return $result(true, "Message sent");
}