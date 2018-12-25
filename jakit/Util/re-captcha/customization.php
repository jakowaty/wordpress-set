<?php

/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

/**
 * Add section and settings to customize view for search settings
 *
 * @param WP_Customize_Manager $wp_customize
 */
function jakit_customize_contactpage_captcha_register(WP_Customize_Manager $wp_customize)
{
    //add menu part
    $wp_customize->add_section(
        'jakit_contactpage_captcha_section',
        array(
            'title'       => 'Contact Captcha Settings',
            'priority'    => 33,
        )
    );

    //address setting and control
    $wp_customize->add_setting(
        'jakit_captcha_addr',
        array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => [\Jak\Wordpress\Util\WPSanitizator::class, 'sanitizeUrl']
        )
    );

    $wp_customize->add_control(
        'jakit_captcha_addr_control',
        array(
            'default'    => 'https://www.google.com/recaptcha/api/siteverify',
            'label'      => 'Captcha API url',
            'section'    => 'jakit_contactpage_captcha_section',
            'settings'   => 'jakit_captcha_addr',
        )
    );

    //public sitekey
    $wp_customize->add_setting(
        'jakit_captcha_sitekey',
        array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => [\Jak\Wordpress\Util\WPSanitizator::class, 'sanitizeStringAlnumInterpunct']
        )
    );

    $wp_customize->add_control(
        'jakit_captcha_sitekey_control',
        array(
            'label'      => 'Captcha API sitekey',
            'section'    => 'jakit_contactpage_captcha_section',
            'settings'   => 'jakit_captcha_sitekey',
        )
    );

    //captcha api secret
    $wp_customize->add_setting(
        'jakit_captcha_secret',
        array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => [\Jak\Wordpress\Util\WPSanitizator::class, 'sanitizeStringAlnumInterpunct']
        )
    );

    $wp_customize->add_control(
        'jakit_captcha_secret_control',
        array(
            'label'      => 'Captcha API secret',
            'section'    => 'jakit_contactpage_captcha_section',
            'settings'   => 'jakit_captcha_secret',
        )
    );
}
add_action('customize_register', 'jakit_customize_contactpage_captcha_register');