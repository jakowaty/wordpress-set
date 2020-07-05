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
function jakit_customize_contactpage_addr_register(WP_Customize_Manager $wp_customize)
{
    //add menu part
    $wp_customize->add_section(
        'jakit_contactpage_section',
        array(
            'title'       => 'Contact Settings',
            'priority'    => 33,
        )
    );

    //address setting and control
    $wp_customize->add_setting(
        'jakit_contactpage_addr',
        array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => [\Jak\Wordpress\Util\WPSanitizator::class, 'sanitizeEmailAddr']
        )
    );

    $wp_customize->add_control(
        'jakit_contactpage_addr_control',
        array(
            'label'      => 'Contact Address',
            'section'    => 'jakit_contactpage_section',
            'settings'   => 'jakit_contactpage_addr',
        )
    );
}
add_action('customize_register', 'jakit_customize_contactpage_addr_register');