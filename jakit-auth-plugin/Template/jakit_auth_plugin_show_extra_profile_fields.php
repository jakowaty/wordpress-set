<?php declare(strict_types = 1);

/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

return <<<HTML
<h3 class="jakit-admin-heading">Jakit Auth Plugin</h3>

<div id="jakit-auth-plugin-message-bar" class="hidden"></div>

<table class="form-table ">
    <tr>
        <th><label for="plugin-reset-button">Turn off and reset plugin settings</label></th>
        <td>
            <button id="plugin-reset-button">Reset!</button>
        </td>
    </tr>
    <tr>
        <th>Phone</th>
        <td>
            <span id="phone_display" class="">
                <span id="verificator">$jakit_user_phone_verificated_checked</span>
                <input type="text" disabled="disabled" value="$jakit_user_phone" id="phone_display_msg" class="regular-text" />
                <a href="#" id="change_phone_button">Change</a>
            </span>
            <span id="phone_input" class="hidden">
                <span class="">Enter Your phone</span>
                <input type="text" name="jakit_user_phone" id="jakit_user_phone" value="$jakit_user_phone" class="regular-text" />
                <a href="#" id="send_phone_button">Change</a>
            </span>
            <span id="token_input" class="hidden">
                <span class="">Enter SMS token</span>
                <input type="text" name="jakit_user_token" id="jakit_user_token" value="" class="regular-text" />
                <a href="#" id="send_token_button">Send</a>
            </span><br />
        </td>
    </tr>
    <tr>
        <th><label for="jakit_user_wants_phone">Enabled</label></th>
        <td>
            <input type="checkbox" id="jakit_user_wants_phone_button"  $jakit_user_wants_phone_checked class="regular-text"><br />
            <input type="hidden" id="jakit_user_wants_phone" name="jakit_user_wants_phone" value="$jakit_user_wants_phone">
        </td>
    </tr>
</table>

<script src="$jslib_url"></script>
<script src="$js_url"></script>
HTML;
