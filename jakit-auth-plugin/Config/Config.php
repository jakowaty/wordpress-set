<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

namespace Jak\Wordpress\JakitAuthPlugin\Config;

class Config
{
    const JAKIT_AUTH_DIR_NAME = 'jakit-auth-plugin';
    const JAKIT_MPROFI_TOKEN_EXPIRE_SECONDS = 720;
    const JAKIT_MPROFI_VERIFICATION_SESSION_TOKEN_INDEX = 'jakit_verify_phone_token_session_index';
    const JAKIT_MPROFI_LOGIN_SESSION_TOKEN_INDEX = 'jakit_login_phone_token_session_index';
    const JAKIT_MPROFI_USER_SESSION_TOKEN_INDEX = 'jakit_user_token_session_index';

    /**
     * Unified names used in functions, js, forms to setup or
     * retrieve or set them in user meta.
     */
    const JAKIT_USER_ENABLED_PLUGIN = 'jakit_user_wants_phone';
    const JAKIT_USER_PHONE = 'jakit_user_phone';
    const JAKIT_USER_PHONE_VERIFIED = 'jakit_user_phone_verificated';
    const JAKIT_MPROFI_API_ADR = 'jakit_auth_plugin_mprofi_addr';
    const JAKIT_MPROFI_API_AUTH_TOKEN = 'jakit_auth_plugin_mprofi_auth';
    const JAKIT_AUTH_PLUGIN_DEBUG_MODE = 'jakit_auth_plugin_debug_mode';
}