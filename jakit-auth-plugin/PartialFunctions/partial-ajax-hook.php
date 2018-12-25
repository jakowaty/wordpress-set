<?php
/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

/**
 * Tries to retrieve Request and Session Token secret value.
 * Validates both values. If everything is OK - UPDATES current user phone and verificated column.
 * Unsets session MprofiToken.
 */
function jakit_send_token_action()
{
    // params && login check
    jakit_ap_die_if_noparams();
    jakit_user_loggedin_checkpoint();

    $session = \Jak\Wordpress\JakitAuthPlugin\Util\Session::create();
    /** @var \Jak\Wordpress\JakitAuthPlugin\Mprofi\MprofiToken|false $storedToken */
    $storedToken =
        $session->has(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_VERIFICATION_SESSION_TOKEN_INDEX) ?
            $session->get(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_VERIFICATION_SESSION_TOKEN_INDEX) :
            false;

    $requestTokenString = isset($_POST['token']) ? $_POST['token'] : false;

    //clean session
    $session->remove(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_VERIFICATION_SESSION_TOKEN_INDEX);

    //check session token - class instance and defined
    if (!$storedToken) {
        wp_die(jakit_format_ajax_response(false, "Session token not defined"));
        die;
    }


    //check session token - has proper class
    if (!($storedToken instanceof \Jak\Wordpress\JakitAuthPlugin\Mprofi\MprofiToken)) {
        wp_die(jakit_format_ajax_response(false, "Session token invalid class")) or die;
    }

    //check session token - did it not expired
    if (!$storedToken->isValid()) {
        wp_die(jakit_format_ajax_response(false, "Token expired or bad instance")) or die;
    }

    //check string format of token
    if (!\is_string($storedToken->getSecret())) {
        wp_die(jakit_format_ajax_response(false, "Token session invalid format")) or die;
    }

    if (!\Jak\Wordpress\JakitAuthPlugin\Util\Validator::isValidMobilePhonePL($storedToken->getRecipient())) {
        wp_die(jakit_format_ajax_response(false, "Token holds invalid phone")) or die;
    }

    if ($storedToken->getSecret() !== $requestTokenString) {
        wp_die(jakit_format_ajax_response(false, "Invalid token")) or die;
    }

    if ($storedToken->getSecret() === $requestTokenString) {
        //update
        jakit_update_user([
            'jakit_user_phone' => $storedToken->getRecipient(),
            'jakit_user_phone_verificated' => 1
        ]);

        wp_die(jakit_format_ajax_response(true, "Token verified")) or die;
    }

    throw new \LogicException("This should not happen");
}

/**
 * Receives phone number from first input after
 * the one holding current phone number and is disabled;
 *
 * @return mixed|string|void
 */
function jakit_send_phone_action()
{
    $phone = $_POST['phone'] ?? false;

    // params && login check
    jakit_ap_die_if_noparams();
    jakit_user_loggedin_checkpoint();

    if (!$phone) {
        wp_die(jakit_format_ajax_response(false, "Phone is supposed to be set")) and die;
    }

    if (!\Jak\Wordpress\JakitAuthPlugin\Util\Validator::isValidMobilePhonePL($phone)) {
        wp_die(jakit_format_ajax_response(false, "Invalid phone format")) and die;
    }

    //handle string generation
    $stringGenerator = new \Jak\Wordpress\JakitAuthPlugin\Util\StringGenerator();
    $stringGenerator->setCurrentCharactersetMode(false,false, true, true, false);
    $secret = $stringGenerator->generate(4);

    //create token
    $mprofiToken = new \Jak\Wordpress\JakitAuthPlugin\Mprofi\MprofiToken(
        $secret, //secret
        $phone, //recipient
        jakit_auth_plugin_get_apikey2(),
        Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_TOKEN_EXPIRE_SECONDS
    );

    //create client and send login secret
    $client = new \Jak\Wordpress\JakitAuthPlugin\Mprofi\MprofiClient();
    $addr = jakit_auth_plugin_get_apiurl2();
    $response = $client->send($mprofiToken, $addr);


    if ($response->text === false) {
        wp_die(jakit_format_ajax_response(false, "Could not send request"));
    }

    //we save token into session if status is 200 and we have response
    //session should be already initialized by plugin
    if ($response->httpStatus === 200) {
        $session = \Jak\Wordpress\JakitAuthPlugin\Util\Session::create();
        $session->set(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_VERIFICATION_SESSION_TOKEN_INDEX, $mprofiToken);
        wp_die(jakit_format_ajax_response(
            true,
            'Enter verification token and click "Send" button next to the input'
        )) and die;
    }

    if ($response->httpStatus !== 200) {
        wp_die(jakit_format_ajax_response(false, $response->text)) and die;
    }
}

/**
 * Just user side reset action - resets user settings, but no site settings
 */
function jakit_reset_auth_plugin_action()
{
    $user = wp_get_current_user();
    $do = isset($_POST['do']) && $_POST['do'] === 'reset';

    if (!$do) {
        wp_die(jakit_format_ajax_response(false, "Invalid request params"));
    }

    //this should be safe - current user
    delete_user_meta($user->ID, 'jakit_user_wants_phone');
    delete_user_meta($user->ID, 'jakit_user_phone_verificated');
    delete_user_meta($user->ID, 'jakit_user_phone');

    wp_die(jakit_format_ajax_response(true, "Cleaned successfully - please refresh profile page"));
}

/**
 * Jakit auth plugin reset general settings - AVAILABLE FOR USERS WITH 'Administrator'
 */
function jakit_reset_global_auth_plugin_action()
{
    jakit_user_loggedin_checkpoint();
    jakit_user_role_checkpoint('Administrator');

    $do = isset($_POST['do']) && $_POST['do'] === 'reset';

    if (!$do) {
        wp_die(jakit_format_ajax_response(false, "Invalid request params"));
    }

    delete_option(JAKIT_API2_0_KEY);
    delete_option(JAKIT_API2_0_URL);
    delete_option(JAKIT_API2_0_DEBUG);

    wp_die(jakit_format_ajax_response(true, "Cleaned successfully - please refresh settings page"));
}


add_action('wp_ajax_send_token', 'jakit_send_token_action');
add_action('wp_ajax_send_phone', 'jakit_send_phone_action');
add_action('wp_ajax_reset_auth_plugin', 'jakit_reset_auth_plugin_action');
add_action('wp_ajax_reset_global_auth_plugin', 'jakit_reset_global_auth_plugin_action');