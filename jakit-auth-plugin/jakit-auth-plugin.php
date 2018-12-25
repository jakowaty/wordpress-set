<?php
/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */
/*
Plugin Name: Jakit Auth Plugin
Plugin URI: https://herbalist.hekko.pl
Description: Tondz tondz login with second step by sms
Author: Piotr B <herbalist@herbalist.hekko24.pl>
Version: 1.0
Author URI: https://herbalist.hekko24.pl
*/

//include neccessary util objects
require_once 'include.php';



/* INSTALL/UNINSTALL METHODS AND HOOKS*/
require_once 'PartialFunctions/partial-install-hook.php';
/*________________________________________*/



/* BEHAVIOR OF WORDPRESS ADMIN MENU */
require_once 'PartialFunctions/partial-display-hook.php';
/*________________________________________*/



/* WORDPRESS AJAX ACTIONS AND HELPERS */
require_once 'PartialFunctions/partial-ajax-hook.php';
/*________________________________________*/



/*_________HOOK_INTO_LOGIN_PROCESS_______*/
require_once 'PartialFunctions/partial-login-hook.php';
/*________________________________________*/



/*_________HOOK_INTO_COMMON_______________*/
require_once 'PartialFunctions/partial-functions-hook.php';
/*________________________________________*/



/*_________  HOOK_INTO_V2.0_______________*/
require_once 'PartialFunctions/partial-20-hook.php';
/*________________________________________*/

?>