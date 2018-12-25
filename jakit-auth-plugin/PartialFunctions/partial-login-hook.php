<?php
/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

/**
 * @param $login string
 * @throws \LogicException
 *
 */
function jakit_wp_authenticate($login)
{
    //security checks
    //___________________________________________________________________________________//
    //___________________________________________________________________________________//
    //___________________________________________________________________________________//
    if (!isset($_POST['pwd'])) {
        return;
    }

    $user = get_user_by('login', $login);
    if (is_wp_error($user) || !$user) {
        return;
    }

    $password = $_POST['pwd'];
    $valid = wp_authenticate_username_password(null, $login, $password);

    //if password is invalid skip plugin work
    if (is_wp_error($valid)) {
        return;
    }

    //user cannot set option to enabled if global plugin settings
    //url and key are not set
    $enabled_locally = (int)get_user_meta($user->ID, 'jakit_user_wants_phone', true);

    //2f login must be enabled globally and locally
    if ($enabled_locally !== 1 || !jakit_auth_plugin_is_configured()) {
        return;
    }

    $verified = (int)get_user_meta($user->ID, 'jakit_user_phone_verificated', true);
    $phone = get_user_meta($user->ID, 'jakit_user_phone', true);

    //perform additional checks
    if ($verified !== 1) {
        wp_logout();
        throw new LogicException("Your account have two factor login enabled but no second factor verified.");
    }

    if (!\Jak\Wordpress\JakitAuthPlugin\Util\Validator::isValidMobilePhonePL($phone)) {
        wp_logout();
        throw new LogicException("Your phone number seems to be invalid.");
    }
    wp_logout();
    //___________________________________________________________________________________//
    //___________________________________________________________________________________//
    //___________________________________________________________________________________//



    //handle string generation
    $stringGenerator = new \Jak\Wordpress\JakitAuthPlugin\Util\StringGenerator();
    $stringGenerator->setCurrentCharactersetMode(false,false, true, true, false);
    $secret = $stringGenerator->generate(4);
    $user = get_user_by('login', $login);
    $phone = get_user_meta($user->ID, 'jakit_user_phone', true);
    $debug_enabled = jakit_auth_plugin_debug_enabled();

    if ($debug_enabled) {
        $secret = 'ABCD';
    }

    //create token
    $mprofiToken = new \Jak\Wordpress\JakitAuthPlugin\Mprofi\MprofiToken(
        $secret, //secret
        $phone, //recipient
        jakit_auth_plugin_get_apikey2(),
        Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_TOKEN_EXPIRE_SECONDS
    );

    //create client and send login secret
    $client = new \Jak\Wordpress\JakitAuthPlugin\Mprofi\MprofiClient();

    if (!$debug_enabled) {
        $response = $client->send($mprofiToken, jakit_auth_plugin_get_apiurl2());
    }

    //save token in session
    $session = \Jak\Wordpress\JakitAuthPlugin\Util\Session::create();
    $session->set(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_LOGIN_SESSION_TOKEN_INDEX, $mprofiToken);
    //save current user in session
    $userToken = new \Jak\Wordpress\JakitAuthPlugin\Util\UserToken($user);
    $session->set(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_USER_SESSION_TOKEN_INDEX, $userToken);

    wp_redirect('/');
    die;
}


/**
 * This method will grab semi-authenticated request,
 * display form for providing sms code,
 * also grab semi-authenticated  submited form with code and
 * eventually log-in user.
 *
 */
function jakit_onrequest()
{
    $session = \Jak\Wordpress\JakitAuthPlugin\Util\Session::create();
    $msg = '';

    //proceed only if mprofi login_token&user_token are set
    if (!($session->has(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_USER_SESSION_TOKEN_INDEX) &&
        $session->has(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_LOGIN_SESSION_TOKEN_INDEX))) {
        return;
    }

    //Extract Tokens from session
    $userToken = $session->get(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_USER_SESSION_TOKEN_INDEX);
    $loginToken = $session->get(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_LOGIN_SESSION_TOKEN_INDEX);

    if (
        !($userToken instanceof \Jak\Wordpress\JakitAuthPlugin\Util\UserToken) ||
        !($loginToken instanceof \Jak\Wordpress\JakitAuthPlugin\Mprofi\MprofiToken)
    ) {
        throw new \LogicException("Session data does not hold expected instances");
    }

    //Incrementation of hits count on token
    $userToken->incrementHits();
    //save into session after hits increment
    $session->set(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_USER_SESSION_TOKEN_INDEX, $userToken);

    //validation of both tokens
    //validate hits count
    if (!$userToken->isValid() || !$loginToken->isValid() || $userToken->getHits() > 3) {
        jakit_terminate_login_redirect('/');
    }

    //if we got POST request from 'jakit_print_token_form' created form
    if (isset($_POST['jakit_user_token'])) {
        $codeFromRequest = \trim($_POST['jakit_user_token']);
        $codeFromSession = $loginToken->getSecret();
        $user = get_user_by('login', $userToken->getUsername());

        if (!$user) {
            jakit_terminate_login_redirect();
            throw new \LogicException("No user to impersonate");
        }

        $phone = get_user_meta($user->ID, 'jakit_user_phone', true);

        if ($phone !== $loginToken->getRecipient()) {
            jakit_terminate_login_redirect();
            throw new \LogicException("This should not happen");
        }

        if ($codeFromRequest === $codeFromSession) {
            jakit_login_user($user);
            $session->remove(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_LOGIN_SESSION_TOKEN_INDEX);
            $session->remove(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_USER_SESSION_TOKEN_INDEX);
            wp_redirect('/');
            die;
        }

        $msg = 'Invalid code';
    }

    jakit_print_token_form($msg);

    die;
}

/**
 * @param WP_User $user
 * @return bool
 */
function jakit_login_user($user)
{
    if (($user instanceof WP_User) && !is_wp_error($user)) {
        wp_clear_auth_cookie();
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);

        return true;
    }

    return false;
}

/**
 * Clean session tokens, logout, redirect (optional)
 *
 * @param bool $url
 */
function jakit_terminate_login_redirect($url = false)
{
    $session = \Jak\Wordpress\JakitAuthPlugin\Util\Session::create();
    $session->remove(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_USER_SESSION_TOKEN_INDEX);
    $session->remove(\Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_MPROFI_LOGIN_SESSION_TOKEN_INDEX);
    wp_logout();
    wp_clear_auth_cookie();

    if ($url) {
        wp_redirect($url);
    }

    wp_die();
}

/**
 * @param string $message
 */
function jakit_print_token_form($message = '')
{
    get_header('minimal');
    echo include plugin_dir_path(__FILE__) . '../Template/' . __FUNCTION__ . '.php';
    get_footer();
}

add_action('wp_authenticate', 'jakit_wp_authenticate');
add_action('init', 'jakit_onrequest');