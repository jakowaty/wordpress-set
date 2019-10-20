<?php
/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

/**
 * Renders Plugin Section in profile view (click 'Edit' on users list)
 * @param $user WP_User
 * @return void
 */

/**
 * Helper for ajax endpoints
 *
 * @param bool $success
 * @param string $msg
 * @return mixed|string|void
 */
function jakit_format_ajax_response($success = true, $msg = "Default")
{
    $resp = new \StdClass;
    $resp->success = (bool)$success;
    $resp->msg = (string)$msg;

    return \json_encode($resp);
}

/**
 * @param array $paramsUpdate
 */
function jakit_update_user(array $paramsUpdate)
{
    /** @var WP_User $currentUser */
    $currentUser = wp_get_current_user();

    if ($currentUser->ID === 0) {
        throw new \LogicException("You should be logged");
    }

    if (current_user_can('edit_user', $currentUser->ID)) {
        foreach ($paramsUpdate as $k => $v) {
            update_user_meta($currentUser->ID, $k, $v);
        }
    } else {
        throw new \LogicException("You can not do this");
    }
}

/**
 * @return bool
 */
function jakit_auth_plugin_is_configured()
{
    $apiKey2 = get_option(JAKIT_API2_0_KEY);
    $apiUrl2 = get_option(JAKIT_API2_0_URL);

    return $apiKey2 && $apiUrl2;
}

/**
 * @return bool|mixed
 */
function jakit_auth_plugin_get_apikey2()
{
    return get_option(JAKIT_API2_0_KEY);
}

/**
 * @return bool|mixed
 */
function jakit_auth_plugin_get_apiurl2()
{
    return get_option(JAKIT_API2_0_URL);
}

/**
 * @return bool|mixed
 */
function jakit_auth_plugin_debug_enabled()
{
    return get_option(JAKIT_API2_0_DEBUG);
}

/**
 * die
 */
function jakit_ap_die_if_noparams()
{
    $pluginConfigured = jakit_auth_plugin_is_configured();
    if (!$pluginConfigured) {
        wp_die(jakit_format_ajax_response(false, "Please first enter plugin parameters")) and die;
    }
}

/**
 *
 */
function jakit_user_loggedin_checkpoint()
{
    $user = wp_get_current_user();

    if ($user->ID === 0 || !current_user_can('edit_user', $user->ID)) {
        wp_die(jakit_format_ajax_response(false, "Unauthorized to do this")) and die;
    }
}

/**
 * @param string $role
 * @return bool
 */
function jakit_current_user_has_role($role)
{
    $user = wp_get_current_user();
    $userMeta = get_userdata($user->ID);
    $userRoles = $userMeta->roles;

    return in_array($role, $userRoles) || in_array(\mb_strtolower($role), $userRoles);
}

/**
 * @param string $role
 */
function jakit_user_role_checkpoint($role)
{
    if (!jakit_current_user_has_role($role)) {
        wp_die(jakit_format_ajax_response(false, "Unauthorized to do this - insufficient role")) and die;
    }
}