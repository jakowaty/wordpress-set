<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

const IMAGE_THUMB_CSS = 'img-thumbnail img-fluid mx-auto';
const IMAGE_THUMBNAIL_ANCHOR_CSS = 'jakit-thumbnail-img-anchor';
const JAKIT_THEME_URL = '/jakit';


//contact
require_once 'Util/include.php';


//layout functions
require_once 'partial-functions/layout.php';


// pages functions
require_once 'partial-functions/pages.php';


//gallery functions
require_once 'partial-functions/gallery.php';


//helper
require_once 'partial-functions/helper.php';


//archives, tags, categories functions
require_once 'partial-functions/formats.php';


//contactpage functions
require_once 'partial-functions/contact.php';

//admin-bar
require_once 'partial-functions/admin-bar.php';

add_theme_support('post-formats', array('gallery', 'image'));
add_theme_support( 'post-thumbnails' );

