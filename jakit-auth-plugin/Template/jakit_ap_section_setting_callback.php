<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

return <<<HTML
<hr>
<h1>Jakit Two Factor Authentification</h1>
<label for="plugin-reset-button">Turn off and reset plugin settings</label>
<button id="plugin-reset-button">Reset!</button>
<hr>

<div id="jakit-auth-plugin-message-bar"></div>

<code>
    You have to provide API url and KEY for plugin.
    Without these settings users can not enable plugin and
    users with plugin enabled will fallback to one step auth.
</code>


<script src="$jslib_url"></script>
<script src="$js_url"></script>
HTML;
