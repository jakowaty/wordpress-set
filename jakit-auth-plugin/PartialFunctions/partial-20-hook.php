<?php
//const JAKIT_API2_0_

const JAKIT_API2_0_SECTION = 'jakit_ap_section';
const JAKIT_API2_0_URL = 'jakit_ap_api_url';
const JAKIT_API2_0_KEY = 'jakit_ap_api_key';
const JAKIT_API2_0_DEBUG = 'jakit_ap_debug_mode';

/**
 * main setting function:
 * - registers settings
 * - add html callbacks
 * - called on admin init
 */
function jakit_auth_plugin_add_settings_init()
{
    /**
     * define section for settings
     */
    add_settings_section(
        JAKIT_API2_0_SECTION,
        '',
        'jakit_ap_section_setting_callback',
        'general'
    );

    /**
     * url setting
     */
    add_settings_field(
        JAKIT_API2_0_URL,
        'Api url',
        'jakit_ap_url_setting_callback',
        'general',
        JAKIT_API2_0_SECTION
    );
    register_setting('general', JAKIT_API2_0_URL, [
        'sanitize_callback' => [\Jak\Wordpress\Util\WPSanitizator::class, 'sanitizeUrl']
    ]);

    /**
     * mprofi api key setting
     */
    add_settings_field(
        JAKIT_API2_0_KEY,
        'Api key',
        'jakit_ap_key_setting_callback',
        'general',
        JAKIT_API2_0_SECTION
    );
    register_setting('general', JAKIT_API2_0_KEY); //@TODO sanitize??

    /**
     * debug mode setting
     */
    add_settings_field(
        JAKIT_API2_0_DEBUG,
        'Debug Mode',
        'jakit_ap_debug_mode_callback',
        'general',
        JAKIT_API2_0_SECTION
    );
    register_setting('general', JAKIT_API2_0_DEBUG, [
        'sanitize_callback' => [\Jak\Wordpress\Util\WPSanitizator::class, 'sanitizeBooleanPost']
    ]);
}


/**
 * callback to call at start - print template etc
 */
function jakit_ap_section_setting_callback() {
    $jslib_path = \Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_AUTH_DIR_NAME . '/js/jakitwplib.js';
    $js_path = \Jak\Wordpress\JakitAuthPlugin\Config\Config::JAKIT_AUTH_DIR_NAME . '/js/' . __FUNCTION__ . '.js';
    $js_url = plugins_url($js_path);
    $jslib_url = plugins_url($jslib_path);
    echo include plugin_dir_path(__FILE__) . '../Template/' . __FUNCTION__ . '.php';
}

/**
 * mprofi api address url callback
 */
function jakit_ap_url_setting_callback(){

    $JAKIT_API2_0_URL = JAKIT_API2_0_URL;
    $url_val = get_option(JAKIT_API2_0_URL);
    echo <<<HTML
        <input 
        name="$JAKIT_API2_0_URL" 
        id="$JAKIT_API2_0_URL" type="text" value="$url_val" class="code"/>
        Url to API.
HTML;
}

/**
 * mprofi api key callback
 */
function jakit_ap_key_setting_callback(){
    $JAKIT_API2_0_KEY = JAKIT_API2_0_KEY;
    $key_val = get_option(JAKIT_API2_0_KEY);
    echo <<<HTML
        <input 
        name="$JAKIT_API2_0_KEY" 
        id="$JAKIT_API2_0_KEY" type="text" value="$key_val" class="code"/>
        Key to API.
HTML;
}

/**
 * debug mode callback
 */
function jakit_ap_debug_mode_callback(){
    $JAKIT_API2_0_DEBUG = JAKIT_API2_0_DEBUG;
    $debug_enabled = get_option(JAKIT_API2_0_DEBUG);
    $checked = checked(1, $debug_enabled, false);
    echo <<<HTML
    <input name="$JAKIT_API2_0_DEBUG" id="$JAKIT_API2_0_DEBUG" type="checkbox" value="1" $checked class="code" />
HTML;
}


add_action('admin_init', 'jakit_auth_plugin_add_settings_init');