<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

// HTML/CSS/JS printing functions

/**
 * Adds higlight.js components
 *
 * @param string $styleFile choose theme to use (css files)
 */
function bootstrap_highlightjs($styleFile = 'darkula.css')
{
    $styleFile = trim($styleFile, "\t\n\0\r/");
    $themeUrl = content_url('/themes/jakit/js/highlight/');

    $themeCss = $themeUrl . 'styles';
    $themeCssUrl = $themeCss . '/tomorrow-night-blue.css';


    $jsThemeUrl = $themeUrl . 'highlight.pack.js';

    echo <<<SCRIPT
    <link rel="stylesheet" href="$themeCssUrl">
    <script src="$jsThemeUrl"></script>

    <script>hljs.initHighlightingOnLoad();</script>
SCRIPT;
}


add_action('wp_head', 'bootstrap_highlightjs');