/**
 * @Package Jakit Auth Plugin
 * @Version 2.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */
(function(){
    var jakit_auth_plugin_message_bar = document.getElementById("jakit-auth-plugin-message-bar");

    function onclick_reset_plugin_button(e) {
        e.preventDefault();

        var data = {
            action: 'reset_global_auth_plugin',
            do: 'reset'
        };

        data = __http_request_encode(data);

        __request(ajaxurl, 'POST', data, true,
            //callback called on DONE
            function (response) {
                jakit_auth_plugin_message_bar.innerHTML = response.message;
                jakit_auth_plugin_message_bar.classList.remove('hidden');

                if (response.success) {
                    __add_error_class('jakit-auth-plugin-settings-message-bar');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    __add_error_class('jakit-auth-plugin-settings-message-bar');
                    setTimeout(function () {
                        jakit_auth_plugin_message_bar.classList.add("hidden");
                        jakit_auth_plugin_message_bar.innerHTML = '';
                    }, 2000);
                }
            }
        );
    }

    var plugin_reset_button = document.getElementById("plugin-reset-button");
    plugin_reset_button.addEventListener('click', onclick_reset_plugin_button);
})();