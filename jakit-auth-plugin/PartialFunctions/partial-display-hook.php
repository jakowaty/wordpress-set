<?php
/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

use Jak\Wordpress\JakitAuthPlugin\Util\Validator;
use Jak\Wordpress\JakitAuthPlugin\Config\Config;

/**
 * Renders Plugin Section in profile view (click 'Edit' on users list)
 * @param $user WP_User
 * @return void
 */
function jakit_auth_plugin_show_extra_profile_fields($user) {

    $jakit_user_phone = esc_attr(get_user_meta($user->ID, 'jakit_user_phone', true));
    $jakit_user_phone_verificated = (int)get_user_meta($user->ID,'jakit_user_phone_verificated', true);
    $jakit_user_wants_phone = (int)get_user_meta($user->ID,'jakit_user_wants_phone', true);
    $jakit_auth_plugin_debug_mode = (int)get_user_meta($user->ID,Config::JAKIT_AUTH_PLUGIN_DEBUG_MODE, true);
    $jakit_auth_plugin_api_url = get_user_meta($user->ID,Config::JAKIT_MPROFI_API_ADR, true);
    $jakit_auth_plugin_api_key = get_user_meta($user->ID,Config::JAKIT_MPROFI_API_AUTH_TOKEN, true);


    $jakit_auth_plugin_debug_mode_checked = ((int)$jakit_auth_plugin_debug_mode) === 0 ? '' : 'checked="checked"';
    $jakit_user_wants_phone_checked = ((int)$jakit_user_wants_phone) === 0 ? '' : 'checked="checked"';
    $jakit_user_phone_verificated_checked =
        ($jakit_user_phone_verificated === null || $jakit_user_phone_verificated == 0) ? 'NOT VERIFIED' : 'VERIFIED';

    $js_path = Config::JAKIT_AUTH_DIR_NAME . '/js/' . __FUNCTION__ . '.js';
    $js2_path = Config::JAKIT_AUTH_DIR_NAME . '/js/jakitwplib.js';

    $js_url = plugins_url($js_path);
    $jslib_url = plugins_url($js2_path);

    echo require plugin_dir_path(__FILE__) . '../Template/' . __FUNCTION__ . '.php';
}

/**
 * Update user data from profile view
 * @param $user_id
 */
function update_extra_profile_fields($user_id)
{
    if (current_user_can('edit_user', $user_id)) {

        $validPhone = (bool)Validator::sanitizeBoolTinyintFlag(
            get_user_meta($user_id, Config::JAKIT_USER_PHONE_VERIFIED, true)
        );

        if (
            isset($_POST['jakit_user_wants_phone']) &&
            jakit_auth_plugin_is_configured() &&
            $validPhone
        ) {
            $enabled = Validator::sanitizeBoolTinyintFlag($_POST['jakit_user_wants_phone']);
            update_user_meta($user_id, 'jakit_user_wants_phone', $enabled);
        }
    }

}

/**
 * Display user profile errors concerning plugin fields
 * @param WP_Error $errors
 * @param bool $update
 * @param WP_User $user
 */
function jakit_user_profile_update_errors($errors, $update, $user)
{
    if (!isset($_POST['jakit_user_wants_phone'])) {
        return;
    }

    $enabledFromRequest = Validator::sanitizeBoolTinyintFlag($_POST['jakit_user_wants_phone']);

    if ($enabledFromRequest === 1) {
        $phone = get_user_meta($user->ID,'jakit_user_phone', true);
        $validPhone = (bool)Validator::sanitizeBoolTinyintFlag(
            get_user_meta($user->ID, 'jakit_user_phone_verificated', true)
        );

        if (!$validPhone) {
            $errors->add(
                Config::JAKIT_USER_PHONE_VERIFIED,
                '<strong>ERROR</strong>: Phone number not verified, cant enable Auth Plugin'
            );
        }

        if (!Validator::isValidMobilePhonePL($phone)) {
            $errors->add(
                Config::JAKIT_USER_PHONE,
                '<strong>ERROR</strong>: Phone number not valid, cant enable Auth Plugin'
            );
        }

        if (!jakit_auth_plugin_is_configured()) {
            $errors->add(
                Config::JAKIT_MPROFI_API_ADR,
                '<strong>ERROR</strong>: You can not enable two step login without api url or key set up.'
            );
        }
    }
}

//add hooks
add_action( 'show_user_profile', 'jakit_auth_plugin_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'jakit_auth_plugin_show_extra_profile_fields' );
add_action('personal_options_update', 'update_extra_profile_fields');
add_action('edit_user_profile_update', 'update_extra_profile_fields');
add_action( 'user_profile_update_errors', 'jakit_user_profile_update_errors', 10, 3 );