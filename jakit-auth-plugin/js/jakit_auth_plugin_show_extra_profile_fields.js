/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

/**
 * Responsible for Auth Plugin Menu in user profile
 */
(function(){
    var jakit_auth_plugin_message_bar = document.getElementById("jakit-auth-plugin-message-bar");
    var jakit_auth_plugin_settings_message_bar = document.getElementById("jakit-auth-plugin-settings-message-bar");
    var jakit_auth_plugin_phone_verificator = document.getElementById("verificator");

    var phone_display = document.getElementById("phone_display");
    var change_phone_button = document.getElementById("change_phone_button");

    var phone_input = document.getElementById("phone_input");
    var jakit_user_phone = document.getElementById("jakit_user_phone");
    var send_phone_button = document.getElementById("send_phone_button");

    var token_input = document.getElementById("token_input");
    var jakit_user_token = document.getElementById("jakit_user_token");
    var send_token_button = document.getElementById("send_token_button");

    var enabled_button = document.getElementById("jakit_user_wants_phone_button");
    var enabled_input = document.getElementById("jakit_user_wants_phone");

    var phone_display_msg = document.getElementById("phone_display_msg");

    function onclick_change_phone_button(e)
    {
        e.preventDefault();
        phone_display.classList.add("hidden");
        phone_input.classList.remove("hidden");
    }

    function show_display_hide_other()
    {
        phone_display.classList.remove("hidden");
        phone_input.classList.add("hidden");
        token_input.classList.add("hidden");
    }

    function onclick_enable_phone_button(e)
    {
        if (enabled_button.checked) {
            enabled_input.value = "1"
        } else {
            enabled_input.value = "0"
        }
    }

    function onclick_send_phone_button(e)
    {
        e.preventDefault();

        if (jakit_user_phone.value === "") {
            phone_input_msg.innerHTML = "Enter phone number"
            return false;
        }

        var data = {
            action: 'send_phone',
            phone: jakit_user_phone.value
        };

        data = __http_request_encode(data);

        __request(ajaxurl, 'POST', data, true,
            //callback called on DONE
            function(response) {
                jakit_auth_plugin_message_bar.innerHTML = response.message;
                jakit_auth_plugin_message_bar.classList.remove("hidden");

                if (response.success === true) {
                    __add_success_class("jakit-auth-plugin-message-bar");
                    onclick_send_token_button.__proto__.phone = jakit_user_phone.value;
                    phone_input.classList.add("hidden");
                    token_input.classList.remove("hidden");
                } else if (response.error){
                    __add_error_class("jakit-auth-plugin-message-bar");

                    setTimeout(function() {
                        show_display_hide_other();
                    }, 1000);
                }
                console.log(response);
            }

        );
    }

    function onclick_send_token_button(e)
    {
        e.preventDefault();

        var phone = onclick_send_token_button.phone;
        var data = {
            action: 'send_token',
            token: jakit_user_token.value
        };
        data = __http_request_encode(data);

        __request(ajaxurl, 'POST', data, true,
            //callback called on DONE
            function(response) {
                if (response.success) {
                    phone_display_msg.value = phone;
                    jakit_auth_plugin_message_bar.innerHTML = response.message;
                    jakit_auth_plugin_phone_verificator.innerHTML = 'VERIFIED';
                    __add_success_class('jakit-auth-plugin-message-bar');
                    show_display_hide_other();
                } else {
                    jakit_auth_plugin_message_bar.innerHTML = response.message;
                    __add_error_class("jakit-auth-plugin-message-bar");
                    jakit_auth_plugin_message_bar.classList.remove("hidden");
                    setTimeout(function() {
                        jakit_auth_plugin_message_bar.innerHTML = '';
                        jakit_auth_plugin_message_bar.classList.add("hidden");
                        show_display_hide_other();
                    }, 5000);
                }
            }
        );

    }

    function jakit_profile_onload() {
        jakit_auth_plugin_message_bar.innerHTML = '1. Enter phone number, click "Change"<br>';
        jakit_auth_plugin_message_bar.innerHTML += '2. Enter code, click "Send"<br>';
        jakit_auth_plugin_message_bar.innerHTML += '2. After verify phone number click "Update Profile"<br>';
        jakit_auth_plugin_message_bar.classList.remove("hidden");
    }

    /**
     * @TODO: try hit when not logged in - focus on this page then in other window log out =]
     * @param e
     */
    function onclick_reset_plugin_button(e)
    {
        e.preventDefault();

        var data = {
            action: 'reset_auth_plugin',
            do: 'reset'
        };

        data = __http_request_encode(data);

        __request(ajaxurl, 'POST', data, true,
            //callback called on DONE
            function(response) {
                jakit_auth_plugin_message_bar.innerHTML = response.message;
                jakit_auth_plugin_message_bar.classList.remove('hidden');

                if (response.success) {
                    __add_error_class('jakit-auth-plugin-settings-message-bar');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    __add_error_class('jakit-auth-plugin-settings-message-bar');
                    setTimeout(function() {
                        jakit_auth_plugin_message_bar.classList.add("hidden");
                        jakit_auth_plugin_message_bar.innerHTML = '';
                    }, 2000);
                }
            }
        );
    }

    var plugin_reset_button = document.getElementById("plugin-reset-button");
    plugin_reset_button.addEventListener('click', onclick_reset_plugin_button);

    change_phone_button.addEventListener('click', onclick_change_phone_button);
    send_phone_button.addEventListener('click', onclick_send_phone_button);
    send_token_button.addEventListener('click', onclick_send_token_button);
    enabled_button.addEventListener('click', onclick_enable_phone_button);
    window.onload = jakit_profile_onload();

})();