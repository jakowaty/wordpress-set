<?php
/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

/**
 * Fired at plugin activation time,
 * Alter user table for plugin code
 * In fact its fired at installation time
 *
 * @return bool
 */
function jakit_auth_plugin_activation_hook ()
{
    /** @var $wpdb wpdb */
    global $wpdb;
//    $sql_alter1 = <<<SQL1
//    ALTER TABLE {$wpdb->base_prefix}users MODIFY COLUMN user_registered DATETIME DEFAULT  NULL;
//SQL1;

//    $sql_alter2 = <<<SQL2
//    ALTER TABLE {$wpdb->base_prefix}users ADD COLUMN jakit_user_phone VARCHAR(13) DEFAULT  NULL;
//SQL2;
//
//    $sql_alter3 = <<<SQL3
//    ALTER TABLE {$wpdb->base_prefix}users ADD COLUMN jakit_user_phone_verificated INT(1) DEFAULT 0;
//SQL3;
//
//    $sql_alter4 = <<<SQL4
//    ALTER TABLE {$wpdb->base_prefix}users ADD COLUMN jakit_user_wants_phone INT(1) DEFAULT 0;
//SQL4;
//
////    $wpdb->query($sql_alter1);
//    $wpdb->query($sql_alter2);
//    $wpdb->query($sql_alter3);
//    $wpdb->query($sql_alter4);

    return true;
}

/**
 * Reversing of init action
 * In fact called at time of DELETING plugin
 *
 * @return bool
 */
function jakit_auth_plugin_uninstall_hook ()
{
    /** @var $wpdb wpdb */
    global $wpdb;

    $sql_alter2 = <<<SQL2
    ALTER TABLE {$wpdb->base_prefix}users DROP COLUMN IF EXISTS jakit_user_phone;
SQL2;

    $sql_alter3 = <<<SQL3
    ALTER TABLE {$wpdb->base_prefix}users DROP COLUMN IF EXISTS jakit_user_phone_verificated;
SQL3;

    $sql_alter4 = <<<SQL4
    ALTER TABLE {$wpdb->base_prefix}users DROP COLUMN IF EXISTS jakit_user_wants_phone;
SQL4;

    $wpdb->query($sql_alter2);
    $wpdb->query($sql_alter3);
    $wpdb->query($sql_alter4);

    return true;
}

/**
 * If plugin is active it will turn on session
 * but only if there is no active one...
 */
function oninit()
{
    \Jak\Wordpress\JakitAuthPlugin\Util\Session::create();
}

//register_activation_hook( __FILE__, 'jakit_auth_plugin_activation_hook');
//register_uninstall_hook(__FILE__, 'jakit_auth_plugin_uninstall_hook');
add_action('init', 'oninit', 0);